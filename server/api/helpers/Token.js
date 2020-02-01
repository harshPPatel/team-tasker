const { sign } = require('jsonwebtoken');

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
}

module.exports = Token;
