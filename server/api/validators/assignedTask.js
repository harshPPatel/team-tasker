const joi = require('@hapi/joi');
const { ApolloError } = require('apollo-server-express');

// Common validation schema for Task
const commonSchema = {
  task: joi.string()
    .trim()
    .min(1)
    .max(40)
    .required(),
  description: joi.string()
    .trim()
    .max(200),
  isDone: joi.boolean(),
  urgency: joi.number()
    .min(0)
    .max(2)
    .precision(0),
  dueDate: joi.date(),
  username: joi.string()
    .trim()
    .pattern(/(^[a-zA-Z0-9_]+$)/, { name: 'Username' })
    .min(3)
    .max(15)
    .required(),
};

/**
 * Validates the provided payload for create assigned task
 * @param {Object} payload Payload provided by user
 * @returns {Promise} Promise gets solved if the data is valid,
 * otherwise it get rejected with the ApolloError
 */
const create = (payload) => (
  new Promise((resolve, reject) => {
    const assignedTaskSchema = joi.object(commonSchema);

    // Validating the input
    const result = assignedTaskSchema.validate(payload);

    if (result.error) {
      reject(new ApolloError(result.error));
      return;
    }

    // resolving the error with validated data
    resolve(result);
  })
);

/**
 * Validates the provided payload for edit assigned task
 * @param {Object} payload Payload provided by user
 * @returns {Promise} Promise gets solved if the data is valid,
 * otherwise it get rejected with the ApolloError
 */
const edit = (payload) => (
  new Promise((resolve, reject) => {
    const assignedTaskSchema = joi.object({
      ...commonSchema,
      id: joi.string()
        .trim()
        .pattern(/^[0-9a-fA-F]{24}$/, { name: 'Task ID' })
        .required(),
    });

    // Validating the input
    const result = assignedTaskSchema.validate(payload);

    if (result.error) {
      reject(new ApolloError(result.error));
      return;
    }

    // resolving the error with validated data
    resolve(result);
  })
);

module.exports = {
  create,
  edit,
};
