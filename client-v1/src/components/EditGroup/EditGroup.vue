<template src="./EditGroup.html"></template>

<script>
/* eslint-disable no-console */
import ErrorComponent from '../ErrorComponent.vue';
import Group from '../../lib/Group';

export default {
  name: 'edit-group',
  props: ['group'],
  data: () => ({
    groupName: '',
    isValidGroupName: false,
    groupNameError: '',
    isLoading: false,
    serverError: null,
  }),
  components: {
    ErrorComponent,
  },
  mounted() {
    this.groupName = this.group.name;
  },
  methods: {
    validateGroupName() {
      this.groupNameError = '';
      this.isValidGroupName = false;
      const groupName = this.groupName.trim();

      if (groupName.match(/^[a-zA-Z0-9 ]{2,20}$/) != null) {
        this.isValidGroupName = true;
      } else {
        this.isValidGroupName = false;
        this.groupNameError = 'Invalid Group Name. Please enter alpha numeric number between 2 to 20 characters';
      }
    },
    submitForm() {
      const form = document.getElementById(`editGroupForm${this.group.groupId}`);
      const formFileInput = document.getElementById(`editGroupImage${this.group.groupId}`);
      const formData = new FormData(form);
      formData.append('id', this.group.groupId);
      formData.append('name', this.groupName.trim());
      if (formFileInput.files[0]) {
        formData.append('image', formFileInput.files[0], formFileInput.files[0].name);
      }
      this.isLoading = true;
      Group.update(formData)
        .then(() => {
          this.isLoading = false;
          this.$emit('refresh-groups');
          const closeButton = document.getElementById(`editGroupClose${this.group.groupId}`);
          closeButton.click();
        })
        .catch((err) => {
          this.isLoading = false;
          this.serverError = err;
        });
    },
  },
};
</script>
