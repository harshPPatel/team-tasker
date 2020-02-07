const typeDefs = `
  type Task {
    "Id of the Task"
    ID: String
    "Task's title"
    task: String
    "Task's description"
    description: String
    "Task's status"
    isDone: Boolean
    "Task's urgency"
    urgency: Int
    "Task's due date"
    dueDate: String
    "Task's Group ID to which task belongs"
    groupId: ID
    "User's username to which task belongs"
    username: String
    "Time when task is created"
    createdAt: String
    "Last time when task is updated"
    updatedAt: String
  }
`;

const queries = `
  
`;

const mutations = `
  
`;

module.exports = {
  typeDefs,
  queries,
  mutations,
};
