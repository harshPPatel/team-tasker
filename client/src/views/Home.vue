<template>
  <v-container>
    <v-row>
      <v-col cols="12" class="text-center mt-10">
        <h1 class="display-2 mb-5">Welcome to Team Tasker!</h1>
        <p class="subtitle-1">
          Team Tasker is a simple website to manage your tasks.
          <br>Sign up today! It is free and secure!
        </p>
        <!-- Links -->
        <v-row>
          <v-col class="text-center" cols="12">
            <v-btn to="/about" outlined large color="primary">about</v-btn>
            <v-btn to="/signup" depressed large color="primary" class="ml-5">signup</v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'home',
};
</script>
