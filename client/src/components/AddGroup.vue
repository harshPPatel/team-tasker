<template>
  <!-- Modal -->
  <div class="modal fade" id="addGroupModal" tabindex="-1"
    role="dialog" aria-labelledby="addGroupModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add New Group</h5>
          <button type="button" class="close"
            id="addGroupClose" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form id="addGroupForm" @submit.prevent="submitForm">
              <div class="row">
                <div class="col-12 mb-3">
                  <label class="col-form-label" for="addGroupName">Group Name</label>
                  <!-- add required -->
                  <input type="text" class="form-control"
                    placeholder="Group Name" id="addGroupName" required
                    v-model="groupName"
                    :class="{ 'is-invalid': (groupNameError && !isValidGroupName) }"
                    @input="validateGroupName">
                  <div class="invalid-feedback" v-if="groupNameError">
                    {{ groupNameError }}
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <label class="col-form-label" for="addGroupImage">Group Image</label>
                  <!-- add required -->
                  <input type="file" class="form-control-file" accept="image/*"
                    placeholder="Group Image" id="addGroupImage" required
                    :class="{ 'is-invalid': (groupImageError && !isValidGroupImage) }"
                    @input="validateGroupImage">
                  <div class="invalid-feedback" v-if="groupImageError">
                    {{ groupImageError }}
                  </div>
                </div>
                <div class="col-6">
                  <button type="reset" class="btn btn-info btn-block mt-4"
                    :disabled="isLoading">
                    Reset
                  </button>
                </div>
                <div class="col-6">
                  <button type="submit" class="btn btn-primary btn-block mt-4"
                    :disabled="!(isValidGroupName && isValidGroupImage) || isLoading">
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
import Group from '../lib/Group';

export default {
  name: 'add-group',
  props: ['title'],
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
      this.isValidUsername = false;
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
        .catch(err => console.log(err));
    },
  },
};
</script>
