<template>
  <div class="container">
    <div class="mt-5 mb-5 text-center">
      <h1 class="display-3">Login</h1>
      <p class="lead">Log in to Team Tasker and get access to your tasks!</p>
    </div>
    <hr class="mb-5">
    <form @submit.prevent="submitForm" class="col-6 mr-auto ml-auto">
      <error-component v-if="authError" :error="authError" field="authError"></error-component>
      <success-component v-if="authSuccess" :message="authSuccess"
        field="authSuccess"></success-component>
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
      <button type="submit" class="btn btn-primary btn-block mt-4"
        :disabled="(!(isValidUsername && isValidPassword)) || isLoading">
        Submit
      </button>
    </form>
  </div>
</template>

<script>
import User from '../lib/User';
import ErrorComponent from '../components/ErrorComponent.vue';
import SuccessComponent from '../components/SuccessComponent.vue';

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
  },
};
</script>

<style>

</style>
