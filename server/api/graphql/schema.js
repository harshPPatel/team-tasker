const { gql } = require('apollo-server-express');

const Auth = require('./auth');
const Group = require('./group');

const typeDefs = gql`
  ${Auth.schema.typeDefs}
  ${Group.schema.typeDefs}

  type Query {
    ${Group.schema.queries}
  }

  type Mutation {
    ${Auth.schema.mutations}
    ${Group.schema.mutations}
  }
`;

module.exports = typeDefs;
