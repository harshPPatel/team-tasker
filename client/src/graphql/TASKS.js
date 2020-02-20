import gql from 'graphql-tag';

export default gql`query group($id: String!) {
  group(id: $id) {
    id
    name
    description
    imageUrl
    username
    createdAt
    updatedAt
    tasks {
      id
      task
      description
      isDone
      urgency
      dueDate
      createdAt
      updatedAt
    }
  }
}`;
