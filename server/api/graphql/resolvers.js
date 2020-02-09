const { resolvers: AuthResolvers } = require('./auth/auth.index');
const { resolvers: GroupResolvers } = require('./group/group.index');
const { resolvers: TaskResolvers } = require('./task/task.index');
const { resolvers: AssignedTaskResolvers } = require('./assignedTask/assignedTask.index');

const resolvers = {
  Query: {
    ...GroupResolvers.queries,
  },
  Mutation: {
    ...AuthResolvers,
    ...GroupResolvers.mutations,
    ...TaskResolvers.mutations,
    ...AssignedTaskResolvers.mutations,
  },
};

module.exports = resolvers;
