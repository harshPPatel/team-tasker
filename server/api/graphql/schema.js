const { gql } = require('apollo-server-express');

const Auth = require('./auth/auth.index');
const Group = require('./group/group.index');

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
