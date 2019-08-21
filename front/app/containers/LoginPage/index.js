import React from 'react';
import { compose } from 'redux';
import { connect } from 'react-redux';
import { createStructuredSelector } from 'reselect';
import PropTypes from 'prop-types';
import LoginForm from './LoginForm';
import {
  makeSelectUsername,
  makeSelectPassword,
  makeLoginError,
} from '../App/selectors';
import { loginRequest, changeUsername, changePassword } from '../App/actions';
import saga from '../App/saga';
import injectSaga from '../../utils/injectSaga';
import { DAEMON } from '../../utils/constants';

const withSaga = injectSaga({ key: 'yourcomponent', saga, mode: DAEMON });

export function LoginPage({ dispatch, username, password, loginError }) {
  return (
    <div>
      <LoginForm
        onChangeUsername={event => dispatch(changeUsername(event.target.value))}
        onChangePassword={event => dispatch(changePassword(event.target.value))}
        onSubmit={event => {
          event.preventDefault();
          dispatch(loginRequest({ username, password }));
        }}
        username={username}
        password={password}
        title="Login"
        error={loginError}
      />
    </div>
  );
}

LoginPage.propTypes = {
  dispatch: PropTypes.func.isRequired,
  username: PropTypes.string.isRequired,
  password: PropTypes.string.isRequired,
  loginError: PropTypes.string.isRequired,
};

const mapStateToProps = createStructuredSelector({
  username: makeSelectUsername(),
  password: makeSelectPassword(),
  loginError: makeLoginError(),
});

function mapDispatchToProps(dispatch) {
  return {
    dispatch,
  };
}

export default compose(
  withSaga,
  connect(
    mapStateToProps,
    mapDispatchToProps,
  ),
)(LoginPage);
