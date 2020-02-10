<template src="./Login.html"></template>

<script>
import User from '../../lib/User';
import ErrorComponent from '../../components/ErrorComponent.vue';
import SuccessComponent from '../../components/SuccessComponent.vue';

export default {
  name: 'login',
  components: {
    ErrorComponent,
    SuccessComponent,
  },
  data: () => ({
    user: {
      username: '',
      password: '',
    },
    isValidUsername: false,
    isValidPassword: false,
    isLoading: false,
    errors: {
      username: '',
      password: '',
    },
    authError: null,
    authSuccess: null,
  }),
  mounted() {
    if (localStorage.authError) {
      this.authError = JSON.parse(localStorage.authError);
    }
    if (localStorage.authSuccess) {
      this.authSuccess = localStorage.authSuccess;
    }
  },
  methods: {
    submitForm() {
      this.isLoading = true;
      User.login(this.user)
        .then((data) => {
          localStorage.removeItem('authError');
          localStorage.removeItem('authSuccess');
          localStorage.token = data.token;
          localStorage.username = data.username;
          this.isLoading = false;
          this.$router.push({ name: 'dashboard' });
        })
        .catch((err) => {
          this.authError = err;
          this.isLoading = false;
        });
    },
    validateUsername() {
      this.errors.username = '';
      this.isValidUsername = false;
      const username = this.user.username.trim();

      if (username.match(/^[a-zA-Z0-9]{2,20}$/) != null) {
        this.isValidUsername = true;
      } else {
        this.isValidUsername = false;
        this.errors.username = 'Invalid Username. Please enter alpha numeric number between 2 to 20 characters';
      }
    },
    validatePassword() {
      this.errors.password = '';
      this.isValidPassword = false;
      const password = this.user.password.trim();

      if (password.match(/^[a-zA-Z0-9]{2,20}$/) != null) {
        this.isValidPassword = true;
      } else {
        this.isValidPassword = false;
        this.errors.password = 'Invalid Password. Please enter alpha numeric number between 2 to 20 characters';
      }
    },
  },
};
</script>

<style>

</style>
