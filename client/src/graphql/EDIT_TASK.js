import gql from 'graphql-tag';

export default gql`mutation editTask($task: EditTaskInput!) {
  editTask(task: $task) {
    task {
      id
      task
      description
      isDone
      urgency
      dueDate
      updatedAt
    }
    message
  }
}`;
