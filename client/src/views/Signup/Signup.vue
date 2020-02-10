<template src="./Signup.html"></template>

<script>
export default {
  name: 'signup',
  data: () => ({
    isValid: false,
    isLoading: false,
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
};
</script>
