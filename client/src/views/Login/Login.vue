<template src="./Login.html"></template>

<script>
import LOGIN_MUTATION from '../../graphql/LOGIN';

export default {
  name: 'login',
  data: () => ({
    isValid: false,
    isLoading: false,
    error: null,
    successMessage: null,
    username: '',
    usernameRules: [
      (v) => !!v || 'Username is required',
      (v) => v.length <= 15 || 'Username must be less than or equal to 10 characters',
      (v) => v.length >= 3 || 'Username must be greater than 2 characters',
      (v) => /(^[a-zA-Z0-9_]+$)/.test(v) || 'Username should only contain a-z, A-Z, 0-9 and _.',
    ],
    password: '',
    showPassword: false,
    passwordRules: [
      (v) => !!v || 'Password is required',
      (v) => v.length <= 30 || 'Only 30 characters are allowed for password',
      (v) => v.length >= 6 || 'Atleast 6 characters are required',
      (v) => /(^[a-zA-Z0-9_@]+$)/.test(v) || 'Password should only contain a-z, A-Z, 0-9, _ and @.',
    ],
  }),
  mounted() {
    if (this.$route.params.successMessage) {
      this.successMessage = this.$route.params.successMessage;
      this.username = this.$route.params.username;
    }
    if (this.$route.params.errorMessage) {
      this.error = this.$route.params.errorMessage;
      if (this.$route.params.username) {
        this.username = this.$route.params.username;
      }
    }
  },
  methods: {
    submitForm() {
      this.error = null;
      this.successMessage = null;
      this.isLoading = true;
      const payload = {
        username: this.username.toString(),
        password: this.password.toString(),
      };
      this.$apollo.mutate({
        mutation: LOGIN_MUTATION,
        variables: {
          input: payload,
        },
      })
        .then(({ data }) => {
          localStorage.token = data.login.token;
          this.$store.commit('User/loginUser', data.login.user);
          this.$router.push({ path: '/dashboard' });
        })
        .catch((err) => {
          this.error = err.message.replace('GraphQL error: ', '');
        });
      this.isLoading = false;
    },
  },
};
</script>
