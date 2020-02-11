<template>
  <v-container>
    <v-row justify="space-between">
      <v-col cols="6">Groups</v-col>
      <v-col cols="6" class="text-right">
        <add-group></add-group>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AddGroup from '@/components/AddGroup/AddGroup.vue';
import TOKEN_VERIFY from '../../graphql/TOKEN_VERIFY';

export default {
  name: 'dashboard',
  components: { AddGroup },
  mounted() {
    this.$apollo.mutate({
      mutation: TOKEN_VERIFY,
    })
      .catch(() => {
        localStorage.removeItem('token');
        localStorage.removeItem('username');
        this.$store.dispatch('User/logoutUser');
        this.$router.push({
          name: 'Login',
          params: { errorMessage: 'Please login to get access' },
        });
      });
  },
};
</script>
