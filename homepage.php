<!DOCTYPE html>
<html>
<head>
  <title>Homepage</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" type="text/css" href="display.css"/>

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Include the above in your HEAD tag -------->

</head>

<!-- <title>Login Page</title> -->
 <!--Made with love by Mutiullah Samim -->

<!--Bootsrap 4 CDN-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!--Fontawesome CDN-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

<!--Custom styles-->
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="container">
<div class="d-flex justify-content-center h-100">
  <div class="card">
    <div class="card-header">
      <h3>Sign In</h3>
      <div class="d-flex justify-content-end social_icon">
      </div>
    </div>
    <div class="card-body">
      <form name="display" method="POST">
        <div class="input-group form-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
          </div>
          <input type="text" name="email" class="form-control" placeholder="Email Address">

        </div>
        <div class="input-group form-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-key"></i></span>
          </div>
          <input type="password" name="password" class="form-control" placeholder="Password">
        </div>

        <div class="form-group">
          <button type="login" name="login" class="btn float-right login_btn">Login</button>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <div class="d-flex justify-content-center links">
        Don't have an account?<a href="createuser.php">Sign Up</a>
      </div>
      <!-- <div class="d-flex justify-content-center">
        <a href="#">Forgot your password?</a>
      </div> -->
    </div>
  </div>
</div>
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

      if($pw == "" || $uemail == ""){
        echo "<script>
          alert(\"Please key in your login details.\");
          </script>";
      }else{

      $sql_is_admin = "SELECT admin FROM users WHERE email = '$uemail' AND password = '$pw'";
      $result = pg_query($db, $sql_is_admin);
      $exist = pg_num_rows($result); // 0 for wrong email/pw, 1 for account exist
      $row = pg_fetch_row($result);
      $is_admin = $row[0];

        if($exist == 0){ // wrong pw/email
          echo "<script>
          alert(\"Wrong Password or Email\");
          </script>";
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
