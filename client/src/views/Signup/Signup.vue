<template src="./Signup.html"></template>

<script>
import User from '../../lib/User';
import ErrorComponent from '../../components/ErrorComponent.vue';

export default {
  name: 'login',
  components: {
    ErrorComponent,
  },
  data: () => ({
    user: {
      username: '',
      password: '',
      confirmPassword: '',
    },
    isValidUsername: false,
    isValidPassword: false,
    isValidConfirmPassword: false,
    isLoading: false,
    errors: {
      username: '',
      password: '',
      confirmPassword: '',
      server: null,
    },
  }),
  methods: {
    submitForm() {
      this.isLoading = true;
      User.signup(this.user)
        .then(() => {
          localStorage.removeItem('authError');
          localStorage.authSuccess = 'You are signed up successfully!';
          this.isLoading = false;
          this.$router.push({ name: 'login' });
        })
        .catch((err) => {
          this.errors.server = err;
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
    validateConfirmPassword() {
      this.errors.confirmPassword = '';
      this.isValidConfirmPassword = false;
      const confirmPassword = this.user.confirmPassword.trim();

      if (confirmPassword === this.user.password.trim()) {
        this.isValidConfirmPassword = true;
      } else {
        this.isValidConfirmPassword = false;
        this.errors.confirmPassword = 'Confirm Password does not match!';
      }
    },
  },
};
</script>

<style>

</style>
