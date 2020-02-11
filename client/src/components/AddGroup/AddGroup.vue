<template src="./AddGroup.html"></template>

<script>
import Editor from '../Editor.vue';

const IMAGE_URL_REGEX = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([-.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

export default {
  name: 'add-group',
  components: { Editor },
  data: () => ({
    dialog: false,
    isValid: false,
    group: {
      name: '',
      imageUrl: '',
      description: '',
    },
    groupNameRules: [
      (v) => !!v || 'Group name is required',
      (v) => v.length <= 40 || 'Only 40 characters are allowed in group name.',
    ],
    groupImageRules: [
      (v) => IMAGE_URL_REGEX.test(v) || 'Please enter valid Image URL',
    ],
  }),
  methods: {
    resetForm: () => {
      this.group.name = '';
      this.group.description = '';
      this.group.imageUrl = '';
      this.dialog = false;
    },
  },
};
</script>
