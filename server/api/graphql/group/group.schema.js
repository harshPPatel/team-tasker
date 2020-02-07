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
  }

  input CreateGroupInput {
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
`;

const mutations = `
  createGroup(group: CreateGroupInput): GroupResponse!
`;

module.exports = {
  typeDefs,
  queries,
  mutations,
};
