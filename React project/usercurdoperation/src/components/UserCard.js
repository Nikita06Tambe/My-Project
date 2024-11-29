// src/components/UserCard.js
import React from 'react';

const UserCard = ({ user, onDelete, onEdit }) => {
  return (
    <div>
      <h3>{user.first_name} {user.last_name}</h3>
      <p>Email: {user.email}</p>
      <button onClick={() => onEdit(user)}>Edit</button>
      <button onClick={() => onDelete(user.user_id)}>Delete</button>
    </div>
  );
};

export default UserCard;
