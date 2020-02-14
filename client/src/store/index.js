import Vue from 'vue';
import Vuex from 'vuex';

import User from './modules/User';
import Group from './modules/Group';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    User,
    Group,
  },
});
