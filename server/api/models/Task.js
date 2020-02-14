const { Schema, model, Types } = require('mongoose');

const taskSchema = Schema({
  task: {
    type: String,
    trim: true,
    minLength: 1,
    maxLength: 40,
    required: true,
  },
  description: {
    type: String,
    maxLength: 200,
    trim: true,
  },
  isDone: {
    type: Boolean,
    default: false,
  },
  urgency: {
    type: Number,
    min: 0,
    max: 2,
    default: 0,
  },
  dueDate: Date,
  groupId: {
    type: Types.ObjectId,
    required: true,
  },
  username: {
    type: String,
    required: true,
    trim: true,
    minLength: 3,
    maxLength: 15,
    match: /(^[a-zA-Z0-9_]+$)/,
  },
}, { timestamps: true });

module.exports = model('Task', taskSchema);
