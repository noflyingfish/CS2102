
<?php
//remaining tasks: edit and delete 'own' and 'support' entries


// start the session before all
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrator Page</title>
	<link rel="stylesheet" type="text/css" href="display.css"/>
</head>
<body>
<img src="banner.jpg">
	<h2>Administrator Page</h2>
<table class="profile_frame">
	<td>
	<div class="menu">
	<form method="POST" >
	  <button name="create">Create Project</button>
	  <button name="createuser">Create User</button>
	  <button name="mod">Moderate Projects</button>
	  <button name="moduser">Moderate Users</button>
	  <button name="detail">Admin Details</button>
	  <button name="logout">Log Out</button>
	</form>
	</div>
	</td>

	<td>
	<table>
		<tr>
			<td>Name:</td>

			<td><?php
			include('dbconnect.php');
         	$_SESSION["mod"] = true;   //to be passed to other shared php files e.g createproject, update project
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

			</td>

	</table>
	</td>
	</table>


<?php
	//show error message
	ini_set("display_errors", "1");
	error_reporting(E_ALL);

	if (isset($_POST['mod'])){
		header("Location: search.php");  //admin will search for project to moderate
	}
	if (isset($_POST['create'])){
		header("Location: createProject.php");  //let admin create a project normally. check for mod status on createProject.php using session var, then give additional powers. Also reroute the back button to admin page instead of normal user page by using session var.
	}
	if (isset($_POST['detail'])){
		//header("Location: update.php");   //NEED TO EDIT UPDATE.PHP to let admin chage pw. W/A: Don't let mod update details yet.
	}
	if (isset($_POST['moduser'])){
		header("Location: moderateuser.php");
	}
	if (isset($_POST['createuser'])){
		header("Location: createuser.php");
	}
	if (isset($_POST['logout'])){
    
        unset($_SESSION["user_email"]);    //clear the 'cookies'
        unset($_SESSION["mod"]);
        header("Location: homepage.php");
	}

?>
</body>
</html>
