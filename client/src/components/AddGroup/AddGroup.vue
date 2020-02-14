<template src="./AddGroup.html"></template>

<script>
import ADD_GROUP_MUTATION from '../../graphql/ADD_GROUP';
import editorConfig from '../../vue2-editor.config';

const IMAGE_URL_REGEX = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([-.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

export default {
  name: 'add-group',
  data: () => ({
    dialog: false,
    isValid: false,
    isLoading: false,
    error: null,
    successMessage: null,
    snackbar: false,
    editorConfig,
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
      (v) => (
        v ? (IMAGE_URL_REGEX.test(v) || 'Please enter valid URL') : true
      ),
    ],
  }),
  methods: {
    closeForm() {
      this.$refs.addGroupForm.resetValidation();
      this.group.name = '';
      this.group.imageUrl = '';
      this.group.description = '';
      this.dialog = false;
    },
    submitForm() {
      this.error = null;
      this.successMessage = null;
      this.isLoading = true;
      const payload = {
        name: this.group.name.toString(),
      };
      if (this.group.imageUrl) {
        payload.imageUrl = this.group.imageUrl.toString();
      }
      if (this.group.description) {
        payload.description = this.group.description.toString();
      }
      this.$apollo.mutate({
        mutation: ADD_GROUP_MUTATION,
        variables: {
          input: payload,
        },
      })
        .then(({ data }) => {
          this.$emit('success', data.createGroup.message);
          this.$store.commit('Group/addGroup', data.createGroup.group);
          this.dialog = false;
        })
        .catch((err) => {
          this.error = err.message;
        });
      this.isLoading = false;
    },
  },
};
</script>
