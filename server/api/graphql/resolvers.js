const { resolvers: AuthResolvers } = require('./auth');

const resolvers = {
  Query: {
    test: () => 'test',
  },
  Mutation: {
    ...AuthResolvers,
  },
};

module.exports = resolvers;
