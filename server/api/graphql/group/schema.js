const typeDefs = `
  type Group {
    "Group Entrie's ID in database"
    id: ID
    "Name of the group"
    name: String
    "Description for the group"
    description: String
    "Image URL related to the group:"
    imageURL: String
    "Time when group is created"
    createdAt: String
    "Time when last time group is updated"
    updatedAt: String
  }
`;

const queries = `
  groups: [Group!]!
`;

const mutations = `
`;

module.exports = {
  typeDefs,
  queries,
  mutations,
};
