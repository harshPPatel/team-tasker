<template>
  <v-row>
    <v-col cols="12" class="text-center">
      <h1 class="display-3 mb-7 mt-10">Team Tasker</h1>
      <p class="subtitle-1">
        This app is created as a part of Assignment in Red River College which later
        <br>I have improved in free  time. It is a full
        stack app with GraphQL API and VueJS app.
      </p>
      <p>Sign up now. It is fully open source and free!</p>
      <v-btn color="primary" depressed large to="/signup">
        Signup
      </v-btn>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'about',
};
</script>
