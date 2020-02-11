<template>
  <vue-editor v-model="content" />
</template>

<script>
export default {
  name: 'editor',
  data() {
    return {
      content: '<h1>Hello from editor</h1>',
    };
  },
};
</script>
