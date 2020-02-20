<template src="./Group.html"></template>

<script>
import { format } from 'fecha';

import TOKEN_VERIFY from '../../graphql/TOKEN_VERIFY';
import TASKS from '../../graphql/TASKS';

export default {
  name: 'group',
  data: () => ({
    group: [],
    error: null,
  }),
  computed: {
    computedGroupCreatedAt: (data) => {
      if (data.group.createdAt) {
        return format(+data.group.createdAt, 'mediumDate');
      }
      return '';
    },
    computedGroupUpdatedAt: (data) => {
      if (data.group.updatedAt) {
        return format(+data.group.updatedAt, 'mediumDate');
      }
      return '';
    },
  },
  mounted() {
    this.$apollo.mutate({
      mutation: TOKEN_VERIFY,
    })
      .then(({ data }) => {
        this.$store.commit('User/updateUsername', data.verify.username);
        this.$store.commit('User/updateIsLoggedIn', true);
      })
      .catch(() => {
        localStorage.removeItem('token');
        localStorage.removeItem('username');
        this.$store.dispatch('User/logoutUser');
        this.$router.push({
          name: 'Login',
          params: { errorMessage: 'Please login to get access' },
        });
      });
    const { id: groupId } = this.$route.params;
    const storeGroupId = this.$store.state.Task.groupId;
    if (!storeGroupId || storeGroupId !== groupId) {
      this.$apollo.query({
        query: TASKS,
        variables: { id: groupId.toString() },
      })
        .then(({ data }) => {
          this.$store.commit('Task/setTasks', data.group.tasks);
          this.$store.commit('Task/setGroupId', data.group.id);
          this.group = data.group;
        })
        .catch((err) => { this.error = err; });
    }
  },
};
</script>
