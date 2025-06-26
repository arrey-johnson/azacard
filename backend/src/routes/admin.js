const express = require('express');
const Joi = require('joi');
const { query } = require('../config/database');
const { adminAuth } = require('../middleware/auth');
const { logger } = require('../utils/logger');

const router = express.Router();

// Validation schemas
const updateKycSchema = Joi.object({
  status: Joi.string().valid('APPROVED', 'REJECTED').required(),
  reason: Joi.string().when('status', {
    is: 'REJECTED',
    then: Joi.required(),
    otherwise: Joi.optional()
  })
});

const updateCardStatusSchema = Joi.object({
  status: Joi.string().valid('ACTIVE', 'SUSPENDED').required(),
  reason: Joi.string().optional()
});

const updateConfigSchema = Joi.object({
  value: Joi.object().required()
});

/**
 * @swagger
 * /api/v1/admin/users:
 *   get:
 *     summary: Get all users with filtering
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
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
 *         name: kycStatus
 *         schema:
 *           type: string
 *           enum: [PENDING, APPROVED, REJECTED]
 *       - in: query
 *         name: search
 *         schema:
 *           type: string
 *     responses:
 *       200:
 *         description: Users retrieved successfully
 *       401:
 *         description: Unauthorized
 */
router.get('/users', adminAuth, async (req, res) => {
  try {
    const { page = 1, limit = 10, kycStatus, search } = req.query;

    // Build query
    let queryText = `
      SELECT id, name, email, phone, kyc_status, email_verified, phone_verified, created_at, updated_at
      FROM users
      WHERE 1=1
    `;
    let queryParams = [];

    if (kycStatus) {
      queryText += ' AND kyc_status = ?';
      queryParams.push(kycStatus);
    }

    if (search) {
      queryText += ' AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)';
      queryParams.push(`%${search}%`, `%${search}%`, `%${search}%`);
    }

    // Get total count
    const countQuery = queryText.replace(/SELECT.*FROM/, 'SELECT COUNT(*) as total FROM');
    const countResult = await query(countQuery, queryParams);
    const total = parseInt(countResult.rows[0].total);

    // Add pagination
    queryText += ' ORDER BY created_at DESC LIMIT ? OFFSET ?';
    queryParams.push(parseInt(limit), (parseInt(page) - 1) * parseInt(limit));

    const result = await query(queryText, queryParams);

    res.json({
      success: true,
      data: {
        users: result.rows.map(user => ({
          id: user.id,
          name: user.name,
          email: user.email,
          phone: user.phone,
          kycStatus: user.kyc_status,
          emailVerified: user.email_verified,
          phoneVerified: user.phone_verified,
          createdAt: user.created_at,
          updatedAt: user.updated_at
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
    logger.error('Get users error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while retrieving users'
    });
  }
});

/**
 * @swagger
 * /api/v1/admin/users/{userId}/kyc:
 *   put:
 *     summary: Update user KYC status
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: userId
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
 *               - status
 *             properties:
 *               status:
 *                 type: string
 *                 enum: [APPROVED, REJECTED]
 *               reason:
 *                 type: string
 *     responses:
 *       200:
 *         description: KYC status updated successfully
 *       400:
 *         description: Validation error
 */
router.put('/users/:userId/kyc', adminAuth, async (req, res) => {
  try {
    const { userId } = req.params;

    // Validate input
    const { error, value } = updateKycSchema.validate(req.body);
    if (error) {
      return res.status(400).json({
        success: false,
        error: error.details[0].message
      });
    }

    const { status, reason } = value;

    // Check if user exists
    const userResult = await query(
      'SELECT id, kyc_status FROM users WHERE id = ?',
      [userId]
    );

    if (userResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'User not found'
      });
    }

    // Update KYC status
    await query(
      'UPDATE users SET kyc_status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?',
      [status, userId]
    );

    // Log audit
    await query(
      'INSERT INTO audit_logs (user_id, action, resource_type, resource_id, old_values, new_values) VALUES (?, ?, ?, ?, ?, ?)',
      [userId, 'KYC_STATUS_UPDATED', 'users', userId, 
       JSON.stringify({ kycStatus: userResult.rows[0].kyc_status }), 
       JSON.stringify({ kycStatus: status, reason })]
    );

    logger.info('KYC status updated', { userId, status, reason });

    res.json({
      success: true,
      data: {
        message: `KYC status updated to ${status}`,
        reason: reason || null
      }
    });
  } catch (error) {
    logger.error('Update KYC error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while updating KYC status'
    });
  }
});

/**
 * @swagger
 * /api/v1/admin/cards:
 *   get:
 *     summary: Get all cards with filtering
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
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
 *         name: status
 *         schema:
 *           type: string
 *           enum: [PENDING, ACTIVE, SUSPENDED]
 *       - in: query
 *         name: currency
 *         schema:
 *           type: string
 *     responses:
 *       200:
 *         description: Cards retrieved successfully
 *       401:
 *         description: Unauthorized
 */
router.get('/cards', adminAuth, async (req, res) => {
  try {
    const { page = 1, limit = 10, status, currency } = req.query;

    // Build query
    let queryText = `
      SELECT vc.id, vc.card_number, vc.currency, vc.status, vc.balance, vc.created_at, vc.updated_at,
             u.name as user_name, u.email as user_email, u.phone as user_phone
      FROM virtual_cards vc
      JOIN users u ON vc.user_id = u.id
      WHERE 1=1
    `;
    let queryParams = [];

    if (status) {
      queryText += ' AND vc.status = ?';
      queryParams.push(status);
    }

    if (currency) {
      queryText += ' AND vc.currency = ?';
      queryParams.push(currency);
    }

    // Get total count
    const countQuery = queryText.replace(/SELECT.*FROM/, 'SELECT COUNT(*) as total FROM');
    const countResult = await query(countQuery, queryParams);
    const total = parseInt(countResult.rows[0].total);

    // Add pagination
    queryText += ' ORDER BY vc.created_at DESC LIMIT ? OFFSET ?';
    queryParams.push(parseInt(limit), (parseInt(page) - 1) * parseInt(limit));

    const result = await query(queryText, queryParams);

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
          updatedAt: card.updated_at,
          user: {
            name: card.user_name,
            email: card.user_email,
            phone: card.user_phone
          }
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
    logger.error('Get cards error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while retrieving cards'
    });
  }
});

/**
 * @swagger
 * /api/v1/admin/cards/{cardId}/status:
 *   put:
 *     summary: Update card status
 *     tags: [Admin]
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
 *               - status
 *             properties:
 *               status:
 *                 type: string
 *                 enum: [ACTIVE, SUSPENDED]
 *               reason:
 *                 type: string
 *     responses:
 *       200:
 *         description: Card status updated successfully
 *       400:
 *         description: Validation error
 */
router.put('/cards/:cardId/status', adminAuth, async (req, res) => {
  try {
    const { cardId } = req.params;

    // Validate input
    const { error, value } = updateCardStatusSchema.validate(req.body);
    if (error) {
      return res.status(400).json({
        success: false,
        error: error.details[0].message
      });
    }

    const { status, reason } = value;

    // Check if card exists
    const cardResult = await query(
      'SELECT id, status, user_id FROM virtual_cards WHERE id = ?',
      [cardId]
    );

    if (cardResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Card not found'
      });
    }

    const card = cardResult.rows[0];

    // Update card status
    await query(
      'UPDATE virtual_cards SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?',
      [status, cardId]
    );

    // Log audit
    await query(
      'INSERT INTO audit_logs (user_id, action, resource_type, resource_id, old_values, new_values) VALUES (?, ?, ?, ?, ?, ?)',
      [card.user_id, 'CARD_STATUS_UPDATED', 'virtual_cards', cardId, 
       JSON.stringify({ status: card.status }), 
       JSON.stringify({ status, reason })]
    );

    logger.info('Card status updated', { cardId, status, reason });

    res.json({
      success: true,
      data: {
        message: `Card status updated to ${status}`,
        reason: reason || null
      }
    });
  } catch (error) {
    logger.error('Update card status error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while updating card status'
    });
  }
});

/**
 * @swagger
 * /api/v1/admin/transactions:
 *   get:
 *     summary: Get all transactions with filtering
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
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
 *       - in: query
 *         name: status
 *         schema:
 *           type: string
 *           enum: [PENDING, SUCCESS, FAILED]
 *       - in: query
 *         name: channel
 *         schema:
 *           type: string
 *           enum: [MOMO, OM]
 *     responses:
 *       200:
 *         description: Transactions retrieved successfully
 *       401:
 *         description: Unauthorized
 */
router.get('/transactions', adminAuth, async (req, res) => {
  try {
    const { page = 1, limit = 10, type, status, channel } = req.query;

    // Build query
    let queryText = `
      SELECT t.id, t.type, t.amount, t.channel, t.status, t.fee_amount, t.net_amount, 
             t.description, t.external_ref, t.created_at, t.updated_at,
             vc.card_number, vc.currency,
             u.name as user_name, u.email as user_email
      FROM transactions t
      JOIN virtual_cards vc ON t.card_id = vc.id
      JOIN users u ON vc.user_id = u.id
      WHERE 1=1
    `;
    let queryParams = [];

    if (type) {
      queryText += ' AND t.type = ?';
      queryParams.push(type);
    }

    if (status) {
      queryText += ' AND t.status = ?';
      queryParams.push(status);
    }

    if (channel) {
      queryText += ' AND t.channel = ?';
      queryParams.push(channel);
    }

    // Get total count
    const countQuery = queryText.replace(/SELECT.*FROM/, 'SELECT COUNT(*) as total FROM');
    const countResult = await query(countQuery, queryParams);
    const total = parseInt(countResult.rows[0].total);

    // Add pagination
    queryText += ' ORDER BY t.created_at DESC LIMIT ? OFFSET ?';
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
          externalRef: tx.external_ref,
          createdAt: tx.created_at,
          updatedAt: tx.updated_at,
          card: {
            cardNumber: tx.card_number ? `${tx.card_number.slice(0, 4)}****${tx.card_number.slice(-4)}` : null,
            currency: tx.currency
          },
          user: {
            name: tx.user_name,
            email: tx.user_email
          }
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

/**
 * @swagger
 * /api/v1/admin/config:
 *   get:
 *     summary: Get system configuration
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Configuration retrieved successfully
 *       401:
 *         description: Unauthorized
 */
router.get('/config', adminAuth, async (req, res) => {
  try {
    const result = await query(
      'SELECT `key`, value, description, updated_at FROM config ORDER BY `key`'
    );

    res.json({
      success: true,
      data: {
        config: result.rows.map(config => ({
          key: config.key,
          value: config.value,
          description: config.description,
          updatedAt: config.updated_at
        }))
      }
    });
  } catch (error) {
    logger.error('Get config error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while retrieving configuration'
    });
  }
});

/**
 * @swagger
 * /api/v1/admin/config/{key}:
 *   put:
 *     summary: Update system configuration
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     parameters:
 *       - in: path
 *         name: key
 *         required: true
 *         schema:
 *           type: string
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             required:
 *               - value
 *             properties:
 *               value:
 *                 type: object
 *     responses:
 *       200:
 *         description: Configuration updated successfully
 *       400:
 *         description: Validation error
 */
router.put('/config/:key', adminAuth, async (req, res) => {
  try {
    const { key } = req.params;

    // Validate input
    const { error, value } = updateConfigSchema.validate(req.body);
    if (error) {
      return res.status(400).json({
        success: false,
        error: error.details[0].message
      });
    }

    const { value: configValue } = value;

    // Check if config exists
    const configResult = await query(
      'SELECT `key`, value FROM config WHERE `key` = ?',
      [key]
    );

    if (configResult.rows.length === 0) {
      return res.status(404).json({
        success: false,
        error: 'Configuration key not found'
      });
    }

    // Update config
    await query(
      'UPDATE config SET value = ?, updated_at = CURRENT_TIMESTAMP WHERE `key` = ?',
      [JSON.stringify(configValue), key]
    );

    // Log audit
    await query(
      'INSERT INTO audit_logs (action, resource_type, resource_id, old_values, new_values) VALUES (?, ?, ?, ?, ?)',
      ['CONFIG_UPDATED', 'config', key, 
       JSON.stringify({ value: configResult.rows[0].value }), 
       JSON.stringify({ value: configValue })]
    );

    logger.info('Configuration updated', { key, value: configValue });

    res.json({
      success: true,
      data: {
        message: 'Configuration updated successfully'
      }
    });
  } catch (error) {
    logger.error('Update config error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while updating configuration'
    });
  }
});

/**
 * @swagger
 * /api/v1/admin/dashboard:
 *   get:
 *     summary: Get admin dashboard statistics
 *     tags: [Admin]
 *     security:
 *       - bearerAuth: []
 *     responses:
 *       200:
 *         description: Dashboard statistics retrieved successfully
 *       401:
 *         description: Unauthorized
 */
router.get('/dashboard', adminAuth, async (req, res) => {
  try {
    // Get various statistics
    const [
      totalUsers,
      pendingKyc,
      totalCards,
      activeCards,
      totalTransactions,
      totalVolume,
      todayTransactions,
      todayVolume
    ] = await Promise.all([
      query('SELECT COUNT(*) as total FROM users'),
      query("SELECT COUNT(*) as total FROM users WHERE kyc_status = 'PENDING'"),
      query('SELECT COUNT(*) as total FROM virtual_cards'),
      query("SELECT COUNT(*) as total FROM virtual_cards WHERE status = 'ACTIVE'"),
      query('SELECT COUNT(*) as total FROM transactions'),
      query('SELECT COALESCE(SUM(amount), 0) as total FROM transactions WHERE status = \'SUCCESS\''),
      query("SELECT COUNT(*) as total FROM transactions WHERE DATE(created_at) = CURRENT_DATE"),
      query("SELECT COALESCE(SUM(amount), 0) as total FROM transactions WHERE status = 'SUCCESS' AND DATE(created_at) = CURRENT_DATE")
    ]);

    // Get recent transactions
    const recentTransactions = await query(`
      SELECT t.type, t.amount, t.status, t.created_at, u.name as user_name
      FROM transactions t
      JOIN virtual_cards vc ON t.card_id = vc.id
      JOIN users u ON vc.user_id = u.id
      ORDER BY t.created_at DESC
      LIMIT 10
    `);

    res.json({
      success: true,
      data: {
        statistics: {
          totalUsers: parseInt(totalUsers.rows[0].total),
          pendingKyc: parseInt(pendingKyc.rows[0].total),
          totalCards: parseInt(totalCards.rows[0].total),
          activeCards: parseInt(activeCards.rows[0].total),
          totalTransactions: parseInt(totalTransactions.rows[0].total),
          totalVolume: parseFloat(totalVolume.rows[0].total),
          todayTransactions: parseInt(todayTransactions.rows[0].total),
          todayVolume: parseFloat(todayVolume.rows[0].total)
        },
        recentTransactions: recentTransactions.rows.map(tx => ({
          type: tx.type,
          amount: parseFloat(tx.amount),
          status: tx.status,
          createdAt: tx.created_at,
          userName: tx.user_name
        }))
      }
    });
  } catch (error) {
    logger.error('Get dashboard error:', error);
    res.status(500).json({
      success: false,
      error: 'Server error while retrieving dashboard statistics'
    });
  }
});

module.exports = router; 