const { sign, verify } = require('jsonwebtoken');
const BlacklistToken = require('../models/BlacklistToken');

class Token {
  constructor(user) {
    this.user = user;
    this.options = {
      algorithm: 'HS256',
      expiresIn: '2 days',
    };
  }

  async generate() {
    // Generating the payload
    const payload = {
      username: this.user.username,
      role: this.user.role,
      theme: this.user.theme,
    };
    const PRIVATE_KEY = process.env.JWT_KEY;
    // Generating and returning the token
    const token = await sign(
      payload,
      PRIVATE_KEY,
      this.options,
    );
    return token;
  }

  static async validate(token) {
    // options for JWT
    const options = {
      algorithm: 'HS256',
      expiresIn: '2 days',
    };
    // Returning the promise
    return new Promise((resolve, reject) => {
      // verifying the token
      verify(token, process.env.JWT_KEY, options, async (err, decoded) => {
        // Rejecting the promise with error
        if (err) {
          reject(new Error('Token is Invalid!'));
        }
        // Checking the token in BlacklistToken
        const blackListToken = await BlacklistToken
          .findOne({ token }).exec();
        // Rejecting with error if token is blacklisted
        if (blackListToken) {
          reject(new Error('Token is Invalid!'));
        }
        // Resolving the promise with the decoded data
        resolve(decoded);
      });
    });
  }
}

module.exports = Token;
