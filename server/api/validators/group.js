const joi = require('@hapi/joi');
const { ApolloError } = require('apollo-server-express');

// Regex for validating the Image URL
const URL_REGEX = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([-.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

// Common validation schema for Singup and Login
const commonSchema = {
  name: joi.string()
    .trim()
    .min(1)
    .max(40)
    .required(),
  description: joi.string()
    .trim()
    .max(200),
  imageUrl: joi.string()
    .trim()
    .pattern(URL_REGEX, { name: 'Image URL' }),
};

/**
 * Validates the provided payload for create group
 * @param {Object} payload Payload provided by user
 * @returns {Promise} Promise gets solved if the data is valid,
 * otherwise it get rejected with the ApolloError
 */
const create = (payload) => (
  new Promise((resolve, reject) => {
    const groupSchema = joi.object(commonSchema);

    // Validating the input
    const result = groupSchema.validate(payload);

    if (result.error) {
      reject(new ApolloError(result.error));
      return;
    }

    // resolving the error with validated data
    resolve(result);
  })
);

/**
 * Validates the provided payload for edit group
 * @param {Object} payload Payload provided by user
 * @returns {Promise} Promise gets solved if the data is valid,
 * otherwise it get rejected with the ApolloError
 */
const edit = (payload) => (
  new Promise((resolve, reject) => {
    const groupSchema = joi.object({
      ...commonSchema,
      id: joi.string()
        .trim()
        .pattern(/^[0-9a-fA-F]{24}$/, { name: 'Group ID' })
        .required(),
    });

    // Validating the input
    const result = groupSchema.validate(payload);

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
