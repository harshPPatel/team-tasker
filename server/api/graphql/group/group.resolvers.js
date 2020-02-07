const { ApolloError, ValidationError, AuthenticationError } = require('apollo-server-express');

const Group = require('../../models/Group');
const GroupValidator = require('../../validators/group');

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

// For individual group query, query tasks. Create function if user
// has requested tasks or not and then make query to db if user has requested it.

module.exports = {
  queries: { groups },
  mutations: { createGroup },
};
