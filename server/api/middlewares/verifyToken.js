const { verify } = require('jsonwebtoken');

const BlacklistToken = require('../models/BlacklistToken');
const User = require('../models/User');

// Private key for generating token
const PRIVATE_KEY = process.env.JWT_KEY;

// JWT Options
const options = {
  algorithm: 'HS256',
  expiresIn: '2 days',
};

/**
 * validates the token from request
 * @param {*} req Request object
 * @param {*} res Response object
 * @param {*} next next function
 */
const validateToken = async (req, res, next) => {
  // Throwing error if authorization header does not exists
  if (!req.headers.authorization) {
    req.isValidToken = false;
    req.error = 'Token is requried';
    next();
    return;
  }

  // Getting token from request
  const token = req.headers.authorization.split(' ')[1];

  // verifying token
  verify(token, PRIVATE_KEY, options, async (err, decoded) => {
    if (err) {
      req.isValidToken = false;
      req.error = 'Token is Invalid!';
      next();
      return;
    }
    // Checking if token is not blacklisted
    const blackListToken = await BlacklistToken
      .findOne({ token }).exec();
    if (blackListToken) {
      req.isValidToken = false;
      req.error = 'Token is Invalid!';
      next();
      return;
    }

    // Finding user in database
    const user = User.findOne({ username: decoded.username }).exec();

    // Throwing the error if user does not exists
    if (!user) {
      res.status(404);
      res.json({
        message: 'User does not exists.',
      });
      return;
    }

    // adding data to request object
    req.username = decoded.username;
    req.isValidToken = true;
    req.token = token;
    req.user = user;
    next();
  });
};

module.exports = validateToken;
