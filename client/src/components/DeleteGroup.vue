<template>
  <!-- Modal -->
  <div class="modal fade" :id="`deleteGroupModal${groupId}`" tabindex="-1"
    role="dialog" aria-labelledby="deleteGroupModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Delete Group</h5>
          <button type="button" class="close"
            id="deleteGroupClose" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <error-component v-if="serverError" :error="serverError"></error-component>
            <form @submit.prevent="submitForm">
              <div class="row">
                <div class="col-12 mb-3">
                  <p class="text-danger">
                    <b>
                      Do you really want to delete the group? You will not be able to recover it!
                    </b>
                  </p>
                </div>
                <div class="col-6">
                  <button type="reset" class="btn btn-info btn-block mt-4"
                    :disabled="isLoading" @click="closeModal">
                    Cancel
                  </button>
                </div>
                <div class="col-6">
                  <button type="submit" class="btn btn-danger btn-block mt-4"
                    :disabled="isLoading">
                    Delete
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
