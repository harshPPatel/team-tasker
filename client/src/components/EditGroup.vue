<template>
  <!-- Modal -->
  <div class="modal fade" :id="`editGroupModal${group.groupId}`" tabindex="-1"
    role="dialog" aria-labelledby="editGroupModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Group</h5>
          <button type="button" class="close"
            :id="`editGroupClose${group.groupId}`" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <error-component v-if="serverError" :error="serverError"></error-component>
            <form :id="`editGroupForm${group.groupId}`" @submit.prevent="submitForm">
              <div class="row">
                <div class="col-12 mb-3">
                  <label class="col-form-label"
                    :for="`editGroupName${group.groupId}`">Group Name</label>
                  <!-- add required -->
                  <input type="text" class="form-control"
                    placeholder="Group Name" :id="`editGroupName${group.groupId}`" required
                    v-model="groupName"
                    :class="{ 'is-invalid': (groupNameError && !isValidGroupName) }"
                    @input="validateGroupName">
                  <div class="invalid-feedback" v-if="groupNameError">
                    {{ groupNameError }}
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <label class="col-form-label"
                    :for="`editGroupImage${group.groupId}`">Group Image</label>
                  <!-- add required -->
                  <input type="file" class="form-control-file" accept="image/*"
                    placeholder="Group Image" :id="`editGroupImage${group.groupId}`">
                </div>
                <div class="col-6">
                  <button type="reset" class="btn btn-info btn-block mt-4"
                    :disabled="isLoading">
                    Reset
                  </button>
                </div>
                <div class="col-6">
                  <button type="submit" class="btn btn-primary btn-block mt-4"
                    :disabled="(!isValidGroupName && groupNameError) || isLoading">
                    Submit
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ErrorComponent from './ErrorComponent.vue';
import Group from '../lib/Group';

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
      // console.log(formData.get('editGroupImage'));
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
