const { gql } = require('apollo-server-express');

const typeDefs = gql`
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

  type Query {
    test: String
  }

  type Mutation {
    signup(input: SignUpInput): User!,
    login(input: LoginInput): AuthResponse!,
  }
`;

module.exports = typeDefs;
