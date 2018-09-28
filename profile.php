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
			<td>1</td>
			<td>2</td>
		</tr>
		<tr>
			<td>1</td>
			<td>2</td>
		</tr>
		<tr>
			<td>1</td>
			<td>2</td>
		</tr>
	</table>
	</td>
	</table>


<?php
	//show error message
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
		header("Location: placeholder.php");
	}
	if (isset($_POST['detail'])){
		header("Location: placeholder.php");
	}
	if (isset($_POST['logout'])){
		header("Location: placeholder.php");
	}

?>
</body>
</html>