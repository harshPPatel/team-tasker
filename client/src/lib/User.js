/* eslint-disable no-console */
import Vue from 'vue';
import config from '../config';

// Funciton to push vue router to error page
const pushToErrorPage = (error, errorCode) => {
  Vue.$router.push({
    name: 'error',
    params: {
      errorCode,
      errorMessage: error.message,
    },
  });
};

// Logging the user and saving token returned from server to the localStorage
const login = async (user) => {
  let promise;
  // const API_URL = `${config.API_URL}/auth/login.php`;
  const API_URL = `${config.API_URL}/auth/login.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    mode: 'cors',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(user),
  })
    .then(res => res.json())
    .then((data) => {
      promise = new Promise((resolve, reject) => {
        if (data.errorCode) {
          console.log('Here');
          reject(data);
        } else {
          localStorage.token = data.token;
          resolve(data);
        }
      });
    })
    .catch((err) => {
      pushToErrorPage(err);
    });

  return promise;
};

// Siigning up the user and saving token returned from server to the localStorage
const signup = async (user) => {
  let promise;
  const API_URL = `${config.API_URL}/auth/signup.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(user),
  })
    .then(res => res.json())
    .then((data) => {
      promise = new Promise((resolve, reject) => {
        if (data.username) {
          resolve(data);
        } else {
          reject(data);
        }
      });
    })
    .catch((err) => {
      pushToErrorPage(err);
    });

  return promise;
};

// Verifying the logged in user's token
const verify = async () => {
  let promise;
  const API_URL = `${config.API_URL}/auth/verify.php`;

  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    mode: 'cors',
    headers: {
      // 'Access-Control-Allow-Origin': '*',
      'Content-Type': 'application/json',
      Authorization: localStorage.token,
    },
    body: JSON.stringify({ token: localStorage.token }),
  })
    .then(res => res.json())
    .then((response) => {
      promise = new Promise((resolve, reject) => {
        if (response.isLoggedIn) {
          resolve(response);
        } else {
          localStorage.removeItem('token');
          reject(response);
        }
      });
    })
    .catch((err) => {
      pushToErrorPage(err);
    });
  return promise;
};

export default {
  login,
  signup,
  verify,
};
