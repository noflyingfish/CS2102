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
    include('dbconnect.php');
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

        $sql_check_user_exist = "SELECT COUNT(*) FROM users where email = '$email'";
        $sql_check_admin_exist = "SELECT COUNT(*) FROM admin where email = '$email'";
        $user_exist = pg_query($db, $sql_check_user_exist);
        $admin_exist = pg_query($db, $sql_check_admin_exist);
        if($user_exist != 0 || $admin_exist != 0){
            $check = false;
            echo "Email account already registered. <br/>";
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