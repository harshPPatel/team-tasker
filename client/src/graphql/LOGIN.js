import gql from 'graphql-tag';

export default gql`mutation login($input: LoginInput!) {
  login(input:$input) {
    user {
      username
      theme
      isAdmin
      createdAt
      updatedAt
    }
    token
  }
}`;
