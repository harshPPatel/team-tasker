<template>
  <!-- Modal -->
  <div class="modal fade" :id="`deleteTaskModal${taskId}`" tabindex="-1"
    role="dialog" aria-labelledby="deleteTaskModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Delete Task</h5>
          <button type="button" class="close"
            :id="`deleteTaskClose${taskId}`" data-dismiss="modal" aria-label="Close">
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
                      Do you really want to delete the task? You will not be able to recover it!
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
import Task from '../lib/Task';

export default {
  name: 'delete-task',
  props: ['taskId'],
  data: () => ({
    isLoading: false,
    serverError: null,
  }),
  components: {
    ErrorComponent,
  },
  methods: {
    submitForm() {
      const formData = {
        taskId: this.taskId,
      };
      this.isLoading = true;
      Task.deleteTask(formData)
        .then(() => {
          this.isLoading = false;
          this.$emit('refresh-tasks');
          this.closeModal();
        })
        .catch((err) => {
          this.isLoading = false;
          this.serverError = err;
        });
    },
    closeModal() {
      const closeButton = document.getElementById(`deleteTaskClose${this.taskId}`);
      closeButton.click();
    },
  },
};
</script>
