<template src="./EditAssignedTask.html"></template>

<style lang="scss" src="./EditAssignedTask.scss"></style>

<script>
import AssignedTasks from '../../lib/AssignedTasks';
import ErrorComponent from '../ErrorComponent.vue';

export default {
  name: 'add-task',
  components: {
    ErrorComponent,
  },
  props: ['assignedTask', 'users'],
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
  mounted() {
    this.task = {
      ...this.task,
      ...this.assignedTask,
    };
  },
  methods: {
    submitForm() {
      this.error.serverError = null;
      const date = new Date(this.task.dueDate).toISOString().slice(0, 19).replace('T', ' ');
      const formData = this.task;
      formData.dueDate = date;
      formData.status = 0;
      this.isLoading = true;
      AssignedTasks.update(formData)
        .then(() => {
          this.isLoading = false;
          const closeButton = document.getElementById(`editAssignedTaskClose${this.task.taskId}`);
          closeButton.click();
          this.$emit('refresh-page');
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
