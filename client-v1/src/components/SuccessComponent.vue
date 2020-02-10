<template>
  <div class="alert alert-dismissible alert-warning">
    <button type="button" class="close" data-dismiss="alert"
      @click.prevent="clearMessage">&times;</button>
    <h4 class="alert-heading">Success!</h4>
    <p class="mb-0">
      {{ message }}
    </p>
  </div>
</template>

<script>
export default {
  name: 'error-component',
  props: ['message', 'field'],
  methods: {
    clearMessage() {
      localStorage.removeItem(this.field);
    },
  },
};
</script>
