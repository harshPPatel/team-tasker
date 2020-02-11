<template>
  <h1>Dashboard</h1>
</template>

<script>
import TOKEN_VERIFY from '../../graphql/TOKEN_VERIFY';

export default {
  name: 'dashboard',
  mounted() {
    this.$apollo.mutate({
      mutation: TOKEN_VERIFY,
    })
      .catch(() => {
        localStorage.removeItem('token');
        localStorage.removeItem('username');
        this.$store.dispatch('User/logoutUser');
        this.$router.push({
          name: 'Login',
          params: { errorMessage: 'Please login to get access' },
        });
      });
  },
};
</script>
