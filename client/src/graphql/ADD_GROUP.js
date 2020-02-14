import gql from 'graphql-tag';

export default gql`mutation addGroup($input: CreateGroupInput!) {
  createGroup(group:$input) {
    group {
      id
      name
      description
      imageUrl
      username
      createdAt
      updatedAt
    }
    message
  }
}`;
