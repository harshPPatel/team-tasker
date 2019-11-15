<template>
  <div class="container">
    <div class="mt-5 mb-5 text-center">
      <h1 class="display-3">Sign Up</h1>
      <p class="lead">Sign Up to Team Tasker and start creatings your tasks!</p>
    </div>
    <hr class="mb-5">
    <form @submit.prevent="submitForm" class="col-6 mr-auto ml-auto">
      <error-component v-if="errors.server" :error="errors.server"></error-component>
      <div class="form-group">
        <label class="col-form-label" for="username">Username</label>
        <!-- add required -->
        <input type="text" class="form-control"
          placeholder="Username" id="username" v-model="user.username"
          :class="{ 'is-invalid': (errors.username && !isValidUsername) }"
          @input="validateUsername">
        <div class="invalid-feedback" v-if="errors.username">
          {{ errors.username }}
        </div>
      </div>
      <div class="form-group">
        <label class="col-form-label" for="password">Password</label>
        <!-- add required -->
        <input type="password" class="form-control"
          placeholder="Password" id="password" v-model="user.password"
          :class="{ 'is-invalid': (errors.password && !isValidPassword) }"
          @input="validatePassword">
        <div class="invalid-feedback" v-if="errors.password">
          {{ errors.password }}
        </div>
      </div>
      <div class="form-group">
        <label class="col-form-label" for="confirmPassword">Confirm Password</label>
        <!-- add required -->
        <input type="password" class="form-control"
          placeholder="Confirm Password" id="confirmPassword" v-model="user.confirmPassword"
          :class="{ 'is-invalid': (errors.confirmPassword && !isValidConfirmPassword) }"
          @input="validateConfirmPassword">
        <div class="invalid-feedback" v-if="errors.confirmPassword">
          {{ errors.confirmPassword }}
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-block mt-4"
        :disabled="(!(isValidUsername && isValidPassword && isValidConfirmPassword))
          || isLoading">
        Submit
      </button>
    </form>
  </div>
</template>

<script>
import User from '../lib/User';
import ErrorComponent from '../components/ErrorComponent.vue';

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
