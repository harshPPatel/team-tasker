const { ApolloError, ValidationError, AuthenticationError } = require('apollo-server-express');

const User = require('../../models/User');

const users = async (obj, args, context) => {
  if (!context.isValidToken) {
    return new ValidationError('Token is Invalid');
  }

  if (!context.user.isAdmin) {
    return new AuthenticationError('Unauthorized Request');
  }

  try {
    const result = await User.where('username').ne(context.username).exec();
    return result;
  } catch (err) {
    return new ApolloError(err);
  }
};

const changeTheme = async (obj, args, context) => {
  if (!context.isValidToken) {
    return new ValidationError('Token is Invalid');
  }

  const chosenTheme = args.theme;
  if (!(chosenTheme && (chosenTheme !== 1 || chosenTheme !== 0))) {
    return new ValidationError('Chose theme value is invalid');
  }

  const user = await User.findOne({ username: context.username }).exec();

  if (!user) {
    return new ApolloError('User does not exists');
  }

  user.theme = Number(chosenTheme);

  return user.save()
    .then(() => ({
      user,
      username: user.username,
      message: 'Theme updated successfully!',
    }))
    .catch((err) => new ApolloError(err));
};

module.exports = {
  users,
  changeTheme,
};
