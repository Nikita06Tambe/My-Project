// src/App.js
import React, { useState } from 'react';
import UserList from './components/UserList';
import AddUser from './components/AddUser';
import EditUser from './components/EditUser';

const App = () => {
  const [selectedUser, setSelectedUser] = useState(null);
  const [isAddingUser, setIsAddingUser] = useState(false);

  const handleAddUser = () => setIsAddingUser(true);
  const handleUserAdded = () => setIsAddingUser(false);
  const handleEditUser = (user) => setSelectedUser(user);
  const handleUserUpdated = () => setSelectedUser(null);

  return (
    <div>
      <h1>User Management</h1>
      <button onClick={handleAddUser}>Add New User</button>

      {isAddingUser && <AddUser onUserAdded={handleUserAdded} />}
      {selectedUser ? (
        <EditUser
          userId={selectedUser.user_id}
          onUserUpdated={handleUserUpdated}
          onClose={() => setSelectedUser(null)}
        />
      ) : (
        <UserList onEdit={handleEditUser} />
      )}
    </div>
  );
};

export default App;
