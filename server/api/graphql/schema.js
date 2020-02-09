const { gql } = require('apollo-server-express');

const Auth = require('./auth/auth.index');
const Group = require('./group/group.index');
const Task = require('./task/task.index');
const AssignedTask = require('./assignedTask/assignedTask.index');

const typeDefs = gql`
  ${Auth.schema.typeDefs}
  ${Group.schema.typeDefs}
  ${Task.schema.typeDefs}
  ${AssignedTask.schema.typeDefs}

  type Query {
    ${Group.schema.queries}
    ${Task.schema.queries}
  }

  type Mutation {
    ${Auth.schema.mutations}
    ${Group.schema.mutations}
    ${Task.schema.mutations}
    ${AssignedTask.schema.mutations}
  }
`;

module.exports = typeDefs;
