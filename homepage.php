<!DOCTYPE html>
<html>
<head>
  <title>Homepage</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="display.css"/>
</head>
<body>

  <img src="banner.jpg">
  <h2>Welcome</h2>

    <div class="menu">
    <form name="display" method="POST">
      <input type="text" name ="email" placeholder ="Email">
      <input type="password" name ="password" placeholder ="Password">
      <button type="login" name="login"> Login
      <button type="signup" name="signup"> Sign up
    </form>
    </div>

  <?php
    session_start();
    include('dbconnect.php');

    if(isset($_POST['email'])){
      $uemail = $_POST['email'];
      $_SESSION["user_email"] = $uemail;
    }

    if(isset($_POST['password'])){
      $pw = $_POST['password'];
    }

    if(isset($_POST['signup'])){
      header("Location: createuser.php");
    }

    if(isset($_POST['login'])){

      if($uemail == "" || $pw == "") {
        echo "Please key in your login details";
        throw new Exception('process_z failed');
      }

      $sql_user = "SELECT COUNT(*) FROM users WHERE email = '$uemail' AND password = '$pw'";
      $is_user = pg_query($db, $sql_user);
      $count_user = pg_num_rows($is_user);// 1 if exist.

      $sql_admin = "SELECT COUNT(*) FROM admin WHERE email = '$uemail' AND password = '$pw'";
      $is_admin = pg_query($db, $sql_admin);
      $count_admin = pg_num_rows($is_admin);// 1 if exist

      if($count_user == 1) {
        echo "Logged in Successfully";
        header("Location: profile.php");
      }else if($count_admin == 1){
        echo "Logged in Successfully";
        header("Location: admin.php");
      }else{
        echo "Wrong Password or Email";
      }
    }
  ?>
</body>
</html>
