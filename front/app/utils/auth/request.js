import server from './server';

const request = {
  /**
   * Pretends to post to a remote server
   * @param  {string}  endpoint The endpoint of the server that should be contacted
   * @param  {?object} data     The data that should be transferred to the server
   */
  post(endpoint, data) {
    switch (endpoint) {
      case '/login':
        return server.login(data.username, data.password);
      case '/logout':
        return server.logout();
      default:
        break;
    }
    return false;
  },
};

export default request;
