<!DOCTYPE html>
<html>
<head>
	<title>Create New User</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="display.css"/>
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
	<input type="submit" value="Back" name="back_btn" >
</form>

<?php
    include('dbconnect.php');
    session_start();     
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

        if(strpos($email, '@') === false){
            echo "Please enter a valid email address!<br/>";
        } else{
            $sql_check_user_exist = "SELECT * FROM users where email = '$email'";
            $user_result = pg_query($db, $sql_check_user_exist);
            $user_exist = pg_num_rows($user_result);

            if($user_exist != 0){
                $check = false;
                echo "Email account already registered. <br/>";
            }

            if($check){
        	   $sql = "INSERT INTO users (name, email, password) VALUES('".$name."', '".$email."', '".$p1."')";
        	   echo "$sql <br/>"; // for debugging
        	   $add = pg_query($db, $sql);
        	   if($add) echo "add user $name successful <br/>";
                    
                    if($_SESSION["mod"] == false){ //check if mod or user called this page, then return to the appropriate page
                        header("Location: homepage.php");
                    }else{
                        header("Location: admin.php");
                    }
        	}
        }
        $check = true;
    }
    
    //back button
    if(isset($_POST['back_btn'])){
        if($_SESSION["mod"] == false){       //check if mod or user called this page, then return to the appropriate page
            header("Location: homepage.php");
        }else{
            header("Location: admin.php");
        }
    }
?>
</body>
</html>
