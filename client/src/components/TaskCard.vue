<template>
  <div class="col-md-4 col-sm-6 col-12 p-2">
    <div class="card mb-3 text-dark">
      <h3 class="card-header bg-primary text-white">{{ task.task }}</h3>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <b>Task's Status : </b> {{ (task.status === "0") ? 'Uncomplete' : 'Completed' }}
        </li>
        <li class="list-group-item">
          <b>Task's Urgency : </b> {{ taskUrgency }}
        </li>
        <li class="list-group-item">
          <b>Task's Due Date : </b> {{ taskDueDate }}
        </li>
        <li class="list-group-item">
          <p><b>Task's Description : </b></p>
          <div v-html="taskDescription"></div>
        </li>
      </ul>
      <div class="card-body" v-if="!task.isAssignedTask">
        <button class="btn btn-sm btn-primary mr-2"
          data-toggle="modal" :data-target="`#editTaskModal${task.taskId}`">
          Edit Task
        </button>
        <button class="btn btn-sm btn-danger"
          data-toggle="modal" :data-target="`#deleteTaskModal${task.taskId}`">
          Delete Task
        </button>
      </div>
      <div class="card-body" v-if="task.isAssignedTask">
        <button class="btn btn-sm btn-primary mr-2"
          @click="completeTask(task.taskId)">
          {{ task.status === '1' ? 'Uncomplete Task' : 'Complete Task'}}
        </button>
      </div>
      <div class="card-footer text-muted">
        <b>Owner :</b> {{ username }}
      </div>
      <div class="card-footer text-muted">
        <b>Last Modified At :</b> {{ task.modifiedAt }}
      </div>
    </div>
  </div>
</template>

<script>
import HTMLDecoder from '../lib/HTMLDecoder';
import AssignedTasks from '../lib/AssignedTasks';

export default {
  name: 'task-card',
  props: ['task'],
  data: () => ({
    groupImage: '',
  }),
  computed: {
    username() {
      return localStorage.username;
    },
    taskUrgency() {
      switch (Number(this.task.urgency)) {
        case 0:
          return 'Low';
        case 1:
          return 'Medium';
        case 2:
          return 'High';
        default:
          return 'Undefined';
      }
    },
    taskDueDate() {
      const date = new Date(this.task.dueDate);
      const stringDate = date.toDateString();
      return stringDate;
    },
    taskDescription() {
      const decoded = HTMLDecoder(this.task.description, 'ENT_QUOTES');
      return decoded;
    },
  },
  methods: {
    completeTask(id) {
      const formData = {
        assignedTaskId: id,
        status: (this.task.status === '0') ? '1' : '0',
      };
      AssignedTasks.complete(formData)
        .then(() => this.$emit('refresh-page'));
    },
  },
};
</script>
