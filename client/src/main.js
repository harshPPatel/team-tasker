import Vue from 'vue';
import Vue2Editor from 'vue2-editor';

import App from './App.vue';
import router from './router';
import store from './store';
import vuetify from './plugins/vuetify';
import { createProvider } from './vue-apollo';

Vue.config.productionTip = false;

Vue.use(Vue2Editor);

new Vue({
  router,
  store,
  vuetify,
  apolloProvider: createProvider(),
  render: (h) => h(App),
}).$mount('#app');
