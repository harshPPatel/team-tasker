const joi = require('@hapi/joi');
const { ApolloError } = require('apollo-server-express');

// Common validation schema for Singup and Login
const commonSchema = {
  username: joi.string()
    .trim()
    .pattern(/(^[a-zA-Z0-9_]+$)/, { name: 'Username' })
    .min(3)
    .max(15)
    .required(),
  password: joi.string()
    .trim()
    .pattern(/(^[a-zA-Z0-9_@]+$)/, { name: 'Password' })
    .min(6)
    .max(30)
    .required(),
};

/**
 * Validates the provided payload for signup
 * @param {Object} payload Payload provided by user
 * @returns {Promise} Promise gets solved if the data is valid,
 * otherwise it get rejected with the ApolloError
 */
const signup = (payload) => (
  new Promise((resolve, reject) => {
    if (!payload.confirmPassword) {
      reject(new ApolloError('Confirm Password Field is required'));
      return;
    }

    const signUpSchema = joi.object({
      ...commonSchema,
      confirmPassword: joi.ref('password'),
    });

    // Validating the input
    const result = signUpSchema.validate(payload);

    if (result.error) {
      reject(new ApolloError(result.error));
      return;
    }

    // resolving the error with validated data
    resolve(result);
  })
);

/**
 * Validates the provided payload for login
 * @param {Object} payload Payload provided by user
 * @returns {Promise} Promise gets solved if the data is valid,
 * otherwise it get rejected with the ApolloError
 */
const login = (payload) => (
  new Promise((resolve, reject) => {
    const loginSchema = joi.object(commonSchema);

    // Validating the input
    const result = loginSchema.validate(payload);

    if (result.error) {
      reject(new ApolloError(result.error));
      return;
    }

    // resolving the error with validated data
    resolve(result);
  })
);

module.exports = {
  signup,
  login,
};
