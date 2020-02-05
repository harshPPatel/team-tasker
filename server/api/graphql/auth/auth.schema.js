const typeDefs = `
  type User {
    "User's Username"
    username: String
    "User's theme choice"
    theme: Int
    "True if user is admin"
    isAdmin: Boolean
    "Timestamp when user changed the password for last time"
    lastPasswordChangedAt: String
    "Time when user is created"
    createdAt: String
    "Time when last time user is updated"
    updatedAt: String
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

  type TokenVerifyResponse {
    "User's Username"
    username: String
    "Message for logout"
    message: String
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
  logout: LogoutResponse!
  verify: TokenVerifyResponse!
`;

module.exports = {
  typeDefs,
  mutations,
};
