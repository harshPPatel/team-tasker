import Vue from 'vue';
import Vuex from 'vuex';

import User from './modules/User';
import Group from './modules/Group';
import Task from './modules/Task';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    User,
    Group,
    Task,
  },
});
