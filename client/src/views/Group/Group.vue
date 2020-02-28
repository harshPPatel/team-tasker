<template src="./Group.html"></template>

<script>
import { format } from 'fecha';

import TOKEN_VERIFY from '../../graphql/TOKEN_VERIFY';
import TASKS from '../../graphql/TASKS';

export default {
  name: 'group',
  data: () => ({
    group: [],
    error: null,
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
  }),
  computed: {
    computedGroupCreatedAt: (data) => {
      if (data.group.createdAt) {
        return format(+data.group.createdAt, 'mediumDate');
      }
      return '';
    },
    computedGroupUpdatedAt: (data) => {
      if (data.group.updatedAt) {
        return format(+data.group.updatedAt, 'mediumDate');
      }
      return '';
    },
    formTitle() {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item';
    },
  },
  watch: {
    dialog(val) {
      // eslint-disable-next-line
      val || this.close()
    },
  },
  mounted() {
    this.isLoading = true;
    this.$apollo.mutate({
      mutation: TOKEN_VERIFY,
    })
      .then(({ data }) => {
        this.$store.commit('User/updateUsername', data.verify.username);
        this.$store.commit('User/updateIsLoggedIn', true);
      })
      .catch(() => {
        localStorage.removeItem('token');
        localStorage.removeItem('username');
        this.$store.dispatch('User/logoutUser');
        this.$router.push({
          name: 'Login',
          params: { errorMessage: 'Please login to get access' },
        });
      });
    const { id: groupId } = this.$route.params;
    const storeGroupId = this.$store.state.Task.groupId;
    if (!storeGroupId || storeGroupId !== groupId) {
      this.$apollo.query({
        query: TASKS,
        variables: { id: groupId.toString() },
      })
        .then(({ data }) => {
          this.$store.commit('Task/setTasks', data.group.tasks);
          this.$store.commit('Task/setGroupId', data.group.id);
          this.group = data.group;
        })
        .catch((err) => { this.error = err; });
    }
    this.isLoading = false;
  },
  methods: {
    editItem(item) {
      this.editedIndex = this.group.tasks.indexOf(item);
      this.editedItem = { ...item };
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.group.tasks.indexOf(item);
      // eslint-disable-next-line
      confirm('Are you sure you want to delete this item?') && this.group.tasks.splice(index, 1);
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
