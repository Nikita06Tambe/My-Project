// src/components/EditUser.js
import React, { useState, useEffect } from 'react';
import { getUser, updateUser } from '../api';

const EditUser = ({ userId, onUserUpdated, onClose }) => {
  const [formData, setFormData] = useState({
    username: '',
    email: '',
    first_name: '',
    last_name: ''
  });

  useEffect(() => {
    const fetchUser = async () => {
      const user = await getUser(userId);
      setFormData(user);
    };

    fetchUser();
  }, [userId]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prevData => ({ ...prevData, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    await updateUser(userId, formData);
    onUserUpdated(); // Notify parent component to refresh the user list
    onClose(); // Close the edit form
  };

  return (
    <form onSubmit={handleSubmit}>
      <h2>Edit User</h2>
      <input type="text" name="username" value={formData.username} onChange={handleChange} required />
      <input type="email" name="email" value={formData.email} onChange={handleChange} required />
      <input type="text" name="first_name" value={formData.first_name} onChange={handleChange} />
      <input type="text" name="last_name" value={formData.last_name} onChange={handleChange} />
      <button type="submit">Update User</button>
      <button type="button" onClick={onClose}>Cancel</button>
    </form>
  );
};

export default EditUser;
