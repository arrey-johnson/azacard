const express = require('express');
const crypto = require('crypto');
const axios = require('axios');
const { query, transaction } = require('../config/database');
const { auth } = require('../middleware/auth');
const { logger } = require('../utils/logger');

const router = express.Router();

// Helper function to generate card number
const generateCardNumber = () => {
  const prefix = '4532'; // Visa-like prefix
  const randomDigits = Array.from({ length: 12 }, () => Math.floor(Math.random() * 10)).join('');
  return prefix + randomDigits;
};

// Helper function to generate PIN
const generatePIN = () => {
  return Math.floor(1000 + Math.random() * 9000).toString();
};

// Helper function to verify webhook signature
const verifyWebhookSignature = (payload, signature, secret) => {
  const expectedSignature = crypto
    .createHmac('sha256', secret)
    .update(JSON.stringify(payload))
    .digest('hex');
  
  return crypto.timingSafeEqual(
    Buffer.from(signature, 'hex'),
    Buffer.from(expectedSignature, 'hex')
  );
};

/**
 * @swagger
 * /api/v1/payments/card-issuance/{cardId}:
 *   post:
 *     summary: Process card issuance payment
 *     tags: [Payments]
 *     parameters:
 *       - in: path
 *         name: cardId
 *         required: true
 *         schema:
 *           type: string
 *           format: uuid
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required:
 *               - channel
 *               - phoneNumber
 *             properties:
 *               channel:
 *                 type: string
 *                 enum: [MOMO, OM]
 *               phoneNumber:
 *                 type: string
 *     responses:
 *       200:
 *         description: Payment initiated successfully
 *       400:
 *         description: Validation error
 */
router.post('/card-issuance/:cardId', async (req, res) => {
  try {
    const { cardId } = req.params;
    const { channel, phoneNumber } = req.body;

    if (!channel || !phoneNumber) {
      return res.status(400).json({
        success: false,
        error: 'Channel and phone number are required'
      });
    }

    // Get card and transaction details
    const cardResult = await query(
      `SELECT vc.id, vc.currency, vc.status, vc.user_id, t.id as transaction_id, t.amount
       FROM virtual_cards vc
       JOIN transactions t ON vc.id = t.card_id
       WHERE vc.id = ? AND t.type = 'CARD_ISSUANCE' AND t.status = 'PENDING'`,
      [cardId]
    );

    if (cardResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Card or transaction not found'
      });
    }

    const card = cardResult.rows[0];

    if (card.status !== 'PENDING') {
      return res.status(400).json({
        success: false,
        error: 'Card is not in pending status'
      });
    }

    // Generate payment request based on channel
    let paymentRequest;
    if (channel === 'MOMO') {
      paymentRequest = await initiateMoMoPayment({
        amount: card.amount,
        currency: card.currency,
        phoneNumber,
        reference: `CARD_${cardId}`,
        description: 'Virtual Card Issuance Fee'
      });
    } else if (channel === 'OM') {
      paymentRequest = await initiateOrangeMoneyPayment({
        amount: card.amount,
        currency: card.currency,
        phoneNumber,
        reference: `CARD_${cardId}`,
        description: 'Virtual Card Issuance Fee'
      });
    } else {
      return res.status(400).json({
        success: false,
        error: 'Invalid payment channel'
      });
    }

    // Update transaction with external reference
    await query(
      'UPDATE transactions SET external_ref = ?, channel = ? WHERE id = ?',
      [paymentRequest.reference, channel, card.transaction_id]
    );

    logger.info('Card issuance payment initiated', { cardId, channel, amount: card.amount });

    res.json({
      success: true,
      data: {
        paymentUrl: paymentRequest.paymentUrl,
        reference: paymentRequest.reference,
        amount: card.amount,
        currency: card.currency
      }
    });
  } catch (error) {
    logger.error('Card issuance payment error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error during payment processing'
    });
  }
});

/**
 * @swagger
 * /api/v1/payments/load/{transactionId}:
 *   post:
 *     summary: Process load payment
 *     tags: [Payments]
 *     parameters:
 *       - in: path
 *         name: transactionId
 *         required: true
 *         schema:
 *           type: string
 *           format: uuid
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required:
 *               - phoneNumber
 *             properties:
 *               phoneNumber:
 *                 type: string
 *     responses:
 *       200:
 *         description: Payment initiated successfully
 *       400:
 *         description: Validation error
 */
router.post('/load/:transactionId', async (req, res) => {
  try {
    const { transactionId } = req.params;
    const { phoneNumber } = req.body;

    if (!phoneNumber) {
      return res.status(400).json({
        success: false,
        error: 'Phone number is required'
      });
    }

    // Get transaction details
    const transactionResult = await query(
      `SELECT t.id, t.amount, t.channel, t.status, vc.currency, vc.user_id
       FROM transactions t
       JOIN virtual_cards vc ON t.card_id = vc.id
       WHERE t.id = ? AND t.type = 'LOAD' AND t.status = 'PENDING'`,
      [transactionId]
    );

    if (transactionResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Transaction not found or not in pending status'
      });
    }

    const transaction = transactionResult.rows[0];

    // Generate payment request based on channel
    let paymentRequest;
    if (transaction.channel === 'MOMO') {
      paymentRequest = await initiateMoMoPayment({
        amount: transaction.amount,
        currency: transaction.currency,
        phoneNumber,
        reference: `LOAD_${transactionId}`,
        description: 'Card Load Payment'
      });
    } else if (transaction.channel === 'OM') {
      paymentRequest = await initiateOrangeMoneyPayment({
        amount: transaction.amount,
        currency: transaction.currency,
        phoneNumber,
        reference: `LOAD_${transactionId}`,
        description: 'Card Load Payment'
      });
    } else {
      return res.status(400).json({
        success: false,
        error: 'Invalid payment channel'
      });
    }

    // Update transaction with external reference
    await query(
      'UPDATE transactions SET external_ref = ? WHERE id = ?',
      [paymentRequest.reference, transactionId]
    );

    logger.info('Load payment initiated', { transactionId, channel: transaction.channel, amount: transaction.amount });

    res.json({
      success: true,
      data: {
        paymentUrl: paymentRequest.paymentUrl,
        reference: paymentRequest.reference,
        amount: transaction.amount,
        currency: transaction.currency
      }
    });
  } catch (error) {
    logger.error('Load payment error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error during payment processing'
    });
  }
});

/**
 * @swagger
 * /api/v1/payments/webhook:
 *   post:
 *     summary: Payment webhook handler
 *     tags: [Payments]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *     responses:
 *       200:
 *         description: Webhook processed successfully
 *       400:
 *         description: Invalid webhook signature
 */
router.post('/webhook', async (req, res) => {
  try {
    const signature = req.headers['x-webhook-signature'];
    const payload = req.body;

    // Verify webhook signature
    if (!verifyWebhookSignature(payload, signature, process.env.WEBHOOK_SECRET)) {
      logger.warn('Invalid webhook signature', { signature, payload });
      return res.status(400).json({
        success: false,
        error: 'Invalid webhook signature'
      });
    }

    const { reference, status, amount, currency, channel } = payload;

    // Process webhook based on reference type
    if (reference.startsWith('CARD_')) {
      await processCardIssuanceWebhook(reference, status, amount, currency, channel);
    } else if (reference.startsWith('LOAD_')) {
      await processLoadWebhook(reference, status, amount, currency, channel);
    } else if (reference.startsWith('WITHDRAW_')) {
      await processWithdrawWebhook(reference, status, amount, currency, channel);
    } else {
      logger.warn('Unknown webhook reference', { reference });
      return res.status(400).json({
        success: false,
        error: 'Unknown reference type'
      });
    }

    logger.info('Webhook processed successfully', { reference, status });

    res.json({ success: true });
  } catch (error) {
    logger.error('Webhook processing error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error during webhook processing'
    });
  }
});

// Helper functions for payment processing
async function initiateMoMoPayment({ amount, currency, phoneNumber, reference, description }) {
  try {
    const response = await axios.post(`${process.env.MOMO_BASE_URL}/collection`, {
      amount: amount.toString(),
      currency,
      externalId: reference,
      payer: {
        partyIdType: 'MSISDN',
        partyId: phoneNumber
      },
      payerMessage: description,
      payeeNote: description
    }, {
      headers: {
        'Authorization': `Bearer ${process.env.MOMO_API_KEY}`,
        'X-Reference-Id': reference,
        'X-Target-Environment': process.env.NODE_ENV === 'production' ? 'live' : 'sandbox'
      }
    });

    return {
      paymentUrl: response.data.paymentUrl,
      reference: reference
    };
  } catch (error) {
    logger.error('MoMo payment initiation error:', error);
    throw new Error('Failed to initiate MoMo payment');
  }
}

async function initiateOrangeMoneyPayment({ amount, currency, phoneNumber, reference, description }) {
  try {
    const response = await axios.post(`${process.env.ORANGE_MONEY_BASE_URL}/payment`, {
      amount: amount.toString(),
      currency,
      reference,
      phoneNumber,
      description
    }, {
      headers: {
        'Authorization': `Bearer ${process.env.ORANGE_MONEY_API_KEY}`,
        'Content-Type': 'application/json'
      }
    });

    return {
      paymentUrl: response.data.paymentUrl,
      reference: reference
    };
  } catch (error) {
    logger.error('Orange Money payment initiation error:', error);
    throw new Error('Failed to initiate Orange Money payment');
  }
}

async function processCardIssuanceWebhook(reference, status, amount, currency, channel) {
  await transaction(async (connection) => {
    const cardId = reference.replace('CARD_', '');
    
    // Update transaction status
    await connection.execute(
      'UPDATE transactions SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE external_ref = ?',
      [status, reference]
    );

    if (status === 'SUCCESS') {
      // Generate card number and PIN
      const cardNumber = generateCardNumber();
      const pin = generatePIN();
      const pinHash = await require('bcryptjs').hash(pin, 12);

      // Activate card
      await connection.execute(
        'UPDATE virtual_cards SET card_number = ?, pin_hash = ?, status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?',
        [cardNumber, pinHash, 'ACTIVE', cardId]
      );

      // Log audit
      await connection.execute(
        'INSERT INTO audit_logs (user_id, action, resource_type, resource_id, new_values) VALUES ((SELECT user_id FROM virtual_cards WHERE id = ?), ?, ?, ?, ?)',
        [cardId, 'CARD_ACTIVATED', 'virtual_cards', cardId, JSON.stringify({ cardNumber: `${cardNumber.slice(0, 4)}****${cardNumber.slice(-4)}` })]
      );

      logger.info('Card activated successfully', { cardId, cardNumber: `${cardNumber.slice(0, 4)}****${cardNumber.slice(-4)}` });
    }
  });
}

async function processLoadWebhook(reference, status, amount, currency, channel) {
  await transaction(async (connection) => {
    const transactionId = reference.replace('LOAD_', '');
    
    // Update transaction status
    await connection.execute(
      'UPDATE transactions SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE external_ref = ?',
      [status, reference]
    );

    if (status === 'SUCCESS') {
      // Get transaction details
      const [transactionResult] = await connection.execute(
        'SELECT card_id, amount FROM transactions WHERE id = ?',
        [transactionId]
      );

      if (transactionResult.length > 0) {
        const transaction = transactionResult[0];

        // Update card balance
        await connection.execute(
          'UPDATE virtual_cards SET balance = balance + ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?',
          [transaction.amount, transaction.card_id]
        );

        // Log audit
        await connection.execute(
          'INSERT INTO audit_logs (user_id, action, resource_type, resource_id, new_values) VALUES ((SELECT user_id FROM virtual_cards WHERE id = ?), ?, ?, ?, ?)',
          [transaction.card_id, 'CARD_LOADED', 'virtual_cards', transaction.card_id, JSON.stringify({ amount: transaction.amount })]
        );

        logger.info('Card loaded successfully', { cardId: transaction.card_id, amount: transaction.amount });
      }
    }
  });
}

async function processWithdrawWebhook(reference, status, amount, currency, channel) {
  await transaction(async (connection) => {
    const transactionId = reference.replace('WITHDRAW_', '');
    
    // Update transaction status
    await connection.execute(
      'UPDATE transactions SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE external_ref = ?',
      [status, reference]
    );

    if (status === 'SUCCESS') {
      // Get transaction details
      const [transactionResult] = await connection.execute(
        'SELECT card_id, amount FROM transactions WHERE id = ?',
        [transactionId]
      );

      if (transactionResult.length > 0) {
        const transaction = transactionResult[0];

        // Update card balance and withdrawal limits
        await connection.execute(
          `UPDATE virtual_cards 
           SET balance = balance - ?, 
               daily_withdrawal_used = daily_withdrawal_used + ?,
               monthly_withdrawal_used = monthly_withdrawal_used + ?,
               last_withdrawal_date = CURRENT_DATE,
               updated_at = CURRENT_TIMESTAMP 
           WHERE id = ?`,
          [transaction.amount, transaction.amount, transaction.amount, transaction.card_id]
        );

        // Log audit
        await connection.execute(
          'INSERT INTO audit_logs (user_id, action, resource_type, resource_id, new_values) VALUES ((SELECT user_id FROM virtual_cards WHERE id = ?), ?, ?, ?, ?)',
          [transaction.card_id, 'CARD_WITHDRAWN', 'virtual_cards', transaction.card_id, JSON.stringify({ amount: transaction.amount })]
        );

        logger.info('Card withdrawal processed successfully', { cardId: transaction.card_id, amount: transaction.amount });
      }
    }
  });
}

module.exports = router; 