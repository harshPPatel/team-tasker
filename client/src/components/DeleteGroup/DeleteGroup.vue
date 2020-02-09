<template src="./DeleteGroup.html"></template>

<script>
import ErrorComponent from '../ErrorComponent.vue';
import Group from '../../lib/Group';

export default {
  name: 'delete-group',
  props: ['groupId'],
  data: () => ({
    isLoading: false,
    serverError: null,
  }),
  components: {
    ErrorComponent,
  },
  methods: {
    submitForm() {
      const formData = new FormData();
      formData.append('id', this.groupId);
      Group.deleteGroup(formData)
        .then(() => {
          this.closeModal();
          this.$router.push({
            path: '/dashboard',
          });
        })
        .catch((err) => {
          this.serverError = err;
        });
    },
    closeModal() {
      const closeButton = document.getElementById('deleteGroupClose');
      closeButton.click();
    },
  },
};
</script>
