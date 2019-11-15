<template>
  <div class="alert alert-dismissible alert-warning">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4 class="alert-heading">Error - {{ error.errorCode }}</h4>
    <p class="mb-0">
      {{ error.message }}
    </p>
  </div>
</template>

<script>
export default {
  name: 'error-component',
  props: ['error'],
};
</script>
