<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <router-link to="/" class="navbar-brand">Team Tasker</router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarColor01"
        aria-controls="navbarColor01"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item" :class="{'active' : (currentRouteName === 'home')}">
            <router-link to="/" class="nav-link">Home</router-link>
          </li>
          <li class="nav-item" :class="{'active' : (currentRouteName === 'about')}">
            <router-link to="/about" class="nav-link">About</router-link>
          </li>
          <li class="nav-item" :class="{'active' : (currentRouteName === 'contact')}">
            <router-link to="/contact" class="nav-link">Contact</router-link>
          </li>
          <li class="nav-item"
            v-if="!isLoggedIn && showLogin">
            <router-link to="/login" class="nav-link">Login</router-link>
          </li>
          <li class="nav-item" v-if="!isLoggedIn && showSignUp">
            <router-link to="signup" class="nav-link">Sign Up</router-link>
          </li>
          <li class="nav-item dropdown" v-if="isLoggedIn">
            <a class="nav-link dropdown-toggle" href="#"
              id="userDropdown" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              {{ username }}
            </a>
            <div class="dropdown-menu" aria-labelledby="userDropdown">
              <router-link to="/dashboard" class="dropdown-item">Dashboard</router-link>
              <div class="dropdown-divider"></div>
              <a href="/logout" class="dropdown-item" @click.prevent="logoutUser">Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import User from '../lib/User';

export default {
  name: 'Navigation',
  data: () => ({
    isLoggedIn: false,
    showLogin: true,
    showSignUp: true,
  }),
  methods: {
    async verifyToken() {
      if (localStorage.token) {
        // verifying the user's existing token
        User.verify()
          .then(() => {
            this.isLoggedIn = true;
            this.showLogin = false;
            this.showSignUp = false;
          })
          .catch(() => {
            this.isLoggedIn = false;
            this.showLogin = true;
            this.showSignUp = true;
          });
      } else {
        this.isLoggedIn = false;
        this.showLogin = true;
        this.showSignUp = true;
      }
    },
    logoutUser() {
      localStorage.removeItem('username');
      localStorage.removeItem('token');
      localStorage.removeItem('authSuccess');
      localStorage.removeItem('authError');
      this.isLoggedIn = false;
      this.showLogin = true;
      this.showSignUp = true;
      if ((this.currentRouteName !== 'about') || (this.currentRouteName !== 'home')) {
        this.$router.push({ name: 'home' });
      }
    },
  },
  computed: {
    currentRouteName() {
      return this.$route.name;
    },
    username() {
      return localStorage.username;
    },
  },
  mounted() {
    this.verifyToken();
  },
  watch: {
    /* eslint-disable no-unused-vars */
    $route(to, from) {
      if (to.name === 'signup') {
        this.showSignUp = false;
        this.showLogin = true;
      } else if (to.name === 'login') {
        this.showLogin = false;
        this.showSignUp = true;
      } else if (to.name === 'dashboard'
        || to.name === 'admin-dashboard'
        || to.name === 'group') {
        this.isLoggedIn = true;
        this.showLogin = false;
        this.showSignUp = false;
      } else {
        this.verifyToken();
      }
    },
  },
};
</script>

<style>

</style>
