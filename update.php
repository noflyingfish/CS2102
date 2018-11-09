<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="display.css"/>
</head>
<body>

<h1>Crowd Funding</h1>
<h2>User Profile</h2>

	<form name="update" action="update.php" method="post">
	<table>
		<tr>
		<td>New Password:
		<td><input type='text' name='new_password'/>
		<tr>
		<td>Retype Password:
		<td><input type='text' name='new_password2'/>
	</table>
		<input type='submit' name='new' />
		<input type="submit" value="go back to profile" name="back_btn" >
	</form>
	

	<?php
		//getting variable from another php
		session_start();
		include('dbconnect.php');

		$email = $_SESSION["user_email"];
		$query = "SELECT * FROM users";
		$result = pg_query($db, $query) or die("Cannot execute query: $query\n");		// Query template
		$row    = pg_fetch_row($result);		// To store the result row
		$count = pg_query($db, "SELECT count(*) FROM users");

		$count_email = pg_num_rows($result);

		if(isset($_POST['back_btn'])){
         header("Location: profile.php");
    }

		if (isset($_POST['new'])) {	// Submit the update SQL command
			$password = $_POST['new_password'];
			$password2 = $_POST['new_password2'];

			//below conditions checks password inputs are valid
			if($password <> $password2) {
				echo "<br>" . 'The two passwords do not match';
				throw new Exception('process_z failed');
			}
			else if(!isset($password) || trim($password) == '') {
				echo "<br>" . 'Empty fields in input. Password not updated';
				throw new Exception('process_z failed');
			}

			$sql = "UPDATE users SET password = '$password' WHERE email = '$email'";
			$result = pg_query($db, $sql);

			if($result) {
				echo 'successfully update password';
			}
			else {
				echo 'Password was not updated';
			}
		}
	?>

</body>
</html>
