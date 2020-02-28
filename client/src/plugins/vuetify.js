import 'material-design-icons-iconfont/dist/material-design-icons.css';

import Vue from 'vue';

import Vuetify from 'vuetify/lib';
import store from '../store/index';

Vue.use(Vuetify);

export default new Vuetify({
  theme: { dark: store.state.User.theme },
  icons: {
    iconfont: 'md',
  },
});
