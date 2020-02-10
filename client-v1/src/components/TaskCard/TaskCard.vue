<template src="./TaskCard.html"></template>

<script>
import HTMLDecoder from '../../lib/HTMLDecoder';
import AssignedTasks from '../../lib/AssignedTasks';

export default {
  name: 'task-card',
  props: ['task'],
  data: () => ({
    groupImage: '',
  }),
  computed: {
    username() {
      return localStorage.username;
    },
    taskUrgency() {
      switch (Number(this.task.urgency)) {
        case 0:
          return 'Low';
        case 1:
          return 'Medium';
        case 2:
          return 'High';
        default:
          return 'Undefined';
      }
    },
    taskDueDate() {
      const date = new Date(this.task.dueDate);
      const stringDate = date.toDateString();
      return stringDate;
    },
    taskDescription() {
      const decoded = HTMLDecoder(this.task.description, 'ENT_QUOTES');
      return decoded;
    },
  },
  methods: {
    completeTask(id) {
      const formData = {
        assignedTaskId: id,
        status: (this.task.status === '0') ? '1' : '0',
      };
      AssignedTasks.complete(formData)
        .then(() => this.$emit('refresh-page'));
    },
  },
};
</script>
