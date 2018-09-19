<!DOCTYPE html>
<html>
<head>
	<title>Create New User</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h1>Crowd Funding</h1>
<h2>Create a new user</h2>

<form name="create user" action="createuser.php" method="POST">
	<li>Name:
	<input type="text" name ="name"> </li>
	<li>Email:
	<input type="text" name="email"> </li>
	<li>New Password:
	<input type="password" name="password_1"> </li>
	<li>Confirm Password:
	<input type="password" name="password_2"> </li> 
	<input type="submit" value="Create New User" name="submit" >
</form>

<?php
//show error message 
ini_set("display_errors", "1");
error_reporting(E_ALL);

    include('dbconnect.php');
    //if($db) echo "db connected in createuser<br/>"; //debug

    if(isset($_POST['submit'])){
    	$name = $_POST['name'];
        $email = $_POST['email'];
        $p1 = $_POST['password_1'];
    	$p2 = $_POST['password_2'];
        $check = true;
        
        if ($name == "" || $email == "" || $p1 == "" || $p2 == "") {
            $check = false;
            echo "Missing user details.<br/>";
        }
    	if($p1 !== $p2){
            $check = false;
            echo "Password and confirm password does not match.<br/>";
        }

        if($check){
    	$sql = "INSERT INTO users (name, email, password) VALUES('".$name."', '".$email."', '".$p1."')";
    	echo "$sql <br/>"; // for debugging
    	$add = pg_query($db, $sql);
		
    	if($add) echo "add user $name successful <br/>";
        header("Location: homepage.php");
    	} 
        $check = true;
    }
?>  
</body>
</html>