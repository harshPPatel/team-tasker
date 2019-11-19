<template>
  <!-- Modal -->
  <div class="modal fade" :id="`editTaskModal${task.taskId}`" tabindex="-1"
    role="dialog" aria-labelledby="editTaskModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add New Assigned Task</h5>
          <button type="button" class="close"
            :id="`editAssignedTaskClose${task.taskId}`" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <error-component v-if="error.serverError" :error="error.serverError"></error-component>
            <form :id="`editGroupForm${task.taskId}`" @submit.prevent="submitForm">
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
                  <div class="row">
                    <div class="col-6">
                      <label class="col-form-label" for="addUser">Assigned User</label>
                    </div>
                    <div class="col-6">
                      <select name="addUser" class="form-control" id="addUser" required
                        v-model="task.userId">
                        <option selected disabled>Select the User</option>
                        <option v-for="user in users" :value="user.userId"
                          :key="`user-${user.userId}`">
                          {{ user.username }}
                        </option>
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
                      <datetime type="datetime" v-model="task.dueDate"></datetime>
                      <p>Leave it empty if you want to use default data {{ task.dueDate }}</p>
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
import AssignedTasks from '../lib/AssignedTasks';
import ErrorComponent from './ErrorComponent.vue';

export default {
  name: 'add-task',
  components: {
    ErrorComponent,
  },
  props: ['assignedTask', 'users'],
  data: () => ({
    task: {
      task: '',
      status: false,
      urgency: 0,
      description: '',
      dueDate: '',
      groupId: null,
      userId: '',
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
    this.task = {
      ...this.task,
      ...this.assignedTask,
    };
  },
  methods: {
    submitForm() {
      this.error.serverError = null;
      const date = new Date(this.task.dueDate).toISOString().slice(0, 19).replace('T', ' ');
      const formData = this.task;
      formData.dueDate = date;
      formData.status = 0;
      this.isLoading = true;
      AssignedTasks.update(formData)
        .then(() => {
          this.isLoading = false;
          const closeButton = document.getElementById(`editAssignedTaskClose${this.task.taskId}`);
          closeButton.click();
          this.$emit('refresh-page');
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
