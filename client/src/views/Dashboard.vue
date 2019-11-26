<template>
  <div class="container mt-5">
    <div class="flex-container">
      <div class="">
        <h1>Other Groups</h1>
      </div>
    </div>
    <hr>
    <div class="row">
      <group-card :group="inboxGroup"></group-card>
      <group-card :group="assignedTasks"></group-card>
    </div>
    <div class="flex-container mt-5">
      <div class="">
        <h1>Groups</h1>
      </div>
      <div class="ml-auto text-right">
        <button type="button" class="btn btn-success"
          data-toggle="modal" data-target="#addGroupModal">Add Group</button>
      </div>
    </div>
    <hr>
    <div class="row">
      <group-card v-for="group in groups" :group="group" :key="group.groupId"></group-card>
      <div class="col-12 mt-4" v-if="groups.length === 0">
        <h4>No groups found! Create groups now!</h4>
      </div>
    </div>
    <add-group v-on:refresh-groups="refreshGroups"></add-group>
    <edit-group v-for="group in groups" :group="group"
      :key="group.groupId" v-on:refresh-groups="refreshGroups"></edit-group>
  </div>
</template>

<script>
/* eslint-disable no-console */
import Group from '../lib/Group';
import GroupCard from '../components/GroupCard.vue';
import AddGroup from '../components/AddGroup.vue';
import EditGroup from '../components/EditGroup.vue';
import InboxImage from '../assets/img/inbox-group.jpg';
import AssignedTasksImage from '../assets/img/assigned-tasks-group.jpg';

export default {
  name: 'dashboard',
  data: () => ({
    groups: [],
    inboxGroup: {
      groupId: 'inbox',
      name: 'Inbox',
      image: InboxImage,
    },
    assignedTasks: {
      groupId: 'assignedTasks',
      name: 'Assigned Tasks',
      image: AssignedTasksImage,
    },
  }),
  components: {
    GroupCard,
    AddGroup,
    EditGroup,
  },
  computed: {
    username() {
      return localStorage.username;
    },
  },
  mounted() {
    Group.getAll()
      .then((data) => {
        /* eslint-disable no-param-reassign */
        data.groups.forEach((group) => {
          group.image = `https://team-tasker-api.000webhostapp.com/uploads/${group.image}`;
        });
        /* eslint-enable no-param-reassign */
        this.groups = data.groups;
      })
      .catch((err) => {
        console.log(err);
      });
  },
  methods: {
    refreshGroups() {
      let userGroups = [];
      Group.getAll()
        .then((data) => {
          this.groups = null;
          userGroups = data.groups;
        })
        .catch((err) => {
          console.log(err);
        });
      this.groups = userGroups.map(group => ({
        ...group,
        image: `https://team-tasker-api.000webhostapp.com/uploads/${group.image}`,
      }));
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
