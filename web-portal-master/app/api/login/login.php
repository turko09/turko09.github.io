<?php
// Start the session for account
session_start();

//
error_reporting(0);

//  Intitialize value from login form
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'];
$password = $input['password'];


?>

<?php
// var con -> establish a connection to database assignment1db
$con =  mysqli_connect('localhost', 'root' ,'', 'cmsc_team_alpha');
	// test if you can connect to database | if not die
	if (!$con) {
			die("Connection failed: " . mysqli_connect_error());
	}
	// Prepare statement to test if input $username is available in the database
	$sql = "SELECT loginattempts FROM 'users' WHERE username = '$username' ";
	
	// result -> is the result of the query of $sql
	$result = mysqli_query($con, $sql);
	
	// test if the $result is not null | Must return one row from database
	if (mysqli_num_rows($result) == 1) {
		while($row = mysqli_fetch_assoc($result)) {
			// Test if the user has less than or 3 attempts
            if($row['loginattempts'] < 3) {
                $sql = "SELECT * FROM 'users' WHERE username = '$username'";
				// result -> is the result of the query
				$result = $con->query($sql);
				// test if the result is not null | Must return one value
				if (mysqli_num_rows($result) == 1) {
					// print a JSON "true" | will be read by login.js
					//print_r(json_encode(array(1,"You have login successfully")));
					$row = $result->fetch_assoc();
						// set the session for current user | set session "CURRENT_user" as 'id' from table users
						if(password_verify($password, $row['password'])){
                            $sql = "UPDATE 'users' SET loginattempts = 1 WHERE username='" . $username . "'";
                            // result -> is the result of the query of $sql
                            $result = $con->query($sql);  
                            print_r(json_encode(array(1,"You have login successfully")));
                        }
                        else {
                            $row['loginattempts'] = $row['loginattempts'] + 1;
                            $sql = "UPDATE 'users' SET loginattempts = " . $row['loginattempts'] . " WHERE username='" . $username . "'";
                            // result -> is the result of the query of $sql
                            $result = $con->query($sql);                            
                            print_r(json_encode(array(4,"Username or password invalid.")));
                        }
                }
                else {
                    // print a JSON "false" | will be read by login.js
                    print_r(json_encode(array(4,"Username or password invalid.")));
                }
            }
            else {
				print_r(json_encode(array(3,"You have login for 3 times.")));	
            }
        }
	}
	// Username doesn't exist in the table users
	else {
		// print a JSON "false" | will be read by login.js
		print_r(json_encode(array(2,"Username or password invalid.")));
	}
	
	$con->close();
?>