const { resolvers: AuthResolvers } = require('./auth');
const { resolvers: GroupResolvers } = require('./group');

const resolvers = {
  Query: {
    ...GroupResolvers.queries,
  },
  Mutation: {
    ...AuthResolvers,
    ...GroupResolvers.mutations,
  },
};

module.exports = resolvers;
