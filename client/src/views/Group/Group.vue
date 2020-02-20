<template src="./Group.html"></template>

<script>
import { format } from 'fecha';

import TASKS from '../../graphql/TASKS';

export default {
  name: 'group',
  data: () => ({
    group: [],
    error: null,
  }),
  computed: {
    computedGroupCreatedAt: (data) => {
      if (data.group) {
        return format(+data.group.createdAt, 'mediumDate');
      }
      return '';
    },
    computedGroupUpdatedAt: (data) => {
      if (data.group) {
        return format(+data.group.updatedAt, 'mediumDate');
      }
      return '';
    },
  },
  mounted() {
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
