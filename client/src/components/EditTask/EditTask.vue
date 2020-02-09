<template src="./EditTask.html"></template>

<script>
import Task from '../../lib/Task';
import ErrorComponent from '../ErrorComponent.vue';

export default {
  name: 'edit-task',
  components: {
    ErrorComponent,
  },
  props: ['editTask'],
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
    this.task = { ...this.editTask };
    this.task.status = this.editTask.status === 0;
    this.task.groupId = this.editTask.groupId;
  },
  methods: {
    submitForm() {
      this.error.serverError = null;
      const date = new Date(this.task.dueDate).toISOString().slice(0, 19).replace('T', ' ');
      const formData = this.task;
      formData.dueDate = date;
      formData.status = this.task.status ? 1 : 0;
      this.isLoading = true;
      Task.update(formData)
        .then(() => {
          this.isLoading = false;
          this.$emit('refresh-tasks');
          const closeButton = document.getElementById(`editTaskClose${this.task.taskId}`);
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

<style>

.taskStatus {
  /* align-items: flex-start; */
  justify-content: center;
  width: initial;
}

</style>
