<template src="./Navigation.html"></template>

<script>
import User from '../../lib/User';

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
