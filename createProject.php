<!DOCTYPE html>
<html>
<head>
  <title>Create Project</title>
  <link rel="stylesheet" type="text/css" href="display.css"/>
  <style>li {list-style: none;}</style>
    </head>
    <body>

  <h1>Create your Project!</h1>
  <h2>Please fill in the Relevant details below</h2>

<form name="create project" action="createProject.php" method="POST">
	<li>Title:
	<input type="text" name ="title"> </li>
	<li>Description:
	<input type="text" name="description"> </li>
  <div>
    <label for="startDate">Enter your Start Date (yyyy-mm-dd):</label>
    <input type="date" id="startDate" name="startDate">
  </div>
  <div>
    <label for="endDate">Enter your End Date (yyyy-mm-dd):</label>
    <input type="date" id="endDate" name="endDate">
  </div>
  <li>Target Capital for Project ($):
  <input type="number" name="targetCapital"> </li>
  <li>Current Capital in project ($):
  <input type="number" name="currentCapital"> </li>
  <li>Keywords for search (separate by comma e.g a,b,c):
  <input type="text" name="keywords"> </li>

	<input type="submit" value="Create Project" name="submit" >
	<input type="submit" value="Back to Profile" name="back_btn" >
</form>


    </body>

<?php
		//getting variable from another php
		session_start();
    include('dbconnect.php');
    $user_email = $_SESSION["user_email"];

    if(isset($_POST['submit'])){
      $title = $_POST['title'];
      $description = $_POST['description'];
      $startDate = $_POST['startDate'];
      $endDate = $_POST['endDate'];
      $target = $_POST['targetCapital'];
      $curr = $_POST['currentCapital'];
      $keywords = $_POST['keywords'];
      $myArray = explode(',', $keywords);
      $create = true;

      //Validation for blank info
      if ($title == "" || $startDate == "" || $endDate == "" || $target == "" || $curr == "" || $keywords == "" || $description == "") {
        $create = false;
        echo "Please ensure all details are filled";
      }

      //Add to database
      if($create) {
        $sql_project = "INSERT INTO project (curr$, total$, title, description, start_date, end_date, own) VALUES('".$curr."', '".$target."', '".$title."', '".$description."', '".$startDate."', '".$endDate."', '".$user_email."') RETURNING id";
        $add_project = pg_query($db,$sql_project);
        $result = pg_fetch_row($add_project);
        $last_id = $result[0];
        $add_keyword;
        if($add_project){
          echo "Project $title has been successfully created";
          foreach($myArray as $tag) {
            
            $sql_check_exist = "SELECT * FROM keywords WHERE id ='$last_id' AND word='$tag'";
            $result = pg_query($db, $sql_check_exist);
            $pair_exist = pg_num_rows($result); // 0 if new, 1 if id/word pair already exist.

            if($pair_exist != 0){
                continue;
            }

            if ((preg_match("/^[a-zA-Z0-9]+$/", $tag) == 1)) { //1 as true, only a-z A-Z 0-9
              $sql_keyword = "INSERT INTO keywords (id, word) VALUES ('".$last_id."', '".$tag."')";
              $add_keyword = pg_query($db,$sql_keyword);
            }
          }
        }
        else {
          echo "Project $title was not added";
        }

        if($add_keyword) {
            echo "<br>Keywords recorded to project";
        }else {
            echo "<br>Failed to add keywords"; //debug
        }
      }
      $create = true; //to reset
    }

     if(isset($_POST['back_btn'] )){

      if($_SESSION["mod"] == false){
          header("Location: profile.php");
      }else {
          header("Location: admin.php");
      }
    }
?>

</head>
</html>
