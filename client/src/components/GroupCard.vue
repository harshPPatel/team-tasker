<template>
  <div class="col-md-4 col-sm-6 col-12 p-2">
    <div class="card mb-3">
      <h3 class="card-header">{{ group.name }}</h3>
      <img style="height: 200px; width: 100%; display: block;"
        :src="groupImage" :alt="`${ group.name }'s Image`">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <b>Group's Owner : </b> {{ username }}
        </li>
      </ul>
      <div class="card-body">
        <router-link class="btn btn-sm btn-primary" :to="`/groups/${group.groupId}`">
          See Tasks
        </router-link>
        <a href="" class="btn btn-sm btn-info ml-2">
          Edit Group
        </a>
      </div>
      <div class="card-footer text-muted">
        <b>Last Modified At :</b> {{ group.modifiedAt }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'group-card',
  props: ['group'],
  data: () => ({
    groupImage: '',
  }),
  computed: {
    username() {
      return localStorage.username;
    },
  },
  mounted() {
    this.groupImage = `${decodeURIComponent(this.group.image)}`;
  },
};
</script>
