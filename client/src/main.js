import Vue from 'vue';
import wysiwyg from 'vue-wysiwyg';
import { Datetime } from 'vue-datetime';
import App from './App.vue';
import router from './router';

Vue.config.productionTip = false;
Vue.use(wysiwyg, {
  hideModules: {
    image: true,
    justifyLeft: true,
    justifyCenter: true,
    justifyRight: true,
    removeFormat: true,
    code: true,
  },
  maxHeight: '200px',
  forcePlainTextOnPaste: true,
});

Vue.component('datetime', Datetime);

new Vue({
  router,
  render: h => h(App),
}).$mount('#app');
