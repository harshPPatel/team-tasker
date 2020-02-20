<template src="./GroupList.html"></template>

<script>
import { mapState } from 'vuex';

import GROUPS from '../../graphql/GROUPS';
import GroupCard from '../GroupCard/GroupCard.vue';

export default {
  name: 'group-list',
  computed: mapState(['Group']),
  components: { GroupCard },
  data: () => ({
    error: false,
    snackbar: false,
  }),
  mounted() {
    if (!this.$store.state.Group.groups
      || !this.$store.state.Group.groups.length) {
      this.$apollo.query({ query: GROUPS })
        .then(({ data }) => {
          this.$store.commit('Group/setGroups', data.groups);
        })
        .catch((err) => {
          this.error = err.message;
          this.snackbar = true;
        });
    }
  },
};
</script>
