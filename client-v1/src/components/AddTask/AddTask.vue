<template src="./AddTask.html"></template>

<style lang="scss" src="./AddTask.scss"></style>

<script>
import Task from '../../lib/Task';
import ErrorComponent from '../ErrorComponent.vue';

export default {
  name: 'add-task',
  components: {
    ErrorComponent,
  },
  props: ['groupId'],
  data: () => ({
    task: {
      task: '',
      status: false,
      urgency: 0,
      description: '',
      dueDate: '',
      groupId: null,
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
  mounted() {
    this.task.groupId = (this.groupId === 'null') ? this.groupId : null;
  },
  methods: {
    submitForm() {
      this.error.serverError = null;
      const date = new Date(this.task.dueDate).toISOString().slice(0, 19).replace('T', ' ');
      const formData = this.task;
      formData.dueDate = date;
      formData.status = 0;
      this.isLoading = true;
      Task.create(formData)
        .then(() => {
          this.isLoading = false;
          this.$emit('refresh-page');
          const closeButton = document.getElementById('addTaskClose');
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
