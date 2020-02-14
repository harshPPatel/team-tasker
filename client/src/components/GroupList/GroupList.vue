<template src="./GroupList.html"></template>

<script>
import { mapState } from 'vuex';

import GROUPS from '../../graphql/GROUPS';
import Group from '../Group/Group.vue';

export default {
  name: 'group-list',
  computed: mapState(['Group']),
  components: { Group },
  data: () => ({
    error: false,
    snackbar: false,
  }),
  mounted() {
    if (!this.$store.state.Group.groups
      || !this.$store.state.Group.groups.length) {
      this.$apollo.query({ query: GROUPS })
        .then(({ data }) => {
          setTimeout(() => {
            this.$store.commit('Group/setGroups', data.groups);
          }, 2000);
        })
        .catch((err) => {
          this.error = err.message;
          this.snackbar = true;
        });
    }
  },
};
</script>
