
<!DOCTYPE html>
<html>
<head>
  <title>Create Project</title>
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

	<input type="submit" value="create project" name="submit" >
	<input type="submit" value="go back to profile" name="back_btn" >
</form>


    </body> 
    
<?php
		//getting variable from another php
		session_start();
        include('dbconnect.php');
        if(isset($_POST['submit'])){
          $title = $_POST['title'];
          $description = $_POST['description'];
          $startDate = $_POST['startDate'];
          $endDate = $_POST['endDate'];
          $target = $_POST['targetCapital'];
          $curr = $_POST['currentCapital'];
          $keywords = $_POST['keywords']; 
          $create = true;
          
         
          //Validation for blank info
          if ($title == "" || $startDate == "" || $endDate == "" || $target == "" || $curr == "" || $keywords == "" || $description == "") {
            $create = false;
            echo "Please ensure all details are filled";
          }

          //Add to database
          if($create) {
            $sql = "INSERT INTO project (curr$, total$, title, description, project_keywords, start_date, end_date) VALUES('".$curr."', '".$target."', '".$title."', '".$description."', '".$keywords."', '".$startDate."', '".$endDate."')";
            //echo " $sql <br/>" ; //debugging
            $add = pg_query($db,$sql);
            if($add){
            echo "Project $title has been successfully created"; 
            }else {
                echo "failed";    //debug
            }
          }else{
                echo "failed2";   //debug
          }
          $create = true; //to reset          
        }
        
         if(isset($_POST['back_btn'])){
         header("Location: profile.php");
    }
?>

</head>
</html>
