const typeDefs = `
  type Group {
    "Group Entrie's ID in database"
    id: ID
    "Name of the group"
    name: String
    "Description for the group"
    description: String
    "Image URL related to the group:"
    imageUrl: String
    "Username to whom the group belongs to"
    username: String
    "Time when group is created"
    createdAt: String
    "Time when last time group is updated"
    updatedAt: String
    "Tasks belongs to the requested group"
    tasks: [Task]
  }

  input CreateGroupInput {
    "Name of Group"
    name: String!
    "Description for the group"
    description: String
    "Image URL for the group"
    imageUrl: String
  }

  input EditGroupInput {
    "ID of the group which values are updating"
    id: ID!
    "Name of Group"
    name: String!
    "Description for the group"
    description: String
    "Image URL for the group"
    imageUrl: String
  }

  type GroupResponse {
    "Created or Edited Group"
    group: Group
    "Username of the logged in user"
    username: String
    "Message related to the action"
    message: String
  }
`;

const queries = `
  groups: [Group!]!
  group(id: String!): Group!
`;

const mutations = `
  createGroup(group: CreateGroupInput): GroupResponse!
  editGroup(group: EditGroupInput): GroupResponse!
  deleteGroup(id: String!): GroupResponse!
`;

module.exports = {
  typeDefs,
  queries,
  mutations,
};
