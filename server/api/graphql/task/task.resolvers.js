const { ApolloError, ValidationError, AuthenticationError } = require('apollo-server-express');

const TaskValidator = require('../../validators/task');
const Task = require('../../models/Task');
const Group = require('../../models/Group');

// Created the task in database
const createTask = (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  const input = args.task;
  return TaskValidator.create(input)
    .then((data) => {
      const databasePayload = {
        ...data.value,
        username: context.username,
      };

      // Validating that group exists in the database
      const group = Group.findOne({ _id: input.groupId }).exec();

      if (!group) {
        return new ValidationError('Group does not exists');
      }

      // Throwing the error if group does not belongs to the logged in user
      if (group.username !== context.username) {
        return new ValidationError('Unauthorized request');
      }

      // Creating task instance
      const task = new Task(databasePayload);
      // saving task to database
      return task.save()
        .then((res) => ({
          task,
          username: res.username,
          message: 'Task is created successfully',
        }))
        .catch((err) => new ApolloError(err));
    })
    .catch((err) => new ValidationError(err));
};

const editTask = (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  const input = args.task;
  // Validating the task's id provided by user
  const taskId = input.id.toString().trim();
  if (!taskId.match(/^[0-9a-fA-F]{24}$/)) {
    return new ValidationError('Task ID is Invalid!');
  }
  return TaskValidator.edit(input)
    .then(async (data) => {
      const task = await Task.findOne({
        _id: data.value.id,
      }).exec();

      // Returning the error if task does not exists
      if (!task) {
        return new ApolloError('Task not found!');
      }

      // Returning the error if task does not belongs to user
      if (!task.username !== context.username) {
        return new AuthenticationError('Unauthorized Request!');
      }

      // Updating values for database instance
      task.task = data.value.task ? data.value.task : task.task;
      task.isDone = data.value.isDone
        ? data.value.isDone
        : task.isDone;
      task.description = data.value.description
        ? data.value.description
        : task.description;
      task.urgency = data.value.urgency
        ? data.value.urgency
        : task.urgency;
      task.dueDate = data.value.dueDate
        ? data.value.dueDate
        : task.dueDate;
      task.updatedAt = Date.now();

      // saving task to database
      return task.save()
        .then((res) => ({
          task,
          username: res.username,
          message: 'Task is updated successfully',
        }))
        .catch((err) => new ApolloError(err));
    })
    .catch((err) => new ValidationError(err));
};


const deleteTask = async (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  // Validating the group's id provided by user
  const taskId = args.id.toString().trim();
  if (!taskId.match(/^[0-9a-fA-F]{24}$/)) {
    return new ValidationError('Task ID is Invalid!');
  }

  // Finding task in database
  const task = await Task.findOne({ _id: taskId }).exec();

  // Returning the error if task does not exists
  if (!task) {
    return new ApolloError('Task does not exists!');
  }

  // Returning the error if task does not belongs to user
  if (!task.username !== context.username) {
    return new AuthenticationError('Unauthorized Request!');
  }

  // Removing the task from database
  const result = await task.remove()
    .then(() => ({
      task,
      username: task.username,
      message: 'Task deleted successfully!',
    }))
    .catch((err) => new ApolloError(err));

  return result;
};

module.exports = {
  queries: { },
  mutations: {
    createTask,
    editTask,
    deleteTask,
  },
};
