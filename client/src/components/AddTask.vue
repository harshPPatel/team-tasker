<template>
  <!-- Modal -->
  <div class="modal fade" id="addTaskModal" tabindex="-1"
    role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add New Task</h5>
          <button type="button" class="close"
            id="addTaskClose" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <error-component v-if="error.serverError" :error="error.serverError"></error-component>
            <form id="addGroupForm" @submit.prevent="submitForm">
              <div class="row">
                <div class="col-12 mb-3">
                  <label class="col-form-label" for="addTask">Task Title</label>
                  <!-- add required -->
                  <input type="text" class="form-control"
                    placeholder="Task Title" id="addTask" required
                    v-model="task.task"
                    :class="{ 'is-invalid': (error.taskError && !validation.isValidTask) }"
                    @input="validateTask">
                  <div class="invalid-feedback" v-if="error.taskError">
                    {{ error.taskError }}
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="row">
                    <div class="col-6">
                      <label class="col-form-label" for="addUrgency">Task Urgency</label>
                    </div>
                    <div class="col-6">
                      <select name="addUrgency" class="form-control" id="addUrgency" required
                        v-model="task.urgency">
                        <option value="0" selected>Low</option>
                        <option value="1">Medium</option>
                        <option value="2">High</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <label class="col-form-label">Task Description</label>
                  <wysiwyg v-model="task.description"/>
                </div>
                <div class="col-12 mb-3">
                  <div class="row">
                    <div class="col-6">
                      <label class="col-form-label">Task DueDate</label>
                    </div>
                    <div class="col-6">
                      <datetime type="datetime" v-model="task.dueDate" required></datetime>
                    </div>
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
                    :disabled="!(validation.isValidTask) || isLoading">
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
import Task from '../lib/Task';
import ErrorComponent from './ErrorComponent.vue';

export default {
  name: 'add-task',
  components: {
    ErrorComponent,
  },
  props: ['groupId'],
  data: () => ({
    task: {
      task: '',
      status: false,
      urgency: 0,
      description: '',
      dueDate: '',
      groupId: null,
    },
    error: {
      serverError: null,
      taskError: '',
    },
    isLoading: false,
    validation: {
      isValidTask: false,
    },
  }),
  mounted() {
    this.task.groupId = (this.groupId === 'null') ? this.groupId : null;
  },
  methods: {
    submitForm() {
      this.error.serverError = null;
      const date = new Date(this.task.dueDate).toISOString().slice(0, 19).replace('T', ' ');
      const formData = this.task;
      formData.dueDate = date;
      formData.status = 0;
      this.isLoading = true;
      Task.create(formData)
        .then(() => {
          this.isLoading = false;
          this.$emit('refresh-page');
          const closeButton = document.getElementById('addTaskClose');
          closeButton.click();
        })
        .catch((err) => {
          this.isLoading = false;
          this.error.serverError = err;
        });
    },
    validateTask() {
      this.validation.isValidTask = false;
      this.error.taskError = '';
      if (this.task.task.trim().length > 2) {
        this.validation.isValidTask = true;
      } else {
        this.error.taskError = 'Mimimum 2 characters are required as task title';
      }
    },
  },
};
</script>

<style>

.taskStatus {
  /* align-items: flex-start; */
  justify-content: center;
  width: initial;
}

</style>
