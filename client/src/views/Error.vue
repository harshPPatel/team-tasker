<template>
  <div class="container">
    <div class="text-center row">
      <div class="col-12">
        <h1 class="disaply-4">{{ $route.params.errorCode }} Error</h1>
        <h2>Sorry for inconvenience!</h2>
        <hr>
        <p class="lead">
          Sorry! There is some error to Book<span class="u-primary u-bold">Mark</span> server.<br>
          We will fix this issue soon!<br>
        </p>
        <p class="text-primary">
          <b>Error</b> : {{ $route.params.errorMessage }}
        </p>
      </div>
      <div class="col-12">
        <a href="#" class="btn btn-primary mr-3" @click="goBack">No, Go Back!</a>
        <router-link class="btn btn-outline-primary" :to="{ name: 'home' }">
          Go to Home
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'error',
  methods: {
    goBack() {
      this.$router.back();
    },
  },
};
</script>
