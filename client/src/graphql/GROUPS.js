import gql from 'graphql-tag';

export default gql`query groups {
  groups {
    id
    name
    description
    imageUrl
    username
    createdAt
    updatedAt
  }
}`;
