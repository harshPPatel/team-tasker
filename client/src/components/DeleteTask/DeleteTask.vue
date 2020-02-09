<template src="./DeleteTask.html"></template>

<script>
import ErrorComponent from '../ErrorComponent.vue';
import Task from '../../lib/Task';

export default {
  name: 'delete-task',
  props: ['taskId'],
  data: () => ({
    isLoading: false,
    serverError: null,
  }),
  components: {
    ErrorComponent,
  },
  methods: {
    submitForm() {
      const formData = {
        taskId: this.taskId,
      };
      this.isLoading = true;
      Task.deleteTask(formData)
        .then(() => {
          this.isLoading = false;
          this.$emit('refresh-tasks');
          this.closeModal();
        })
        .catch((err) => {
          this.isLoading = false;
          this.serverError = err;
        });
    },
    closeModal() {
      const closeButton = document.getElementById(`deleteTaskClose${this.taskId}`);
      closeButton.click();
    },
  },
};
</script>
