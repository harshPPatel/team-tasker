import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../views/Home.vue';
import User from '../lib/User';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/About.vue'),
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('../views/Contact.vue'),
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('../views/Login.vue'),
    beforeEnter: (to, from, next) => {
      if (localStorage.token) {
        User.verify()
          .then(() => next('/dashboard'))
          .catch(() => next());
      }
      return next();
    },
  },
  {
    path: '/signup',
    name: 'signup',
    component: () => import('../views/Signup.vue'),
    beforeEnter: (to, from, next) => {
      if (localStorage.token) {
        User.verify()
          .then(() => next('/dashboard'))
          .catch(() => next());
      }
      return next();
    },
  },
  {
    path: '/admin/dashboard',
    name: 'admin-dashboard',
    component: () => import('../views/admin/Dashboard.vue'),
    beforeEnter: (to, from, next) => {
      if (localStorage.token) {
        User.verify()
          .then((data) => {
            if (data.isAdmin) {
              next();
            } else {
              next('/login');
            }
          })
          .catch(() => next('/login'));
      } else {
        localStorage.removeItem('authSuccess');
        localStorage.authError = JSON.stringify({
          errorCode: '401',
          message: 'Please login to access your data',
        });
        next('/login');
      }
      return next();
    },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('../views/Dashboard.vue'),
    beforeEnter: (to, from, next) => {
      if (localStorage.token) {
        User.verify()
          .then((data) => {
            if (data.isAdmin) {
              next('/admin/dashboard');
            } else {
              next();
            }
          })
          .catch(() => {
            localStorage.removeItem('authSuccess');
            localStorage.authError = JSON.stringify({
              errorCode: '401',
              message: 'Please login to access your data',
            });
            next('/login');
          });
      } else {
        localStorage.removeItem('authSuccess');
        localStorage.authError = JSON.stringify({
          errorCode: '401',
          message: 'Please login to access your data',
        });
        next('/login');
      }
      return next();
    },
  },
  {
    path: '/groups/:id',
    name: 'group',
    component: () => import('../views/Group.vue'),
    beforeEnter: (to, from, next) => {
      if (localStorage.token) {
        User.verify()
          .then((data) => {
            if (data.isAdmin) {
              next('/admin/dashboard');
            } else {
              next();
            }
          })
          .catch(() => {
            localStorage.removeItem('authSuccess');
            localStorage.authError = JSON.stringify({
              errorCode: '401',
              message: 'Please login to access your data',
            });
            next('/login');
          });
      } else {
        localStorage.removeItem('authSuccess');
        localStorage.authError = JSON.stringify({
          errorCode: '401',
          message: 'Please login to access your data',
        });
        next('/login');
      }
      return next();
    },
  },
  {
    path: '*',
    name: '404',
    component: () => import('../views/PageNotFound.vue'),
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

export default router;
