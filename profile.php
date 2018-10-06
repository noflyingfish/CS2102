<?php
// start the session before all
session_start();
include('dbconnect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile Page</title>
	<link rel="stylesheet" type="text/css" href="display.css">
</head>
<body>

	<h1>Crowd Funding</h1>
	<h2>Profile page</h2>
<table class="profile_frame">
	<td>
	<div class="menu">
	<form method="POST" >
	  <button name="profile">Profile</button>
	  <button name="create">Create Project</button>
	  <button name="view">View Project</button>
	  <button name="detail">User Details</button>
	  <button name="logout">Log Out</button>
	</form>
	</div>
	</td>

	<td>
	<table>
		<tr>
			<td>Name:</td>
			<td><?php

					$user_email = $_SESSION["user_email"];
					$sql = "SELECT * FROM users WHERE email = '$user_email'"; ///do sql query
					$result = pg_query($db, $sql);
					$row = pg_fetch_assoc($result);
					$user_name = $row['name'];
					echo "$user_name"; ?></td>

		<tr>
			<td>Email:</td>
			<td><?php
					echo "$user_email";
					?></td>
		<tr>
			<td>Number of Project</td>
			<td>
				<tr>
					<td>Owned:</td>
					<td>hardcode</td>
				<tr>
					<td>Supported:</td>
					<td>hardcode</td>
			</td>

	</table>
	</td>
	</table>


<?php
	//show error message

	echo "$user_email";

	ini_set("display_errors", "1");
	error_reporting(E_ALL);

    include('dbconnect.php');

	if (isset($_POST['profile'])){
		header("Location: placeholder.php");
	}
	if (isset($_POST['create'])){
		header("Location: placeholder.php");
	}
	if (isset($_POST['view'])){
		header("Location: search.php");
	}
	if (isset($_POST['detail'])){
		header("Location: update.php");
	}
	if (isset($_POST['logout'])){
		header("Location: placeholder.php");
	}

?>
</body>
</html>
