<template src="./AdminDashboard.html"></template>

<style lang="scss" src="./AdminDashboard.scss"></style>

<script>
import AssignedTasks from '../../lib/AssignedTasks';
import AddAssignedTask from '../../components/AddAssignedTask/AddAssignedTask.vue';
import EditAssignedTask from '../../components/EditAssignedTask/EditAssignedTask.vue';
import DeleteAssignedTask from '../../components/DeleteAssignedTask/DeleteAssignedTask.vue';
import TaskCard from '../../components/TaskCard/TaskCard.vue';

export default {
  name: 'admin-dashboard',
  components: {
    AddAssignedTask,
    EditAssignedTask,
    DeleteAssignedTask,
    TaskCard,
  },
  data: () => ({
    tasks: [],
    users: [],
  }),
  mounted() {
    AssignedTasks.getAll()
      .then((data) => {
        this.tasks = data.tasks;
      });
    AssignedTasks.getAllUsers()
      .then((data) => {
        this.isLoading = false;
        this.users = data.users;
      })
      .catch((err) => {
        this.isLoading = false;
        this.error.serverError = err;
      });
  },
  methods: {
    refreshPage() {
      this.$router.go();
    },
  },
};
</script>
