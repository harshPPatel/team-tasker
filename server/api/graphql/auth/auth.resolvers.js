const { hash, compare } = require('bcryptjs');
const { ApolloError, ValidationError, AuthenticationError } = require('apollo-server-express');

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

const logout = async (_, args, context) => {
  // Throwing the error if token is not valid
  if (!context.isValidToken) {
    return new AuthenticationError('Token is invalid!');
  }
  // Blacklsiting the token
  const blacklistToken = new BlacklistToken({
    token: context.token,
  });
  // Saving the token to BlacklistToken
  const response = await blacklistToken.save()
    .then(() => ({
      username: context.username,
      message: 'User has been logged out successfully.',
      loggedOutAt: Date.now(),
    }))
    .catch((err) => new ValidationError(err.message));
  // Returning the response
  return response;
};

const verify = (_, args, context) => {
  console.log(context);
  // Throwing the error if token is not valid
  if (!context.isValidToken) {
    return new AuthenticationError('Token is required');
  }
  // Otherwise returning the response
  return {
    username: context.username,
    message: 'Token is Valid!',
  };
};

module.exports = {
  login,
  signup,
  logout,
  verify,
};
