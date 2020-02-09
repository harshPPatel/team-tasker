<template>
  <div id="app">
    <div id="nav">
      <navigation></navigation>
    </div>
    <router-view class="container"/>
  </div>
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
@import "~vue-wysiwyg/dist/vueWysiwyg.css";
@import "~vue-datetime/dist/vue-datetime.css";
</style>
