const { Schema, model } = require('mongoose');

const groupSchema = Schema({
  name: {
    type: String,
    trim: true,
    minLength: 1,
    maxLength: 40,
    required: true,
  },
  imageUrl: {
    type: String,
    trim: true,
    match: /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([-.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/,
    default: 'https://images.pexels.com/photos/6372/coffee-smartphone-desk-pen.jpg?auto=compress&cs=tinysrgb&dpr=2&h=150',
  },
  description: {
    type: String,
    maxLength: 500,
    trim: true,
  },
  username: {
    type: String,
    unique: true,
    required: true,
    trim: true,
    minLength: 3,
    maxLength: 15,
    match: /(^[a-zA-Z0-9_]+$)/,
  },
}, { timestamps: true });

module.exports = model('Group', groupSchema);
