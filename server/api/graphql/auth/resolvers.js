const { hash, compare } = require('bcryptjs');
const { ApolloError, ValidationError } = require('apollo-server-express');

const AuthValidator = require('../../validators/auth');
const User = require('../../models/User');
const Token = require('../../helpers/Token');
const BlacklistToken = require('../../models/BlacklistToken');

const signup = (_, args) => (
  AuthValidator.signup(args.input)
    .then(({ value: data }) => {
      const user = new User({
        username: data.username.toString(),
        password: data.password.toString(),
      });

      // Hashing the password
      return hash(
        user.password,
        Number(process.env.HASH_SALT_ROUNDS) || 10,
      )
        .then(async (hashed) => {
          user.password = hashed;
          const final = await user.save()
            .then((result) => result)
            .catch((err) => new ApolloError(err.message));
          return final;
        });
    })
    .catch((err) => err)
);

const login = (_, args) => (
  AuthValidator.login(args.input)
    .then(async ({ value: data }) => {
      const user = await User.findOne({ username: data.username }).exec();

      if (!user) {
        return new ApolloError('Invalid username or password');
      }
      const response = { user };
      return compare(data.password, user.password)
        .then((res) => {
          if (!res) {
            return new ApolloError('Invalid username or password');
          }
          const tokenGenerator = new Token(user);
          response.token = tokenGenerator.generate();
          return response;
        });
    })
    .catch((err) => err)
);

const logout = (_, args) => (
  // Validating the token
  Token.validate(args.token)
    .then(async (decoded) => {
      // Blacklsiting the token
      const blacklistToken = new BlacklistToken({
        token: args.token,
      });
      // Saving the token to BlacklistToken
      const response = await blacklistToken.save()
        .then(() => ({
          username: decoded.username,
          message: 'User has been logged out successfully.',
          loggedOutAt: Date.now(),
        }))
        .catch((err) => new ValidationError(err.message));
      // returning the response
      return response;
    })
    .catch((err) => new ValidationError(err.message))
);

module.exports = {
  login,
  signup,
  logout,
};
