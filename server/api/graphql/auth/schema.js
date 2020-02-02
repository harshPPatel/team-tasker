const typeDefs = `
  type User {
    username: String
    theme: Int
    lastPasswordChangedAt: String
    createdAt: String
    updatedAt: String
    isAdmin: Boolean
  }

  type AuthResponse {
    "User object with user's configuration"
    user: User
    "Token for the user"
    token: String
  }

  type LogoutResponse {
    "User's Username"
    username: String
    "Message for logout"
    message: String
    "Time when user logged out"
    loggedOutAt: String
  }

  input SignUpInput {
    "User's username"
    username: String
    "User's password"
    password: String
    "User's Confirm Password"
    confirmPassword: String
  }

  input LoginInput {
    "User's username"
    username: String
    "User's password"
    password: String
  }
`;

const mutations = `
  signup(input: SignUpInput): User!
  login(input: LoginInput): AuthResponse!
  logout(token: String!): LogoutResponse!
`;

module.exports = {
  typeDefs,
  mutations,
};
