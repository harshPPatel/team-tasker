<template src="./AddGroup.html"></template>

<script>
/* eslint-disable no-console */
import ErrorComponent from '../ErrorComponent.vue';
import Group from '../../lib/Group';

export default {
  name: 'add-group',
  components: {
    ErrorComponent,
  },
  data: () => ({
    groupName: '',
    isValidGroupName: false,
    isValidGroupImage: false,
    groupNameError: '',
    groupImageError: '',
    isLoading: false,
    serverError: null,
  }),
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
    validateGroupImage(e) {
      this.groupImageError = '';
      if (e.target.value) {
        console.log('changed');
        this.isValidGroupImage = true;
      } else {
        this.isValidGroupImage = false;
        this.groupImageError = 'Group Image is required';
      }
    },
    submitForm() {
      const form = document.getElementById('addGroupForm');
      const formFileInput = document.getElementById('addGroupImage');
      const formData = new FormData(form);
      formData.append('addGroupName', this.groupName.trim());
      formData.append('addGroupImage', formFileInput.files[0], formFileInput.files[0].name);
      // console.log(formData.get('addGroupImage'));
      Group.create(formData)
        .then(() => {
          this.$emit('refresh-groups');
          const closeButton = document.getElementById('addGroupClose');
          closeButton.click();
        })
        .catch((err) => {
          this.serverError = err;
        });
    },
  },
};
</script>
