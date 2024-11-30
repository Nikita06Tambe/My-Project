<?php
header('Content-Type: application/json');
include 'db.php';
header("Access-Control-Allow-Origin: *");  // Allow all origins or specify your frontend origin
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  // Allow methods
header("Access-Control-Allow-Headers: Content-Type");  // Allow content type headers

// GET all users
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);
}

// POST - Add a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $name = $data->name;
    $email = $data->email;
    $phone = $data->phone;

    $sql = "INSERT INTO users (name, email, phone) VALUES ('$name', '$email', '$phone')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'User added successfully']);
    } else {
        echo json_encode(['error' => 'Error adding user']);
    }
}

// PUT - Update an existing user
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id;
    $name = $data->name;
    $email = $data->email;
    $phone = $data->phone;
   

    $sql = "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'User updated successfully']);
    } else {
        echo json_encode(['error' => 'Error updating user']);
    }
}

// DELETE - Delete a user
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
    $data = json_decode(file_get_contents("php://input"));
    //echo "data".$data;
    
    $id = $data->id;
    //echo "Dekete";

    $sql = "DELETE FROM users WHERE id=$id";
    //$sql = "DELETE FROM users";
   // echo "123",$sql;
    if ($conn->query($sql) === TRUE) {
       
        echo json_encode(['message' => 'User deleted successfully']);
    } else {
        echo json_encode(['error' => 'Error deleting user']);
    }
}
?>