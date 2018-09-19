<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h1>Crowd Funding</h1>
<h2>User Profile</h2>

	<form name="display" action="update.php" method="POST" >
		<li>Account Email:<input type="text" name="email" /></li>
		<li><input type="submit" name="submit" /></li>
	</form>

<?php
//show error message 
ini_set("display_errors", "1");
error_reporting(E_ALL);

	include('dbconnect.php');
	$result = pg_query($db, "SELECT * FROM user");	// Query template
	$row    = pg_fetch_row($result);		// To store the result row
	$count = pg_query($db, "SELECT count(*) FROM user");
	$email = $_POST['email'];
	echo "num of data " . pg_num_rows($count) . "<br/>";

	if (isset($_POST['submit'])) {
		echo "<ul><form name='update' action='update.php' method='POST'>
		<li>New Password:</li>
		<li><input type='text' name='new_password' value='$row[password]' /></li>
		<li><input type='submit' name='new' /></li>
		</form>
		</ul>";
	}
	$password = $_POST['new_password'];
	if (isset($_POST['new'])) {	// Submit the update SQL command
		echo "new password input : $password <br/>"; //debugging
		$sql = "UPDATE user SET password = '$password', WHERE email = '$email'";
		echo "sql <br/>"; //debug
		$result = pg_query($db, $sql);
		if($result) {
		echo "Update successful! <br/>";
	}
}

?>
</body>
</html>