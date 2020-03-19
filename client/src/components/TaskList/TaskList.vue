<template src="./TaskList.html"></template>

<script>
import { format } from 'fecha';
import { mapGetters } from 'vuex';

import { taskEditor } from '../../vue2-editor.config';
import EDIT_TASK from '../../graphql/EDIT_TASK';

export default {
  name: 'task-list',
  // props: ['tasks'],
  data: () => ({
    editorConfig: taskEditor,
    isLoading: false,
    headers: [
      { text: 'Task', value: 'task' },
      { text: 'Urgency', value: 'urgency' },
      { text: 'Is Done?', value: 'isDone' },
      { text: 'Due Date', value: 'dueDate' },
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
      urgency: 1,
      dueDate: '',
    },
    defaultItem: {
      id: '',
      task: '',
      description: '',
      isDone: 0,
      urgency: 1,
      dueDate: '',
    },
    urgencyOptions: [
      { text: 'Low', value: 0 },
      { text: 'Medium', value: 1 },
      { text: 'High', value: 2 },
    ],
    dateMenu: false,
  }),
  computed: {
    ...mapGetters({
      tasks: 'Task/getTasks',
    }),
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
    editItem(item) {
      this.editedIndex = this.tasks.indexOf(item);
      this.editedItem = { ...item };
      this.editedItem.dueDate = item.dueDate ? new Date(+item.dueDate) : '';
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
        const payload = {
          id: this.editedItem.id,
          task: this.editedItem.task,
          description: this.editedItem.description,
          isDone: this.editedItem.isDone,
          urgency: this.editedItem.urgency,
        };
        if (this.editedItem.dueDate) {
          payload.dueDate = new Date(+this.editedItem.dueDate);
        }
        this.$apollo.mutate({
          mutation: EDIT_TASK,
          variables: {
            task: payload,
          },
        })
          .then(({ data }) => {
            console.log(data.editTask.task);
            this.$store.commit('Task/setTask', data.editTask.task);
            // this.$router.push({ path: '/dashboard' });
            this.close();
          })
          .catch((err) => {
            this.error = err.message.replace('GraphQL error: ', '');
          });
        // this.isLoading = false;
        // Object.assign(this.tasks[this.editedIndex], this.editedItem);
        // update vuex store and data
        // REFACTOR: bind markup values with vuex store not group data prop
      } else {
        // Make request for new task
        this.group.tasks.push(this.editedItem);
        // update vuex store and data
      }
    },

    computedDate: (date) => format(new Date(+date), 'MM-DD-YYYY [at] hh:mm A'),
  },
};
</script>
