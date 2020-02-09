<template>
  <div class="container">
    <div class="jumbotron">
      <h1 class="display-3">
        <small>Welcome to</small> Team Tasker
      </h1>
      <p class="lead">
        A simple website to manage your tasks. Sign up today! It is free and secure!
      </p>
      <hr class="my-4">
      <p class="lead">
        <router-link class="btn btn-primary" role="button" to="/signup">
          Sign Up
        </router-link>
        <router-link class="btn btn-secondary ml-3" role="button" to="/about">
          Learn More
        </router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'home',
};
</script>
