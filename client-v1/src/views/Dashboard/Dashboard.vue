<template src="./Dashboard.html"></template>

<style lang="scss" src="./Dashboard.scss"></style>

<script>
/* eslint-disable no-console */
import Group from '../../lib/Group';
import GroupCard from '../../components/GroupCard.vue';
import AddGroup from '../../components/AddGroup/AddGroup.vue';
import EditGroup from '../../components/EditGroup/EditGroup.vue';
import InboxImage from '../../assets/img/inbox-group.jpg';
import AssignedTasksImage from '../../assets/img/assigned-tasks-group.jpg';

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
