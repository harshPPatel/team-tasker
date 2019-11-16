<template>
  <div class="container mt-5">
    <div class="flex-container">
      <div class="">
        <h1>Dashboard</h1>
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
  </div>
</template>

<script>
import Group from '../lib/Group';
import GroupCard from '../components/GroupCard.vue';
import AddGroup from '../components/AddGroup.vue';

export default {
  name: 'dashboard',
  data: () => ({
    groups: [],
  }),
  components: {
    GroupCard,
    AddGroup,
  },
  computed: {
    username() {
      return localStorage.username;
    },
  },
  mounted() {
    Group.getAll()
      .then((data) => {
        this.groups = data.groups;
      })
      .catch((err) => {
        console.log(err);
      });
  },
  methods: {
    refreshGroups() {
      Group.getAll()
        .then((data) => {
          this.groups = data.groups;
        })
        .catch((err) => {
          console.log(err);
        });
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
