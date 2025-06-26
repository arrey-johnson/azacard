const express = require('express');
const Joi = require('joi');
const bcrypt = require('bcryptjs');
const { query, transaction } = require('../config/database');
const { auth } = require('../middleware/auth');
const { logger } = require('../utils/logger');

const router = express.Router();

// Validation schemas
const createCardSchema = Joi.object({
  currency: Joi.string().length(3).default('XAF'),
  tier: Joi.string().valid('basic', 'premium', 'vip').default('basic')
});

const loadCardSchema = Joi.object({
  amount: Joi.number().positive().required(),
  channel: Joi.string().valid('MOMO', 'OM').required()
});

const withdrawSchema = Joi.object({
  amount: Joi.number().positive().required(),
  channel: Joi.string().valid('MOMO', 'OM').required(),
  destinationNumber: Joi.string().required()
});

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

/**
 * @swagger
 * /api/v1/cards/create:
 *   post:
 *     summary: Create a new virtual card
 *     tags: [Cards]
 *     security:
 *       - bearerAuth: []
 *     requestBody:
 *       required: false
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               currency:
 *                 type: string
 *                 default: "XAF"
 *               tier:
 *                 type: string
 *                 enum: [basic, premium, vip]
 *                 default: "basic"
 *     responses:
 *       201:
 *         description: Card created successfully
 *       400:
 *         description: Validation error or KYC not approved
 *       401:
 *         description: Unauthorized
 */
router.post('/create', auth, async (req, res) => {
  try {
    // Check KYC status
    if (req.user.kyc_status !== 'APPROVED') {
      return res.status(400).json({
        success: false,
        error: 'KYC must be approved before creating a card'
      });
    }

    // Validate input
    const { error, value } = createCardSchema.validate(req.body);
    if (error) {
      return res.status(400).json({
        success: false,
        error: error.details[0].message
      });
    }

    const { currency, tier } = value;

    const result = await transaction(async (connection) => {
      // Get card issuance fee from config
      const [configResult] = await connection.execute(
        'SELECT value FROM config WHERE `key` = ?',
        ['card_issuance_fee']
      );
      
      const issuanceFee = configResult[0]?.value?.XAF || 500;

      // Create pending card
      const [cardResult] = await connection.execute(
        'INSERT INTO virtual_cards (user_id, currency, status) VALUES (?, ?, ?)',
        [req.user.id, currency, 'PENDING']
      );

      const cardId = cardResult.insertId;

      // Create transaction record for card issuance fee
      await connection.execute(
        'INSERT INTO transactions (card_id, type, amount, channel, status, fee_amount, net_amount, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
        [cardId, 'CARD_ISSUANCE', issuanceFee, null, 'PENDING', 0, issuanceFee, `Card issuance fee for ${tier} tier`]
      );

      return { cardId, issuanceFee, currency };
    });

    logger.info('Card creation initiated', { userId: req.user.id, cardId: result.cardId });

    res.status(201).json({
      success: true,
      data: {
        card: {
          id: result.cardId,
          currency: result.currency,
          status: 'PENDING',
          issuanceFee: result.issuanceFee,
          paymentInstructions: {
            amount: result.issuanceFee,
            currency: result.currency,
            paymentUrl: `${process.env.API_BASE_URL}/api/v1/payments/card-issuance/${result.cardId}`
          }
        }
      }
    });
  } catch (error) {
    logger.error('Card creation error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error during card creation'
    });
  }
});

/**
 * @swagger
 * /api/v1/cards:
 *   get:
 *     summary: Get user's cards
 *     tags: [Cards]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Cards retrieved successfully
 *       401:
 *         description: Unauthorized
 */
router.get('/', auth, async (req, res) => {
  try {
    const result = await query(
      `SELECT id, card_number, currency, status, balance, created_at, updated_at 
       FROM virtual_cards 
       WHERE user_id = ? 
       ORDER BY created_at DESC`,
      [req.user.id]
    );

    res.json({
      success: true,
      data: {
        cards: result.rows.map(card => ({
          id: card.id,
          cardNumber: card.card_number ? `${card.card_number.slice(0, 4)}****${card.card_number.slice(-4)}` : null,
          currency: card.currency,
          status: card.status,
          balance: parseFloat(card.balance),
          createdAt: card.created_at,
          updatedAt: card.updated_at
        }))
      }
    });
  } catch (error) {
    logger.error('Get cards error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while retrieving cards'
    });
  }
});

/**
 * @swagger
 * /api/v1/cards/{cardId}/balance:
 *   get:
 *     summary: Get card balance
 *     tags: [Cards]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: cardId
 *         required: true
 *         schema:
 *           type: string
 *           format: uuid
 *     responses:
 *       200:
 *         description: Balance retrieved successfully
 *       404:
 *         description: Card not found
 */
router.get('/:cardId/balance', auth, async (req, res) => {
  try {
    const { cardId } = req.params;

    const result = await query(
      'SELECT id, currency, balance, status FROM virtual_cards WHERE id = ? AND user_id = ?',
      [cardId, req.user.id]
    );

    if (result.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Card not found'
      });
    }

    const card = result.rows[0];

    res.json({
      success: true,
      data: {
        cardId: card.id,
        currency: card.currency,
        availableBalance: parseFloat(card.balance),
        status: card.status
      }
    });
  } catch (error) {
    logger.error('Get balance error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while retrieving balance'
    });
  }
});

/**
 * @swagger
 * /api/v1/cards/{cardId}/load:
 *   post:
 *     summary: Load funds to card
 *     tags: [Cards]
 *     security:
 *       - bearerAuth: []
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
 *               - amount
 *               - channel
 *             properties:
 *               amount:
 *                 type: number
 *                 minimum: 1000
 *               channel:
 *                 type: string
 *                 enum: [MOMO, OM]
 *     responses:
 *       200:
 *         description: Load initiated successfully
 *       400:
 *         description: Validation error
 */
router.post('/:cardId/load', auth, async (req, res) => {
  try {
    const { cardId } = req.params;

    // Validate input
    const { error, value } = loadCardSchema.validate(req.body);
    if (error) {
      return res.status(400).json({
        success: false,
        error: error.details[0].message
      });
    }

    const { amount, channel } = value;

    // Check if card exists and belongs to user
    const cardResult = await query(
      'SELECT id, currency, status FROM virtual_cards WHERE id = ? AND user_id = ?',
      [cardId, req.user.id]
    );

    if (cardResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Card not found'
      });
    }

    const card = cardResult.rows[0];

    if (card.status !== 'ACTIVE') {
      return res.status(400).json({
        success: false,
        error: 'Card is not active'
      });
    }

    // Check minimum load amount
    const configResult = await query(
      'SELECT value FROM config WHERE `key` = ?',
      ['min_load_amount']
    );
    
    const minAmount = configResult.rows[0]?.value?.XAF || 1000;

    if (amount < minAmount) {
      return res.status(400).json({
        success: false,
        error: `Minimum load amount is ${minAmount} ${card.currency}`
      });
    }

    // Create transaction record
    const transactionResult = await query(
      'INSERT INTO transactions (card_id, type, amount, channel, status, fee_amount, net_amount, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
      [cardId, 'LOAD', amount, channel, 'PENDING', 0, amount, `Load via ${channel}`]
    );

    const transactionId = transactionResult.rows.insertId;

    logger.info('Load initiated', { userId: req.user.id, cardId, amount, channel });

    res.json({
      success: true,
      data: {
        transactionId,
        amount,
        currency: card.currency,
        channel,
        paymentUrl: `${process.env.API_BASE_URL}/api/v1/payments/load/${transactionId}`
      }
    });
  } catch (error) {
    logger.error('Load error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error during load process'
    });
  }
});

/**
 * @swagger
 * /api/v1/cards/{cardId}/withdraw:
 *   post:
 *     summary: Withdraw funds from card
 *     tags: [Cards]
 *     security:
 *       - bearerAuth: []
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
 *               - amount
 *               - channel
 *               - destinationNumber
 *             properties:
 *               amount:
 *                 type: number
 *                 minimum: 1000
 *               channel:
 *                 type: string
 *                 enum: [MOMO, OM]
 *               destinationNumber:
 *                 type: string
 *     responses:
 *       200:
 *         description: Withdrawal initiated successfully
 *       400:
 *         description: Validation error or insufficient funds
 */
router.post('/:cardId/withdraw', auth, async (req, res) => {
  try {
    const { cardId } = req.params;

    // Validate input
    const { error, value } = withdrawSchema.validate(req.body);
    if (error) {
      return res.status(400).json({
        success: false,
        error: error.details[0].message
      });
    }

    const { amount, channel, destinationNumber } = value;

    // Check if card exists and belongs to user
    const cardResult = await query(
      'SELECT id, currency, balance, status, daily_withdrawal_used, monthly_withdrawal_used FROM virtual_cards WHERE id = ? AND user_id = ?',
      [cardId, req.user.id]
    );

    if (cardResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Card not found'
      });
    }

    const card = cardResult.rows[0];

    if (card.status !== 'ACTIVE') {
      return res.status(400).json({
        success: false,
        error: 'Card is not active'
      });
    }

    // Check sufficient balance
    if (parseFloat(card.balance) < amount) {
      return res.status(400).json({
        success: false,
        error: 'Insufficient balance'
      });
    }

    // Check withdrawal limits
    const today = new Date().toISOString().split('T')[0];
    const thisMonth = new Date().toISOString().slice(0, 7);

    const configResult = await query(
      'SELECT value FROM config WHERE `key` IN (?, ?)',
      ['max_daily_withdrawal', 'max_monthly_withdrawal']
    );

    const maxDaily = configResult.rows.find(r => r.key === 'max_daily_withdrawal')?.value?.XAF || 50000;
    const maxMonthly = configResult.rows.find(r => r.key === 'max_monthly_withdrawal')?.value?.XAF || 500000;

    if (parseFloat(card.daily_withdrawal_used) + amount > maxDaily) {
      return res.status(400).json({
        success: false,
        error: `Daily withdrawal limit exceeded. Maximum: ${maxDaily} ${card.currency}`
      });
    }

    if (parseFloat(card.monthly_withdrawal_used) + amount > maxMonthly) {
      return res.status(400).json({
        success: false,
        error: `Monthly withdrawal limit exceeded. Maximum: ${maxMonthly} ${card.currency}`
      });
    }

    // Create transaction record
    const transactionResult = await query(
      'INSERT INTO transactions (card_id, type, amount, channel, status, fee_amount, net_amount, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
      [cardId, 'WITHDRAW', amount, channel, 'PENDING', 0, amount, `Withdrawal to ${destinationNumber} via ${channel}`]
    );

    const transactionId = transactionResult.rows.insertId;

    logger.info('Withdrawal initiated', { userId: req.user.id, cardId, amount, channel, destinationNumber });

    res.json({
      success: true,
      data: {
        transactionId,
        amount,
        currency: card.currency,
        channel,
        destinationNumber,
        status: 'PENDING'
      }
    });
  } catch (error) {
    logger.error('Withdrawal error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error during withdrawal process'
    });
  }
});

/**
 * @swagger
 * /api/v1/cards/{cardId}/transactions:
 *   get:
 *     summary: Get card transaction history
 *     tags: [Cards]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: cardId
 *         required: true
 *         schema:
 *           type: string
 *           format: uuid
 *       - in: query
 *         name: page
 *         schema:
 *           type: integer
 *           default: 1
 *       - in: query
 *         name: limit
 *         schema:
 *           type: integer
 *           default: 10
 *       - in: query
 *         name: type
 *         schema:
 *           type: string
 *           enum: [LOAD, WITHDRAW, CARD_ISSUANCE]
 *     responses:
 *       200:
 *         description: Transactions retrieved successfully
 *       404:
 *         description: Card not found
 */
router.get('/:cardId/transactions', auth, async (req, res) => {
  try {
    const { cardId } = req.params;
    const { page = 1, limit = 10, type } = req.query;

    // Check if card exists and belongs to user
    const cardResult = await query(
      'SELECT id FROM virtual_cards WHERE id = ? AND user_id = ?',
      [cardId, req.user.id]
    );

    if (cardResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Card not found'
      });
    }

    // Build query
    let queryText = `
      SELECT id, type, amount, channel, status, fee_amount, net_amount, description, created_at, updated_at
      FROM transactions 
      WHERE card_id = ?
    `;
    let queryParams = [cardId];

    if (type) {
      queryText += ' AND type = ?';
      queryParams.push(type);
    }

    // Get total count
    let countQuery = 'SELECT COUNT(*) as total FROM transactions WHERE card_id = ?';
    let countParams = [cardId];

    if (type) {
      countQuery += ' AND type = ?';
      countParams.push(type);
    }

    const countResult = await query(countQuery, countParams);
    const total = parseInt(countResult.rows[0].total);

    // Add pagination
    queryText += ' ORDER BY created_at DESC LIMIT ? OFFSET ?';
    queryParams.push(parseInt(limit), (parseInt(page) - 1) * parseInt(limit));

    const result = await query(queryText, queryParams);

    res.json({
      success: true,
      data: {
        transactions: result.rows.map(tx => ({
          id: tx.id,
          type: tx.type,
          amount: parseFloat(tx.amount),
          channel: tx.channel,
          status: tx.status,
          feeAmount: parseFloat(tx.fee_amount),
          netAmount: parseFloat(tx.net_amount),
          description: tx.description,
          createdAt: tx.created_at,
          updatedAt: tx.updated_at
        })),
        pagination: {
          page: parseInt(page),
          limit: parseInt(limit),
          total,
          pages: Math.ceil(total / parseInt(limit))
        }
      }
    });
  } catch (error) {
    logger.error('Get transactions error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while retrieving transactions'
    });
  }
});

module.exports = router; 