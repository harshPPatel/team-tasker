<template src="./Group.html"></template>

<script>
import TASKS from '../../graphql/TASKS';

export default {
  name: 'group',
  mounted() {
    const { id } = this.$route.params;
    const group = this.$store.getters.Group.getGroup(id);
    console.log(this.$store.getters);
    if (!group || !group.tasks) {
      this.$apollo.query({ query: TASKS })
        .then(({ data }) => {
          setTimeout(() => {
            this.$store.commit('Group/setTasks', {
              tasks: data.group.tasks,
              id: data.group.id,
            });
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
