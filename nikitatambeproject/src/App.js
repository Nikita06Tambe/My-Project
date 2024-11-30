import React, { useState, useEffect } from 'react';
import axios from 'axios';


function App() {
  const [users, setUsers] = useState([]);
  const [user, setUser] = useState({ name: '', email: '', phone: '' });
  const [editing, setEditing] = useState(false);
  const [currentUser, setCurrentUser] = useState(null);

  const fetchUsers = async () => {
    const result = await axios.get('http://localhost/api/users.php');
    setUsers(result.data);
  };

  useEffect(() => {
    fetchUsers();
  }, []);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setUser({ ...user, [name]: value });
  };

  const addUser = async () => {
    await axios.post('http://localhost/api/users.php', user);
    fetchUsers();
    setUser({ name: '', email: '', phone: '' });
  };

  const updateUser = async () => {
    await axios.put('http://localhost/api/users.php', { ...user, id: currentUser.id });
    fetchUsers();
    setUser({ name: '', email: '', phone: '' });
    setEditing(false);
  };

 

  const editUser = (user) => {
    setUser({ name: user.name, email: user.email, phone: user.phone });
    setEditing(true);
    setCurrentUser(user);
  };

  return (
    <div>
      <h1>User Data</h1>
      <div className="mb-6">
          <label htmlFor="name" className="form-label">Name :</label> 
      <input 
        type="text" className='from-control'
        name="name" 
        value={user.name} 
        onChange={handleInputChange} 
        placeholder="Name" required
      />
      </div>
      <div className="mb-6">
      <label htmlFor="name" className="form-label">Email :</label>
      <input 
        type="email" 
        name="email" 
        value={user.email} 
        onChange={handleInputChange} 
        placeholder="Email" required 
      />
      </div>
      <div className="mb-6">
      <label htmlFor="name" className="form-label">Phone :</label>
      <input 
        type="text" 
        name="phone" 
        value={user.phone} 
        onChange={handleInputChange} 
        placeholder="Phone" 
      />
      </div><br></br>
      <div className="mb-6">
      <button onClick={editing ? updateUser : addUser}>
        {editing ? 'Update User' : 'Add User'}
      </button>
      </div>
    
      <div className="container mt-5">
      <h2 className="text-center mb-4">User Data</h2>
      <table className="table table-bordered table-striped">
        <thead className="table-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Edit</th>
            
          </tr>
        </thead>
        <tbody>
          {users.map((user) => (
            <tr key={user.id}>
              <td>{user.id}</td>
              <td>{user.name}</td>
              <td>{user.email}</td>
              <td>{user.phone}</td>
              <td><button onClick={() => editUser(user)}>Edit</button></td>
              
            </tr>
          ))}
        </tbody>
      </table>
    </div>

    </div>
  );
}

export default App;
