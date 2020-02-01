const { hash, compare } = require('bcryptjs');
const { ApolloError } = require('apollo-server-express');

const AuthValidator = require('../validators/auth');
const User = require('../models/User');
const Token = require('../helpers/Token');

const resolvers = {
  Query: {
    test: () => 'test',
  },
  Mutation: {
    signup: (_, args) => (
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
    ),
    login: (_, args) => (
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
                return new ApolloError('Invalid token');
              }
              const tokenGenerator = new Token(user);
              response.token = tokenGenerator.generate();
              return response;
            });
        })
        .catch((err) => err)
    ),
  },
};

module.exports = resolvers;
