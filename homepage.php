<!DOCTYPE html>  
<html>
<head>
  <title>Homepage</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>

  <h1>Crowd Funding</h1>
  <h2>Welcome</h2>

  <ul>
    <form name="display" method="POST" >

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
    //show error message 
    ini_set("display_errors", "1");
    error_reporting(E_ALL);
    include('dbconnect.php');

    if(isset($_POST['signup'])){
      header("Location: createuser.php");
    }

    if(isset($_POST['login'])){
      $uemail = $_POST['email'];
      $pw = $_POST['password'];
      $sql = "SELECT * FROM Users WHERE Email = '$uemail' AND Password = '$pw' LIMIT 1 ";
      $results = pg_query($db, $sql);

      $count = pg_num_rows($results);

      if($count == 1) {
        echo "Logged in Successfully";
        header("Location: update.php");
      } else 
        echo "Wrong Password or Email";
    }
  ?>
</body> 
</html>