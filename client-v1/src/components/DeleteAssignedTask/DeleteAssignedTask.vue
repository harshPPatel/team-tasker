<template src="./DeleteAssignedTask.html"></template>

<script>
import ErrorComponent from '../ErrorComponent.vue';
import AssignedTasks from '../../lib/AssignedTasks';

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
        assignedTaskId: this.taskId,
      };
      this.isLoading = true;
      AssignedTasks.deleteTask(formData)
        .then(() => {
          this.isLoading = false;
          this.closeModal();
          this.$emit('refresh-page');
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
