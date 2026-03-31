import React from 'react';

const RoleCard = ({ label, value, selectedRole, onChange }) => {
  const isSelected = selectedRole === value;

  return (
    <label className={`role-card ${isSelected ? 'selected' : ''}`}>
      <input
        type="radio"
        name="role"
        value={value}
        checked={isSelected}
        onChange={() => onChange(value)}
        style={{ display: 'none' }}
      />
      <div className="card-box">
        {label}
      </div>
    </label>
  );
};

export default RoleCard;