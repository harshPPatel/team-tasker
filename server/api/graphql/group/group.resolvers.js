const { ApolloError, ValidationError, AuthenticationError } = require('apollo-server-express');

const Group = require('../../models/Group');
const Task = require('../../models/Task');
const GroupValidator = require('../../validators/group');

// lists the groups for user
const groups = async (obj, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid');
  }
  try {
    const result = await Group.find({
      username: context.username,
    }).exec();
    return result;
  } catch (err) {
    return new ApolloError(err.message);
  }
};

const groupSingle = async (obj, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid');
  }
  // Validating the group's id provided by user
  const groupId = args.id.toString();
  if (!groupId.match(/^[0-9a-fA-F]{24}$/)) {
    return new ValidationError('Group ID is Invalid!');
  }
  const group = await Group.findOne({ _id: groupId }).exec();

  if (!group) {
    return new ApolloError('Group not found!');
  }

  if (group.username !== context.username) {
    return new AuthenticationError('Unauthorized Request');
  }

  try {
    const tasks = await Task.find({ groupId }).exec();
    return {
      ...group,
      tasks,
    };
  } catch (err) {
    return new ApolloError(err.message);
  }
};

// Created the group in database
const createGroup = (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  return GroupValidator.create(args.group)
    .then((data) => {
      const databasePayload = {
        ...data.value,
        username: context.username,
      };

      // Creating group instance
      const group = new Group(databasePayload);
      // saving group to database
      return group.save()
        .then((res) => ({
          group,
          username: res.username,
          message: 'Group is created successfully',
        }))
        .catch((err) => new ApolloError(err));
    })
    .catch((err) => new ValidationError(err));
};

// Resolver for editing the group
const editGroup = (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  // Validating the group's id provided by user
  const groupId = args.id.toString().trim();
  if (!groupId.match(/^[0-9a-fA-F]{24}$/)) {
    return new ValidationError('Group ID is Invalid!');
  }
  return GroupValidator.edit(args.group)
    .then(async (data) => {
      const group = await Group.findOne({
        _id: data.value.id,
      }).exec();

      // Returning the error if group does not exists
      if (!group) {
        return new ApolloError('Group not found!');
      }

      // Returning the error if group does not belongs to user
      if (!group.username !== context.username) {
        return new AuthenticationError('Unauthorized Request!');
      }

      // Updating values for database instance
      group.name = data.value.name ? data.value.name : group.name;
      group.imageUrl = data.value.imageUrl
        ? data.value.imageUrl
        : group.imageUrl;
      group.description = data.value.description
        ? data.value.description
        : group.description;
      group.updatedAt = Date.now();

      // saving group to database
      return group.save()
        .then((res) => ({
          group,
          username: res.username,
          message: 'Group is updated successfully',
        }))
        .catch((err) => new ApolloError(err));
    })
    .catch((err) => new ValidationError(err));
};

const deleteGroup = async (_, args, context) => {
  if (!context.isValidToken) {
    return new AuthenticationError('Token is Invalid!');
  }
  // Validating the group's id provided by user
  const groupId = args.id.toString().trim();
  if (!groupId.match(/^[0-9a-fA-F]{24}$/)) {
    return new ValidationError('Group ID is Invalid!');
  }

  // Finding group in database
  const group = await Group.findOne({ _id: groupId }).exec();

  // Returning the error if group does not exists
  if (!group) {
    return new ApolloError('Group does not exists!');
  }

  // Returning the error if group does not belongs to user
  if (!group.username !== context.username) {
    return new AuthenticationError('Unauthorized Request!');
  }

  // Removing the group from database
  const result = await group.remove()
    .then(() => ({
      group,
      username: group.username,
      message: 'Group deleted successfully!',
    }))
    .catch((err) => new ApolloError(err));

  return result;
};

// For individual group query, query tasks. Create function if user
// has requested tasks or not and then make query to db if user has requested it.

module.exports = {
  queries: {
    groups,
    group: groupSingle,
  },
  mutations: {
    createGroup,
    editGroup,
    deleteGroup,
  },
};
