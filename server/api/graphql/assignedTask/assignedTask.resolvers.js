const { ApolloError, ValidationError, AuthenticationError } = require('apollo-server-express');

const AssignedTaskValidator = require('../../validators/assignedTask');
const AssignedTask = require('../../models/AssignedTask');
const User = require('../../models/User');

// Created the assigned task in database
const createAssignedTask = (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  const input = args.assignedTask;
  return AssignedTaskValidator.create(input)
    .then((data) => {
      // Validating that assigned user exists in the database
      const user = User.findOne({ username: data.value.username }).exec();

      if (!user) {
        return new ValidationError('User does not exists');
      }

      // Throwing the error if user is not admin
      if (!context.user.isAdmin) {
        return new ValidationError('Unauthorized request');
      }

      // Creating assigned task instance
      const assignedTask = new AssignedTask(data.value);
      // saving task to database
      return assignedTask.save()
        .then(() => ({
          assignedTask,
          username: context.username,
          message: 'Assigned Task is created successfully',
        }))
        .catch((err) => new ApolloError(err));
    })
    .catch((err) => new ValidationError(err));
};

const editAssignedTask = (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  const input = args.assignedTask;
  // Validating the task's id provided by user
  const assignedTaskId = input.id.toString().trim();
  if (!assignedTaskId.match(/^[0-9a-fA-F]{24}$/)) {
    return new ValidationError('Assigned Task ID is Invalid!');
  }
  return AssignedTaskValidator.edit(input)
    .then(async (data) => {
      const assignedTask = await AssignedTask.findOne({
        _id: data.value.id,
      }).exec();

      // Returning the error if task does not exists
      if (!assignedTask) {
        return new ApolloError('Assigned Task not found!');
      }

      // Returning the error if logged in user is not admin
      if (!context.user.isAdmin) {
        return new AuthenticationError('Unauthorized Request!');
      }

      // Updating values for database instance
      assignedTask.task = data.value.task ? data.value.task : assignedTask.task;
      assignedTask.isDone = data.value.isDone
        ? data.value.isDone
        : assignedTask.isDone;
      assignedTask.description = data.value.description
        ? data.value.description
        : assignedTask.description;
      assignedTask.urgency = data.value.urgency
        ? data.value.urgency
        : assignedTask.urgency;
      assignedTask.dueDate = data.value.dueDate
        ? data.value.dueDate
        : assignedTask.dueDate;
      assignedTask.username = data.value.username
        ? data.value.username
        : assignedTask.username;
      assignedTask.updatedAt = Date.now();

      // saving assigned task to database
      return assignedTask.save()
        .then((res) => ({
          assignedTask,
          username: res.username,
          message: 'Assigned Task is updated successfully',
        }))
        .catch((err) => new ApolloError(err));
    })
    .catch((err) => new ValidationError(err));
};

const toggleAssignedTask = async (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  const input = args.assignedTask;
  // Validating the task's id provided by user
  const assignedTaskId = input.id.toString().trim();
  if (!assignedTaskId.match(/^[0-9a-fA-F]{24}$/)) {
    return new ValidationError('Assigned Task ID is Invalid!');
  }

  const assignedTask = await AssignedTask.findOne({
    _id: assignedTaskId,
  }).exec();

  // Returning the error if task does not exists
  if (!assignedTask) {
    return new ApolloError('Assigned Task not found!');
  }

  // Returning the error if task does not belongs to logged in user
  if (context.username !== AssignedTask.username) {
    return new AuthenticationError('Unauthorized Request!');
  }

  // Updating values for database instance
  assignedTask.isDone = !AssignedTask.isDone;
  assignedTask.updatedAt = Date.now();

  // saving assigned task to database
  return assignedTask.save()
    .then(() => ({
      assignedTask,
      username: context.username,
      message: 'Assigned Task is updated successfully',
    }))
    .catch((err) => new ApolloError(err));
};

const deleteAssignedTask = async (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  // Validating the assgined task's id
  const assignedTaskId = args.id.toString().trim();
  if (!assignedTaskId.match(/^[0-9a-fA-F]{24}$/)) {
    return new ValidationError('Assigned Task ID is Invalid!');
  }

  // Finding assigned task in database
  const assignedTask = await AssignedTask.findOne({ _id: assignedTaskId }).exec();

  // Returning the error if assigned task does not exists
  if (!assignedTask) {
    return new ApolloError('Assigned Task does not exists!');
  }

  // Returning the error if logged in user is not admin
  if (!context.user.isAdmin) {
    return new AuthenticationError('Unauthorized Request!');
  }

  // Removing the assignedTask from database
  const result = await assignedTask.remove()
    .then(() => ({
      assignedTask,
      username: context.username,
      message: 'Assigned Task deleted successfully!',
    }))
    .catch((err) => new ApolloError(err));

  return result;
};

module.exports = {
  queries: { },
  mutations: {
    createAssignedTask,
    editAssignedTask,
    toggleAssignedTask,
    deleteAssignedTask,
  },
};
