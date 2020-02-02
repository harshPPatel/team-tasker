const { gql } = require('apollo-server-express');

const Auth = require('./auth');

const typeDefs = gql`
  ${Auth.schema.typeDefs}

  type Query {
    test: String
  }

  type Mutation {
    ${Auth.schema.mutations}
  }
`;

module.exports = typeDefs;
