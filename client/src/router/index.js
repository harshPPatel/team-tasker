import Vue from 'vue';
import VueRouter from 'vue-router';

import store from '../store';
import Home from '../views/Home.vue';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/about',
    name: 'About',
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue'),
  },
  {
    path: '/signup',
    name: 'Signup',
    component: () => import(/* webpackChunkName: "signup" */ '../views/Signup/Signup.vue'),
    beforeEnter: async (to, from, next) => {
      if (localStorage.token || store.state.User.isLoggedIn) {
        next('/dashboard');
      } else {
        next();
      }
    },
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import(/* webpackChunkName: "login" */ '../views/Login/Login.vue'),
    beforeEnter: async (to, from, next) => {
      if (localStorage.token || store.state.User.isLoggedIn) {
        next('/dashboard');
      } else {
        next();
      }
    },
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import(/* webpackChunkName: "dashboard" */ '../views/Dashboard/Dashboard.vue'),
    beforeEnter: async (to, from, next) => {
      if (localStorage.token || store.state.User.isLoggedIn) {
        next();
      } else {
        next({
          name: 'Login',
          params: {
            errorMessage: 'Please login to get access',
          },
        });
      }
    },
  },
  {
    path: '/group/:id',
    name: 'Group',
    component: () => import(/* webpackChunkName: "dashboard" */ '../views/Group/Group.vue'),
    beforeEnter: async (to, from, next) => {
      if (localStorage.token || store.state.User.isLoggedIn) {
        next();
      } else {
        next({
          name: 'Login',
          params: {
            errorMessage: 'Please login to get access',
          },
        });
      }
    },
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

export default router;
