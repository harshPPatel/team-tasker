<template src="./AddAssignedTask.html"></template>

<style lang="scss" src="./AddAssignedTask.scss"></style>

<script>
import AssignedTasks from '../../lib/AssignedTasks';
import ErrorComponent from '../ErrorComponent.vue';

export default {
  name: 'add-task',
  components: {
    ErrorComponent,
  },
  props: ['users'],
  data: () => ({
    task: {
      task: '',
      status: false,
      urgency: 0,
      description: '',
      dueDate: '',
      groupId: null,
      userId: '',
    },
    error: {
      serverError: null,
      taskError: '',
    },
    isLoading: false,
    validation: {
      isValidTask: false,
    },
  }),
  methods: {
    submitForm() {
      this.error.serverError = null;
      const date = new Date(this.task.dueDate).toISOString().slice(0, 19).replace('T', ' ');
      const formData = this.task;
      formData.dueDate = date;
      formData.status = 0;
      this.isLoading = true;
      AssignedTasks.create(formData)
        .then(() => {
          this.isLoading = false;
          this.$emit('refresh-page');
          const closeButton = document.getElementById('addAssignedTaskClose');
          closeButton.click();
        })
        .catch((err) => {
          this.isLoading = false;
          this.error.serverError = err;
        });
    },
    validateTask() {
      this.validation.isValidTask = false;
      this.error.taskError = '';
      if (this.task.task.trim().length > 2) {
        this.validation.isValidTask = true;
      } else {
        this.error.taskError = 'Mimimum 2 characters are required as task title';
      }
    },
  },
};
</script>
