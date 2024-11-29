<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'test';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    if ($action == 'add') {
        // Add User
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
        $dob = $_POST['dob'];

        $sql = "INSERT INTO users (name, email, password, dob) VALUES ('$name', '$email', '$password', '$dob')";
        if ($conn->query($sql) === TRUE) {
            echo "User added successfully";
        } else {
            echo "Error: " . $conn->error;
        }

    } elseif ($action == 'update') {
        // Update User
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
		$email=$_POST['email'];
		$dob = $_POST['dob'];

        $sql = "UPDATE users SET name='$name',email='$email',dob='$dob' WHERE id=$user_id";
		//echo $sql;
        if ($conn->query($sql) === TRUE) {
            echo "User updated successfully";
        } else {
            echo "Error: " . $conn->error;
        }

    } elseif ($action == 'delete') {
        // Delete User
        $user_id = $_POST['user_id'];

        $sql = "DELETE FROM users WHERE id=$user_id";
        if ($conn->query($sql) === TRUE) {
            echo "User deleted successfully";
        } else {
            echo "Error: " . $conn->error;
        }

    } elseif ($action == 'list') {
        // List Users
       /* $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div>
                        <strong>{$row['name']}</strong> - {$row['email']} - {$row['dob']}
                        <button class='update' data-id='{$row['id']}'>Update</button>
                        <button class='delete' data-id='{$row['id']}'>Delete</button>
                    </div>";
            }
        } else {
            echo "No users found.";
        }*/
		$sql = "SELECT * FROM users";
        $result = $conn->query($sql);
		$table=" <table id='userTable' table-striped >
        <thead>
            <tr>
				<th>Sr No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Upadte</th>
				<th>Delete</th>
            </tr>
        </thead>
        <tbody>";

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $table.= "<tr>";
				 $table.= "<td>".$row['id']."</td>";
				 $table.= "<td>".$row['name']."</td>";
				 $table.= "<td>".$row['email']."</td>";
				 $table.= "<td>".$row['dob']."</td>";
				 $table.= "<td><button class='update1' data-id='".$row['id']."' onclick=getdata(".$row['id'].")>Update</button></td>";
				 $table.= "<td><button class='delete' data-id='".$row['id']."'>Delete</button></td>";
				 $table.="</tr>";
				
				
            }
        } else {
            $table.= "<tr ><td colspan='4'>No users found.</td><tr>";
        }
		$table.="</tbody></table>";
		echo $table;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	 $action = $_GET['action'];
	if($action == 'getdata'){
		//echo "123",
		 $user_id = $_GET['user_id'];
		$sqldata = "SELECT * FROM users where id=".$user_id;
		//echo "sqldaats".$sqldata;
        $result = $conn->query($sqldata);
		$data = [];
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		}
		echo json_encode($data);
	}
}

$conn->close();
?>