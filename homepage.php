<!DOCTYPE html>
<html>
<head>
  <title>Homepage</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>

  <img src="banner.jpg">
  <h2>Welcome</h2>
  <ul> 
    <form name="display" method="POST">
      <li>Email:
      <input type="text" name ="email"> </li>
      <li>Password:
      <input type="password" name ="password"> </li>

      <li>
      <button type="login" name="login"/> Login
      <button type="signup" name="signup" /> Sign up
      </li>
    </form>

  </ul>

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

      $sql = "SELECT * FROM Users WHERE Email = '$uemail' AND Password = '$pw' LIMIT 1 ";
      $results = pg_query($db, $sql);

      $count = pg_num_rows($results);

      if($count == 1) {
        echo "Logged in Successfully";
        header("Location: profile.php");
      } else
        echo "Wrong Password or Email";
    }

    //passing of variable to another php
  ?>
</body>
</html>
