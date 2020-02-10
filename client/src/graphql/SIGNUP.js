import gql from 'graphql-tag';

export default gql`mutation signup($input: SignUpInput!) {
  signup(input:$input) {
    username
    theme
  }
}`;
