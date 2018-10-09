
<!DOCTYPE html>
<html>
<head>
  <title>Create Project</title>
  <style>li {list-style: none;}</style>
    </head>
    <body>

  <h1>Create your Project!</h1>
  <h2>Please fill in the Relevant details below</h2>
  
<form name="create user" action="createuser.php" method="POST">
	<li>Title:
	<input type="text" name ="description"> </li>
	<li>Description:
	<input type="text" name="description"> </li>
  <div>
    <label for="startDate">Enter your Start Date:</label>
    <input type="date" id="startDate" name="startDate">
  </div>
  <div>
    <label for="endDate">Enter your End Date:</label>
    <input type="date" id="endDate" name="endDate">
  </div>
  <li>Target Capital for Project:
  <input type="number" name="currCapital"> </li>
  <li>Current Capital in project:
  <input type="number" name="targetCapital"> </li>
  <li>Keywords for search:
  <input type="text" name="keywords"> </li>

	<input type="submit" value="Create Project" name="submit" >
</form>


    </body> 
    
<?php
		//getting variable from another php
		session_start();
        include('dbconnect.php');
        if(isset($POST['submit'])){
          $title = $_POST['name'];
          $description = $_POST['name'];
          $startDate = $_POST['name'];
          $endDate = $_POST['name'];
          $target = $_POST['name'];
          $curr = $_POST['name'];
          $keywords = $_POST['name']; 
          $create = true;
         
          //Validation for blank info
          if ($title == "" || $startDate == "" || $endDate == "" || $target == "" || $curr == "" || $keywords == "" || $description == "") {
            $create = false;
            echo "Please ensure all details are filled";
          }

          //Add to database
          if($create) {
            $sql = "INSERT INTO projects (curr$, total$, title, description, project_keywords, start_date, end_date) VALUES('" .$curr."', '".$target."', '".$title."', '".$description."', '".$keywords."', '".$startDate."', '".$endDate."')";
            echo " $sql <br/>" ; //debugging
            $add = pg_query($db,$sql);
            if($add){
            echo "Project $title has been successfully created"; 
            }
          }
          $create = true; //to reset          
        }
?>

</head>
</html>