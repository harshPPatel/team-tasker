<template>
  <!-- Modal -->
  <div class="modal fade" :id="`editTaskModal${task.taskId}`" tabindex="-1"
    role="dialog" aria-labelledby="editTaskModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Task</h5>
          <button type="button" class="close"
            :id="`editTaskClose${task.taskId}`" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <error-component v-if="error.serverError" :error="error.serverError"></error-component>
            <form :id="`editTaskForm${task.taskId}`" @submit.prevent="submitForm">
              <div class="row">
                <div class="col-12 mb-3">
                  <label class="col-form-label" :for="`editTask${task.taskId}`">Task Title</label>
                  <!-- add required -->
                  <input type="text" class="form-control"
                    placeholder="Task Title" :id="`editTask${task.taskId}`" required
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
                      <label class="col-form-label"
                        :for="`editTaskStatus${task.taskId}`">Task Status</label>
                    </div>
                    <div class="col-6">
                      <input type="checkbox" class="form-check-input"
                        :id="`editTaskStatus${task.taskId}`"
                        v-model="task.status">
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="row">
                    <div class="col-6">
                      <label class="col-form-label"
                        :for="`editTaskUrgency${task.taskId}`">Task Urgency</label>
                    </div>
                    <div class="col-6">
                      <select :name="`editTaskUrgency${task.taskId}`"
                        class="form-control" :id="`editTaskUrgency${task.taskId}`"
                        required v-model="task.urgency">
                        <option value="0" selected>Low</option>
                        <option value="1">Medium</option>
                        <option value="2">High</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <label class="col-form-label">Task Description</label>
                  <wysiwyg v-model="task.description">{{ task.description }}</wysiwyg>
                </div>
                <div class="col-12 mb-3">
                  <div class="row">
                    <div class="col-6">
                      <label class="col-form-label">Task DueDate</label>
                    </div>
                    <div class="col-6">
                      <datetime type="datetime" v-model="task.dueDate"></datetime>
                      <p>Leave date empty if you do not want to change the dueDate</p>
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
                    :disabled="isLoading">
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
  name: 'edit-task',
  components: {
    ErrorComponent,
  },
  props: ['editTask'],
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
    this.task = { ...this.editTask };
    this.task.status = this.editTask.status === 0;
    this.task.groupId = this.editTask.groupId;
  },
  methods: {
    submitForm() {
      this.error.serverError = null;
      const date = new Date(this.task.dueDate).toISOString().slice(0, 19).replace('T', ' ');
      const formData = this.task;
      formData.dueDate = date;
      formData.status = this.task.status ? 1 : 0;
      this.isLoading = true;
      Task.update(formData)
        .then(() => {
          this.isLoading = false;
          this.$emit('refresh-tasks');
          const closeButton = document.getElementById(`editTaskClose${this.task.taskId}`);
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
