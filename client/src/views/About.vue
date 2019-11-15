<template>
  <div class="mt-5 text-center">
    <h1 class="display-3">Team Tasker</h1>
    <hr>
    <p>
      This app is created as a part of Assignment in Red River College. It is a full
      stack app with PHP API and VueJS app.
    </p>
    <p>Sign up now. It is fully open source and free!</p>
    <router-link class="btn btn-primary" role="button" to="/signup">
      Sign Up
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'about',
};
</script>
