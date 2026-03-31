import React, { useState } from 'react';
import Input from '../../../components/ui/Input';

const RegisterForm = () => {
  const [selectedRole, setSelectedRole] = useState('student');

  return (
    <form className="auth-form" onSubmit={(e) => e.preventDefault()}>
      <div className="grid-row">
        <Input label="Nom" type="text" placeholder="Nom" />
        <Input label="Prénom" type="text" placeholder="Prénom" />
      </div>

      <Input label="Email Address" type="email" placeholder="name@example.com" />

      <div className="form-group">
        <label>I am a...</label>
        <div className="role-container">
          <div 
            className={`role-box ${selectedRole === 'teacher' ? 'active' : ''}`}
            onClick={() => setSelectedRole('teacher')}
          >
            Teacher
          </div>
          <div 
            className={`role-box ${selectedRole === 'student' ? 'active' : ''}`}
            onClick={() => setSelectedRole('student')}
          >
            Student
          </div>
        </div>
      </div>

      <div className="grid-row">
        <Input label="Password" type="password" placeholder="••••••••" />
        <Input label="Confirm Password" type="password" placeholder="••••••••" />
      </div>

      <button type="submit" className="auth-btn">Create Account</button>
    </form>
  );
};

export default RegisterForm;