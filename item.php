<!DOCTYPE html>
<html>
<head>
	<title>Project</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="display.css"/>
</head>
<body>

<h1>Project Item</h1>

<?php
	include('dbconnect.php');
	session_start();
	$id = $_SESSION["id"];

	$sql = "SELECT * FROM project WHERE id = '$id'";
	$result = pg_query($db, $sql);

	///boolean.check that the user viewing this is the admin or owner.
?>
<table border ="1">
	<tr><td>Project Title:</td>
		<td><?php 
			$title = pg_fetch_result($result, 0, 3); //fetch ($resource, row, col) from the database
			echo "$title"; 
		?></td>
		<td></td> <!-- echo edit and delete button if owner/admin is the  -->

	<tr><td>Description:</td>
		<td><?php 
			$desc = pg_fetch_result($result, 0, 4);
			echo "$desc"; 
		?></td>

	<tr><td>Target Amount:</td>
		<td><?php	
			$target = pg_fetch_result($result, 0, 2);
			echo "$target"; 
		?></td>
		
		<td>Current Amount:</td>
		<td><?php	
			$curr = pg_fetch_result($result, 0, 1);
			echo "$curr"; 
		?></td>

	<tr><td>Start Date:</td>
		<td><?php
			$start = pg_fetch_result($result, 0, 6);
			echo "$start"; 
		?></td>

		<td>Start Date:</td>
		<td><?php
			$end = pg_fetch_result($result, 0, 7);
			echo "$end"; 
		?></td>
</body>
</html>