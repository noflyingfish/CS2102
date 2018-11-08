<!DOCTYPE html>
<html>
<head>
	<title>Projectsss</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="display.css"/>
</head>
<body>

<h1>Project Details</h1>



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
		<td><form name="support" action="support.php" method="POST">
                    <input type="submit" value="Support this Project" name="support_btn" >
                    </form> </td> <!-- echo edit and delete button if owner/admin is the  --> 

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
			$start = pg_fetch_result($result, 0, 5);
			echo "$start"; 
		?></td>

		<td>End Date:</td>
		<td><?php
			$end = pg_fetch_result($result, 0, 6);
			echo "$end"; 
		?></td>
		
<form name="item" action="item.php" method="POST">
	<input type="submit" value="Back to Search" name="back_btn" >
</form>

<?php

    if(isset($_POST['back_btn'])){
        if($_SESSION["from_location"] == "owner.php"){
            $_SESSION["from_location"] = "item.php";
            header("Location: owner.php");
        }else{
           header("Location: search.php");
           }
        }
?>
		
</body>
</html>
