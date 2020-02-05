const { ApolloError } = require('apollo-server-express');

const Group = require('../../models/Group');

// const createGroup = (_)

const groups = async (obj, args, context) => {
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
  // mutations: { createGroup },
};
