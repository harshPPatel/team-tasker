const { Schema, model } = require('mongoose');

const blackListTokenSchema = Schema({
  token: {
    type: String,
    unique: true,
    trim: true,
    required: true,
  },
  expireAt: {
    type: Date,
    default: Date.now,
    index: { expires: '3d' },
  },
}, { timestamps: true });

module.exports = model('BlacklistToken', blackListTokenSchema);
