<template>
  <div class="container">
    <b-jumbotron
      header="Welcome!"
      :lead="lead">
      <hr class="my-4">
      <p>For more information visit about page</p>
      <!-- Links -->
      <b-button variant="primary" to="/signup">
        Signup
      </b-button>
      <b-button variant="secondary" class="ml-3" to="/about">
        Learn More
      </b-button>
    </b-jumbotron>
  </div>
</template>

<script>
export default {
  name: 'home',
  data: () => ({
    lead: 'Team Tasker is a simple website to manage your tasks. Sign up today! It is free and secure!',
  }),
};
</script>
