import React from 'react';
import styled from 'styled-components';
import PropTypes from 'prop-types';
import LoginButton from './LoginButton';

const Form = styled.form`
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: #fafafa;
`;

const TextField = styled.input`
  display: block;
  border: 1px solid #eee;
  margin: 10px 0;
  background: white;
  padding: 5px;
`;

const Error = styled.h4`
  color: #cc0000;
`;

function LoginForm({
  onChangeUsername,
  onChangePassword,
  onSubmit,
  username,
  password,
  title,
  error,
}) {
  return (
    <Form onSubmit={onSubmit}>
      {title && <h1>{title}</h1>}
      <TextField
        type="text"
        name="username"
        placeholder="username"
        value={username}
        onChange={onChangeUsername}
        required
      />
      <TextField
        type="password"
        name="password"
        placeholder="password"
        value={password}
        onChange={onChangePassword}
        required
      />
      <LoginButton type="submit" value="Submit" onMouseDown={onSubmit} />
      {error && <Error>{error}</Error>}
    </Form>
  );
}

LoginForm.propTypes = {
  onChangeUsername: PropTypes.func.isRequired,
  onChangePassword: PropTypes.func.isRequired,
  onSubmit: PropTypes.func.isRequired,
  username: PropTypes.string.isRequired,
  password: PropTypes.string.isRequired,
  title: PropTypes.string,
  error: PropTypes.string,
};

export default LoginForm;
