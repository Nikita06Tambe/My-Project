// src/components/AddUser.js
import React, { useState } from 'react';
import { createUser } from '../api';

const AddUser = ({ onUserAdded }) => {
  const [formData, setFormData] = useState({
    username: '',
    email: '',
    password: '',
    first_name: '',
    last_name: ''
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prevData => ({ ...prevData, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    await createUser(formData);
    onUserAdded(); // Notify parent component to update the user list
  };

  return (
    <form onSubmit={handleSubmit}>
      <h2>Add New User</h2>
      <input type="text" name="username" placeholder="Username" onChange={handleChange} required />
      <input type="email" name="email" placeholder="Email" onChange={handleChange} required />
      <input type="password" name="password" placeholder="Password" onChange={handleChange} required />
      <input type="text" name="first_name" placeholder="First Name" onChange={handleChange} />
      <input type="text" name="last_name" placeholder="Last Name" onChange={handleChange} />
      <button type="submit">Add User</button>
    </form>
  );
};

export default AddUser;
