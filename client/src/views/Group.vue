<template>
  <div class="container mt-5">
    <div class="groupImage" v-if="group">
      <img :src="group.image" :alt="group.name">
    </div>
    <div class="flex-container mt-4" v-if="group">
      <div class="">
        <h1>{{ group.name }}</h1>
      </div>
      <div class="ml-auto text-right">
        <button type="button" class="btn btn-outline-danger"
          data-toggle="modal" :data-target="`#deleteGroupModal${group.groupId}`">
            Delete Group
        </button>
        <button type="button" class="btn btn-outline-info ml-3"
          data-toggle="modal" :data-target="`#editGroupModal${group.groupId}`">
            Edit Group
        </button>
        <button type="button" class="btn btn-success ml-3"
          data-toggle="modal" data-target="#addTaskModal">Add Task</button>
      </div>
    </div>
    <hr>
    <div class="row">
      <!-- <group-card v-for="task in tasks" :group="group" :key="group.groupId"></group-card> -->
      <task-card v-for="task in tasks" :task="task" :key="task.taskId"></task-card>
      <div class="col-12 mt-4" v-if="tasks.length === 0">
        <h4>No tasks found! Create tasks now!</h4>
      </div>
    </div>
    <edit-group v-if="group" :group="group" v-on:refresh-groups="refreshGroup"></edit-group>
    <delete-group v-if="group" :groupId="group.groupId"></delete-group>
    <add-task v-if="group" :groupId="group.groupId" v-on:refresh-tasks="refreshTasks"></add-task>
    <edit-task v-for="task in tasks" :key="`edit-${task.taskId}`" :editTask="task"
      v-on:refresh-tasks="refreshTasks"></edit-task>
    <delete-task v-for="task in tasks" :key="`delete-${task.taskId}`" :taskId="task.taskId"
      v-on:refresh-tasks="refreshTasks"></delete-task>
  </div>
</template>

<script>
import Group from '../lib/Group';
import Task from '../lib/Task';
import EditGroup from '../components/EditGroup.vue';
import DeleteGroup from '../components/DeleteGroup.vue';
import TaskCard from '../components/TaskCard.vue';
import AddTask from '../components/AddTask.vue';
import EditTask from '../components/EditTask.vue';
import DeleteTask from '../components/DeleteTask.vue';

export default {
  name: 'group',
  components: {
    EditGroup,
    DeleteGroup,
    TaskCard,
    AddTask,
    EditTask,
    DeleteTask,
  },
  data: () => ({
    group: null,
    tasks: [],
  }),
  computed: {
    groupId() {
      return this.$route.params.id;
    },
  },
  mounted() {
    this.refreshGroup(this.$route.params.id);
    this.refreshTasks(this.$route.params.id);
  },
  methods: {
    refreshGroup(id = null) {
      Group.getSingle(id || this.groupId)
        .then((data) => {
          if (data.count === 0) {
            this.$router.push({
              path: '/dashboard',
            });
          }
          this.group = null;
          this.group = data.groups;
        })
        .catch((err) => { console.log(err); });
    },
    refreshTasks(id = null) {
      Task.getAllByGroup(id || this.groupId)
        .then((data) => {
          this.tasks = [];
          this.tasks = data.tasks;
        })
        .catch((err) => { console.log(err); });
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

.groupImage {
  height: 20vh;
  width: 100%;
  overflow: hidden;
  position: relative;

  img {
    width: 100%;
    height: auto;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
}

</style>
