let localStorage;
// If we're testing, use a local storage polyfill
if (global.process && process.env.NODE_ENV === 'test') {
  localStorage = require('localStorage'); // eslint-disable-line global-require
} else {
  // If not, use the browser one
  ({ localStorage } = global.window);
}

const server = {
  /**
   * Pretends to log a user in
   *
   * @param  {string} username The username of the user
   * @param  {string} password The password of the user
   */
  login(username, password) { // eslint-disable-line no-unused-vars
    return new Promise(resolve => {
      resolve({
        authenticated: true,
        // Fake a random token
        token: Math.random()
          .toString(36)
          .substring(7),
      });
    });
  },
  /**
   * Pretends to log a user out and resolves
   */
  logout() {
    return new Promise(resolve => {
      localStorage.removeItem('token');
      resolve(true);
    });
  },
};

export default server;
