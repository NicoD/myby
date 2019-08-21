import request from './request';

let localStorage;

if (global.process && process.env.NODE_ENV === 'test') {
  localStorage = require('localStorage'); // eslint-disable-line global-require
} else {
  // If not, use the browser one
  ({ localStorage } = global.window);
}

const auth = {
  /**
   * Logs a user in, returning a promise with `true` when done
   * @param  {string} username The username of the user
   * @param  {string} password The password of the user
   */
  login(username, password) {
    if (auth.loggedIn()) return Promise.resolve(true);
    // Post a fake request
    return request.post('/login', { username, password }).then(response => {
      localStorage.token = response.token;
      return Promise.resolve(true);
    });
  },
  /**

   * Logs the current user out
   */
  logout() {
    return request.post('/logout');
  },

  /**
   * Checks if a user is logged in
   */
  loggedIn() {
    return !!localStorage.token;
  },
};

export default auth;
