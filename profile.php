<?php
// start the session before all
session_start();
include('dbconnect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile Page</title>
	<link rel="stylesheet" type="text/css" href="display.css"/>
</head>
<body>
<img src="banner.jpg">
	<h2>Profile Page</h2>
	
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
					if ($user_email == ""){
                        echo "Not logged in. Redirect";
                         header("Location: homepage.php");
					}
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
			<td>Project Count</td>
			<td>
				<tr>
					<td>Owned:</td>
					<td><?php 
                        $sql = "SELECT COUNT(*) as owned FROM own WHERE email = '$user_email'";
                        $result = pg_query($db, $sql);
                        $row = pg_fetch_assoc($result);
                        $count = $row['owned'];
                        echo "$count";
                        
					?></td>
				<tr>
					<td>Supported:</td>
					<td><?php 
                        $sql = "SELECT COUNT(*) as supported FROM support WHERE email = '$user_email'";
                        $result = pg_query($db, $sql);
                        $row = pg_fetch_assoc($result);
                        $count = $row['supported'];
                        echo "$count";
                        
					?></td>
			</td>

	</table>
	</td>
	</table>


<?php
	//show error message

	//echo "$user_email";

	ini_set("display_errors", "1");
	error_reporting(E_ALL);

    include('dbconnect.php');

	if (isset($_POST['profile'])){
		header("Location: profile.php");
	}
	if (isset($_POST['create'])){
		header("Location: createProject.php");
	}
	if (isset($_POST['view'])){
		header("Location: search.php");
	}
	if (isset($_POST['detail'])){
		header("Location: update.php");
	}
	if (isset($_POST['logout'])){
		session_start();
        unset($_SESSION["user_email"]); 
        header("Location: homepage.php");
	}

?>
</body>
</html>
