const typeDefs = `
  type AssignedTask {
    "Id of the Assigned Task"
    ID: String
    "Assigned Task's title"
    task: String
    "Assigned Task's description"
    description: String
    "Assigned Task's status"
    isDone: Boolean
    "Assigned Task's urgency"
    urgency: Int
    "Assigned Task's due date"
    dueDate: String
    "Assigned Task's Group ID to which task belongs"
    groupId: ID
    "User's username to which assigned task belongs"
    username: String
    "Time when assigned task is created"
    createdAt: String
    "Last time when assigned task is updated"
    updatedAt: String
  }

  input CreateAssignedTaskInput {
    "Assigned Task's title"
    task: String
    "Assigned Task's Description"
    description: String
    "Assigned Task's urgency"
    urgency: Int
    "Assigned Task's due date"
    dueDate: String
    "Username to which task belongs"
    username: String
  }

  input EditAssignedTaskInput {
    "Id of the assigned task which will be edited"
    id: ID
    "Assigned Task's title"
    task: String
    "Assigned Task's Description"
    description: String
    "Assigned Task's status"
    isDone: Boolean
    "Assigned Task's urgency"
    urgency: Int
    "Assigned Task's due date"
    dueDate: String
    "User's username to whom the assigned task belongs"
    username: String
  }

  type AssignedTaskResponse {
    "Assigned Task which is being edited/deleted"
    assignedTask: AssignedTask
    "Logged in user's username"
    username: String
    "Message related to the action"
    message: String
  }
`;

const queries = `
  
`;

const mutations = `
  createAssignedTask(assignedTask: CreateAssignedTaskInput): AssignedTaskResponse!
  editAssignedTask(assignedTask: EditAssignedTaskInput!): AssignedTaskResponse!
  toggleAssignedTask(id: ID!): AssignedTaskResponse!
  deleteAssignedTask(id: ID!): AssignedTaskResponse!
`;

module.exports = {
  typeDefs,
  queries,
  mutations,
};
