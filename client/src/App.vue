<template>
  <div id="app">
    <!-- Navigation -->
    <div id="nav">
      <navigation></navigation>
    </div>
    <!-- Router View -->
    <router-view class="container"/>
  </div>
</template>

<script>
import Navigation from './components/Navigation/Navigation.vue';

export default {
  name: 'App',
  components: { Navigation },
};
</script>

<style lang="scss">
@import "~vue-wysiwyg/dist/vueWysiwyg.css";
@import "~vue-datetime/dist/vue-datetime.css";
// @import '~bootstrap/scss/bootstrap';
// @import '~bootstrap-vue/src/index.scss';
</style>
