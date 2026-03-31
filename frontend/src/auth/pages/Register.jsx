import React, { useState } from 'react';
import './Register.css';
import RoleCard from '../components/RoleCard';

const Register = () => {
  const [formData, setFormData] = useState({
    nom: '',
    prenom: '',
    email: '',
    role: '',
    password: '',
    password_confirmation: ''
  });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleRoleChange = (roleValue) => {
    setFormData({ ...formData, role: roleValue });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log("Data submitted:", formData);
    // Hna fin ghadir l-appel l-API dyal Laravel
  };

  return (
    <div className="register-container">
      <div className="register-card">
        <div className="header">
          <h2>Create Account</h2>
          <p>Join our platform today</p>
        </div>

        <form onSubmit={handleSubmit}>
          <div className="grid-row">
            <div className="form-group">
              <label>Nom</label>
              <input type="text" name="nom" placeholder="Nom" onChange={handleChange} required />
            </div>
            <div className="form-group">
              <label>Prénom</label>
              <input type="text" name="prenom" placeholder="Prénom" onChange={handleChange} required />
            </div>
          </div>

          <div className="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="name@example.com" onChange={handleChange} required />
          </div>

          <div className="form-group">
            <label>I am a...</label>
            <div className="role-container">
              <RoleCard 
                label="Teacher" 
                value="teacher" 
                selectedRole={formData.role} 
                onChange={handleRoleChange} 
              />
              <RoleCard 
                label="Student" 
                value="student" 
                selectedRole={formData.role} 
                onChange={handleRoleChange} 
              />
            </div>
          </div>

          <div className="grid-row">
            <div className="form-group">
              <label>Password</label>
              <input type="password" name="password" placeholder="••••••••" onChange={handleChange} required />
            </div>
            <div className="form-group">
              <label>Confirm Password</label>
              <input type="password" name="password_confirmation" placeholder="••••••••" onChange={handleChange} required />
            </div>
          </div>

          <button type="submit" className="submit-btn">Sign Up</button>
        </form>
      </div>
    </div>
  );
};

export default Register;