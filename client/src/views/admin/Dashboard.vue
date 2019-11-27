<template>
  <div class="container mt-5">
    <h1>Welcome, Admin!</h1>
    <div class="flex-container mt-5">
      <div>
        <h3>Assigned Tasks</h3>
      </div>
      <div class="ml-auto text-right">
        <button type="button" class="btn btn-success"
          data-toggle="modal" data-target="#addAssignedTaskModal">Add Task</button>
      </div>
    </div>
    <hr>
    <add-assigned-task :users="users" v-on:refresh-page="refreshPage">
    </add-assigned-task>
    <div class="row">
      <task-card v-for="task in tasks" :task="task" :key="`task-${task.taskId}`"></task-card>
    </div>
    <edit-assigned-task v-for="task in tasks" :key="`edit-${task.taskId}`"
      :assignedTask="task" :users="users" v-on:refresh-page="refreshPage">
    </edit-assigned-task>
    <delete-assigned-task v-for="task in tasks" :key="`delete-${task.taskId}`"
      :taskId="task.taskId" v-on:refresh-page="refreshPage">
    </delete-assigned-task>
  </div>
</template>

<script>
import AssignedTasks from '../../lib/AssignedTasks';
import AddAssignedTask from '../../components/AddAssignedTask.vue';
import EditAssignedTask from '../../components/EditAssignedTask.vue';
import DeleteAssignedTask from '../../components/DeleteAssignedTask.vue';
import TaskCard from '../../components/TaskCard.vue';

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

<style lang="scss">

.flex-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0;
  h1 {
    margin-bottom: 0!important;
  };
};


</style>
