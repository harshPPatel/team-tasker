<template src="./TaskList.html"></template>

<script>
import { format } from 'fecha';

import { taskEditor } from '../../vue2-editor.config';

export default {
  name: 'task-list',
  props: ['tasks'],
  data: () => ({
    editorConfig: taskEditor,
    isLoading: false,
    headers: [
      { text: 'Task', value: 'task' },
      { text: 'Urgency', value: 'urgency' },
      { text: 'Is Done?', value: 'isDone' },
      { text: 'Created At', value: 'createdAt' },
      { text: 'Actions', value: 'action', sortable: false },
      { text: '', value: 'data-table-expand' },
    ],
    dialog: false,
    editedIndex: -1,
    editedItem: {
      id: '',
      task: '',
      description: '',
      isDone: 0,
      urgency: 0,
      dueDate: '',
    },
    defaultItem: {
      id: '',
      task: '',
      description: '',
      isDone: 0,
      urgency: 0,
      dueDate: '',
    },
    urgencyOptions: [
      { text: 'Low', value: 0, color: 'orange' },
      { text: 'Medium', value: 1, color: 'green' },
      { text: 'High', value: 2, color: 'red' },
    ],
    dateMenu: false,
  }),
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? 'New Task' : 'Edit Task';
    },
  },
  watch: {
    dialog(val) {
      // eslint-disable-next-line
      val || this.close()
    },
  },
  methods: {
    allowedDates(val) {
      return new Date(val) >= Date.now();
    },

    editItem(item) {
      this.editedIndex = this.tasks.indexOf(item);
      this.editedItem = { ...item };
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.tasks.indexOf(item);
      // eslint-disable-next-line
      confirm('Are you sure you want to delete this item?') && this.tasks.splice(index, 1);
      // Add delete confirmation dialog
      // Make delete request
      // update store
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = { ...this.defaultItem };
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        // make request for edit
        Object.assign(this.group.tasks[this.editedIndex], this.editedItem);
        // update vuex store and data
        // REFACTOR: bind markup values with vuex store not group data prop
      } else {
        // Make request for new task
        this.group.tasks.push(this.editedItem);
        // update vuex store and data
      }
      this.close();
    },

    computedDate: (date) => format(+date, 'mediumDate'),
  },
};
</script>
