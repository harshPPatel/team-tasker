<template>
  <navigation></navigation>
</template>

<script>
import Navigation from './components/Navigation/Navigation.vue';

export default {
  name: 'App',
  components: {
    Navigation,
  },
};
</script>

<style lang="scss">
@import "~vue2-editor/dist/vue2-editor.css";
@import "./assets/scss/quill-styles.scss";
</style>
