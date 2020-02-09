const typeDefs = `
`;

const queries = `
  users: [User!]
`;

const mutations = `
  changeTheme(theme: Number!): AuthResponse!
  deleteAccount: AuthResponse!
`;

module.exports = {
  typeDefs,
  queries,
  mutations,
};
