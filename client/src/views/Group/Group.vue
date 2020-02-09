<template src="./Group.html"></template>

<style lang="scss" src="./Group.scss"></style>

<script>
/* eslint-disable no-console */
import Group from '../../lib/Group';
import Task from '../../lib/Task';
import AssignedTasks from '../../lib/AssignedTasks';
import EditGroup from '../../components/EditGroup/EditGroup.vue';
import DeleteGroup from '../../components/DeleteGroup/DeleteGroup.vue';
import TaskCard from '../../components/TaskCard/TaskCard.vue';
import AddTask from '../../components/AddTask/AddTask.vue';
import EditTask from '../../components/EditTask/EditTask.vue';
import DeleteTask from '../../components/DeleteTask/DeleteTask.vue';
import InboxImage from '../../assets/img/inbox-group.jpg';
import AssignedTasksImage from '../../assets/img/assigned-tasks-group.jpg';

export default {
  name: 'group',
  components: {
    EditGroup,
    DeleteGroup,
    TaskCard,
    AddTask,
    EditTask,
    DeleteTask,
  },
  data: () => ({
    group: null,
    tasks: [],
    isSpecial: false,
  }),
  computed: {
    groupId() {
      return this.$route.params.id;
    },
  },
  mounted() {
    /* eslint-disable */
    console.log(isNaN(this.$route.params.id));
    if (!isNaN(this.$route.params.id)) {
      this.isSpecial = false;
      this.refreshGroup(this.$route.params.id);
      this.refreshTasks(this.$route.params.id);
    } else {
      this.isSpecial = true;
      if (this.$route.params.id === 'inbox') {
        this.group = {
          groupId: 'inbox',
          name: 'Inbox',
          image: InboxImage,
        };
        this.inboxTasks();
      }
      if (this.$route.params.id === 'assignedTasks') {
        this.group = {
          groupId: 'assignedTasks',
          name: 'Assigned Tasks',
          image: AssignedTasksImage,
        };
        this.assignedTasks();
      }
    }
  },
  methods: {
    refreshGroup(id = null) {
      Group.getSingle(id || this.groupId)
        .then((data) => {
          if (data.count === 0) {
            this.$router.push({
              path: '/dashboard',
            });
          }
          this.group = null;
          this.group = data.groups;
        })
        .catch((err) => { console.log(err); });
    },
    inboxTasks() {
      Task.getAll()
        .then((data) => {
          this.tasks = [];
          this.tasks = data.tasks.filter(task => task.groupId === null);
        })
        .catch((err) => { console.log(err); });
    },
    assignedTasks() {
      AssignedTasks.getAll()
        .then((data) => {
          this.tasks = [];
          // const assignedTasks = data.tasks.map((task) => {
          //   const assignedTask = {
          //     ...task,
          //     isAssignedTask: true,
          //   };
          //   return assignedTask;
          // });
          /* eslint-disable */
          data.tasks.forEach((task) => {
            task.isAssignedTask = true;
          });
          console.log(data.tasks);
          /* eslint-rnable */
          this.tasks = data.tasks;
        })
        .catch((err) => { console.log(err); });
    },
    refreshTasks(id = null) {
      Task.getAllByGroup(id || this.groupId)
        .then((data) => {
          this.tasks = [];
          this.tasks = data.tasks;
        })
        .catch((err) => { console.log(err); });
    },
    refreshPage() {
      this.$router.go();
    },
  },
};
</script>
