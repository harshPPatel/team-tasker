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


const getAll = async () => {
  let promise;
  // const API_URL = `${config.API_URL}/auth/login.php`;
  const API_URL = `${config.API_URL}/groups/index.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    mode: 'cors',
    headers: {
      'Content-Type': 'application/json',
      Authorization: localStorage.token,
    },
  })
    .then(res => res.json())
    .then((data) => {
      promise = new Promise((resolve, reject) => {
        if (data.errorCode) {
          reject(data);
        } else {
          resolve(data);
        }
      });
    })
    .catch((err) => {
      pushToErrorPage(err);
    });

  return promise;
};

const getSingle = async (id) => {
  let promise;
  // const API_URL = `${config.API_URL}/auth/login.php`;
  const API_URL = `${config.API_URL}/groups/index.php?id=${id}`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    mode: 'cors',
    headers: {
      'Content-Type': 'application/json',
      Authorization: localStorage.token,
    },
  })
    .then(res => res.json())
    .then((data) => {
      promise = new Promise((resolve, reject) => {
        if (data.errorCode) {
          reject(data);
        } else {
          resolve(data);
        }
      });
    })
    .catch((err) => {
      pushToErrorPage(err);
    });

  return promise;
};

const create = async (formData) => {
  let promise;
  const API_URL = `${config.API_URL}/groups/create.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    headers: {
      // 'Content-Type': 'multipart/form-data',
      Authorization: localStorage.token,
    },
    // cache: false,
    body: formData,
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

const update = async (formData) => {
  let promise;
  const API_URL = `${config.API_URL}/groups/update.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    headers: {
      // 'Content-Type': 'multipart/form-data',
      Authorization: localStorage.token,
    },
    // cache: false,
    body: formData,
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

const deleteGroup = async (formData) => {
  let promise;
  const API_URL = `${config.API_URL}/groups/delete.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    headers: {
      // 'Content-Type': 'multipart/form-data',
      Authorization: localStorage.token,
    },
    // cache: false,
    body: formData,
  })
    .then(res => res.json())
    .then((data) => {
      promise = new Promise((resolve, reject) => {
        if (data.errorCode) {
          reject(data);
        } else {
          resolve(data);
        }
      });
    })
    .catch((err) => {
      pushToErrorPage(err);
    });

  return promise;
};

export default {
  getAll,
  getSingle,
  create,
  update,
  deleteGroup,
};
