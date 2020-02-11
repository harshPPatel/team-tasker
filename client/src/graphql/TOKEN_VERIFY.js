import gql from 'graphql-tag';

export default gql`mutation verify {
  verify {
    message
    username
  }
}`;
