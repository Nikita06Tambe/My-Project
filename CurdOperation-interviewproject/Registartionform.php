<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with Add, Update, Delete Functionality</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>
<body>

    <h2>User Information Form</h2>
    <form id="userForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <button type="button" id="submitForm1" class="adduser">Add User</button>
		
		<input type="hidden" id="hdnuserid" value=""/>
    </form>

    <hr>

    <h3>Update or Delete User</h3>
    <div id="userList"></div>
    
	
    <script>
        $(document).ready(function() {
            // Load existing users
            loadUsers();
			$(document).on('click', '.upadteuser', function() {
				 alert("update");
				
				var name=$("#name").val();
				var email=$("#email").val();
				var user_id=$("#hdnuserid").val();
				//var password = $('#password').val();
                var dob = $('#dob').val();
				
				$.ajax({
					url:'user_action.php',
					method: 'POST',
					data: {action: 'update',name: name,email: email,dob: dob,user_id:user_id},
					success: function(response) {
                        alert(response);
						$("#submitForm1").removeClass("upadteuser");
						$("#submitForm1").addClass("adduser");
						$("#submitForm1").text("Add User")
						
                        loadUsers();
                        $('#userForm')[0].reset();
                    }
				});
			 });
			 
			 
			 $(document).on('click', '.adduser', function() {
				//alert("Q");
				
				var name=$("#name").val();
				var email=$("#email").val();
				var password = $('#password').val();
                var dob = $('#dob').val();
				
				$.ajax({
					url:'user_action.php',
					method: 'POST',
					data: {action: 'add',name: name,email: email,password: password,dob: dob},
					success: function(response) {
                        alert('User Added!');
                        loadUsers();
                        $('#userForm')[0].reset();
                    }
				});
				
			});
			
			 
			 

            


            // Add user
            $('#submitForm').click(function() {
                let name = $('#name').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let dob = $('#dob').val();
//alert("1");
                $.ajax({
					
                    url: 'user_action.php',
                    method: 'POST',
                    data: {
                        action: 'add',
                        name: name,
                        email: email,
                        password: password,
                        dob: dob
                    },
                    success: function(response) {
                        alert('User Added!');
                        loadUsers();
                        $('#userForm')[0].reset();
                    }
                });
            });

            // Update or Delete user
           
			
			 $(document).on('click', '.delete', function() {
               // let action = $(this).hasClass('update') ? 'update' : 'delete';
                let userId = $(this).data('id');

            
                   if (confirm('Are you sure you want to delete this user?')) {
                        $.ajax({
                            url: 'user_action.php',
                            method: 'POST',
                            data: { action: 'delete', user_id: userId },
                            success: function(response) {
                                alert('User Deleted!');
                                loadUsers();
                            }
                        });
                    }
                
            });
			

            // Function to load users
            
        });
		
		function getdata(id){
			//alert("123"+id);
			 $.ajax({
                    url: 'user_action.php',
                    method: 'GET',
					dataType: 'json',
                    data: { action: 'getdata',user_id:id },
                    success: function(data1) {
						console.log("res"+data1);
                        //$('#userList').html(response);
						 if (data1.length > 0) {
                            // Update fields with the first user's data
                            $('#name').val(data1[0].name);
                            $('#email').val(data1[0].email); 
							 //$('#password').addClass("hidden");
							//$('#password').hidden();
                            $('#dob').val(data1[0].dob);
							$("#submitForm1").text("Upadte User")
							$("#submitForm1").removeClass("adduser");
							$("#submitForm1").addClass("upadteuser");
							$("#hdnuserid").val(data1[0].id);
							
                        } else {
                            alert('No data found');
                        }
                    }
                });
		}
		function loadUsers() {
                $.ajax({
                    url: 'user_action.php',
                    method: 'POST',
                    data: { action: 'list' },
                    success: function(response) {
                        $('#userList').html(response);
                    }
                });
            }
		//function adduser(){
			
			 
			//$('.upadteuser').click(function() {});
    </script>

</body>
</html>