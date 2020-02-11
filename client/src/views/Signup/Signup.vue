<template src="./Signup.html"></template>

<script>
import SIGNUP_MUTATION from '../../graphql/SIGNUP';

export default {
  name: 'signup',
  data: () => ({
    isValid: false,
    isLoading: false,
    error: null,
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
    confirmPassword: '',
    showConfirmPassword: false,
  }),
  methods: {
    submitForm() {
      this.error = null;
      this.isLoading = true;
      const payload = {
        username: this.username.toString(),
        password: this.password.toString(),
        confirmPassword: this.confirmPassword.toString(),
      };
      this.$apollo.mutate({
        mutation: SIGNUP_MUTATION,
        variables: {
          input: payload,
        },
      })
        .then(({ data }) => {
          this.$router.push({
            name: 'Login',
            params: {
              successMessage: 'Your account has been created successfully. Please Login to get access.',
              username: data.signup.username,
            },
          });
        })
        .catch((err) => {
          if (err.message.includes('E11000')) {
            this.error = 'Username is already in use. Please use different username';
          } else {
            this.error = err.message.replace('GraphQL error: ', '');
          }
        });
      this.isLoading = false;
    },
  },
};
</script>
