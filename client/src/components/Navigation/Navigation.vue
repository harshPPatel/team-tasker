<template src="./Navigation.html"></template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'navigation',
  data: () => ({
    drawer: null,
  }),
  computed: mapState(['User']),
};
</script>
