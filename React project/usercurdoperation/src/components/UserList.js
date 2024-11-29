// src/components/UserList.js
import React, { useState, useEffect } from 'react';
import { getUsers, deleteUser } from '../api';
import UserCard from './UserCard';

const UserList = ({ onEdit }) => {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    const fetchUsers = async () => {
      const data = await getUsers();
      setUsers(data);
    };

    fetchUsers();
  }, []);

  const handleDelete = async (id) => {
    await deleteUser(id);
    const updatedUsers = users.filter(user => user.user_id !== id);
    setUsers(updatedUsers);
  };

  return (
    <div>
      <h2>Users List</h2>
      {users.map((user) => (
        <UserCard key={user.user_id} user={user} onDelete={handleDelete} onEdit={onEdit} />
      ))}
    </div>
  );
};

export default UserList;
