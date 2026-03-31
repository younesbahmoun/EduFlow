import React from 'react';
import Input from '../../../../components/ui/Input';

const LoginForm = () => {
  return (
    <form className="auth-form">
      <Input label="Email" type="email" placeholder="Enter your email" required />
      <Input label="Password" type="password" placeholder="••••••••" required />
      <button type="submit" className="auth-btn">Login</button>
    </form>
  );
};

export default LoginForm;