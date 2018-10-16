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

      if($uemail == "" || $pw == ""){
        echo "Please key in your login details";
      }else{

      $sql_is_admin = "SELECT admin FROM users WHERE email = '$uemail' AND password = '$pw'";
      $result = pg_query($db, $sql_is_admin);
      $exist = pg_num_rows($result); // 0 for wrong email/pw, 1 for account exist
      $row = pg_fetch_row($result);
      $is_admin = $row[0];

        if($exist == 0){ // wrong pw/email
          echo "Wrong Password or Email";
        }else if($is_admin == 0){ //normal user
          header("Location: profile.php");
        }else if($is_admin == 1 ){ //admin user
          header("Location: admin.php");
        }
      }
    }
  ?>
</body>
</html>
