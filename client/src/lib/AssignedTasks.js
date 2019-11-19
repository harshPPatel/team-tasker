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
  const API_URL = `${config.API_URL}/assignedTasks/index.php`;
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

const getAllUsers = async () => {
  let promise;
  // const API_URL = `${config.API_URL}/auth/login.php`;
  const API_URL = `${config.API_URL}/auth/users.php`;
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

const getAllByGroup = async (groupId) => {
  let promise;
  // const API_URL = `${config.API_URL}/auth/login.php`;
  const API_URL = `${config.API_URL}/tasks/index.php?groupId=${groupId === null}`;
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
  const API_URL = `${config.API_URL}/assignedTasks/create.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: localStorage.token,
    },
    // cache: false,
    body: JSON.stringify(formData),
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

const update = async (formData) => {
  let promise;
  const API_URL = `${config.API_URL}/assignedTasks/update.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    headers: {
      // 'Content-Type': 'multipart/form-data',
      Authorization: localStorage.token,
    },
    // cache: false,
    body: JSON.stringify(formData),
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

const complete = async (formData) => {
  let promise;
  const API_URL = `${config.API_URL}/assignedTasks/updateByUser.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    headers: {
      // 'Content-Type': 'multipart/form-data',
      Authorization: localStorage.token,
    },
    // cache: false,
    body: JSON.stringify(formData),
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

const deleteTask = async (formData) => {
  let promise;
  const API_URL = `${config.API_URL}/assignedTasks/delete.php`;
  // Making call to server
  await fetch(API_URL, {
    method: 'POST',
    headers: {
      // 'Content-Type': 'multipart/form-data',
      Authorization: localStorage.token,
    },
    // cache: false,
    body: JSON.stringify(formData),
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

export default {
  getAll,
  getAllUsers,
  getAllByGroup,
  getSingle,
  create,
  update,
  complete,
  deleteTask,
};
