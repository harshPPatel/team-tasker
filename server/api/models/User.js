const { Schema, model } = require('mongoose');

const UserSchema = Schema({
  username: {
    type: String,
    unique: true,
    required: true,
    trim: true,
    minLength: 3,
    maxLength: 15,
    match: /(^[a-zA-Z0-9_]+$)/,
  },
  password: {
    type: String,
    required: true,
  },
  theme: {
    type: Number,
    min: 0,
    max: 1,
    default: 0,
  },
  isAdmin: {
    type: Number,
    min: 0,
    max: 1,
    default: 0,
  },
  lastPasswordChangedAt: {
    type: Date,
    default: Date.now,
  },
}, { timestamps: true });

module.exports = model('User', UserSchema);
