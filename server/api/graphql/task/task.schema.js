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

  input CreateTaskInput {
    "Task's title"
    task: String!
    "Task's Description"
    description: String
    "Task's urgency"
    urgency: Int
    "Task's due date"
    dueDate: String
    "Group Id to which task belongs"
    groupId: ID!
  }

  input EditTaskInput {
    "Id of the task which will be edited"
    id: ID!
    "Task's title"
    task: String
    "Task's Description"
    description: String
    "Task's status"
    isDone: Boolean
    "Task's urgency"
    urgency: Int
    "Task's due date"
    dueDate: String
  }

  type TaskResponse {
    "Task which is being edited/deleted"
    task: Task
    "Logged in user whose task is edited/deleted"
    username: String
    "Message related to the action"
    message: String
  }
`;

const queries = `
  
`;

const mutations = `
  createTask(task: CreateTaskInput!): TaskResponse!
  editTask(task: EditTaskInput!): TaskResponse!
  deleteTask(id: ID!): TaskResponse!
`;

module.exports = {
  typeDefs,
  queries,
  mutations,
};
