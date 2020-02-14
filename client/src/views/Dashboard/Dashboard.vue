<template>
  <v-container>
    <v-row justify="space-between" align="center">
      <v-col cols="6">
        <h2>Groups</h2>
      </v-col>
      <v-col cols="6" class="text-right">
        <add-group @success="showSuccessMessage"></add-group>
      </v-col>
    </v-row>
    <v-divider class="mt-2 mb-5" />
    <group-list></group-list>
    <v-snackbar v-model="snackbar.isOpen">
      {{ snackbar.text }}
      <v-btn color="blue" text
        @click="snackbar.isOpen = false">
        Close
      </v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
import AddGroup from '@/components/AddGroup/AddGroup.vue';
import GroupList from '@/components/GroupList/GroupList.vue';
import TOKEN_VERIFY from '../../graphql/TOKEN_VERIFY';

export default {
  name: 'dashboard',
  components: { AddGroup, GroupList },
  data: () => ({
    snackbar: {
      isOpen: false,
      text: '',
    },
  }),
  mounted() {
    this.$apollo.mutate({
      mutation: TOKEN_VERIFY,
    })
      .then(({ data }) => {
        this.$store.commit('User/updateUsername', data.verify.username);
        this.$store.commit('User/updateIsLoggedIn', true);
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
  methods: {
    showSuccessMessage(text) {
      this.snackbar.text = text;
      this.snackbar.isOpen = true;
    },
  },
};
</script>
