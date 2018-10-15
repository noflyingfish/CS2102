<!DOCTYPE html>
<html>
<head>
	<title>Project Moderation</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<!--get variables from view MY project page-->
<h1>Crowd Funding</h1>
<h2>Project Moderation</h2>

<form name="moderate" action="moderate.php" method="POST">
	
	<input type="submit" value="Go back to profile" name="back_btn" >
</form>

<?php
            include('dbconnect.php');
          session_start();
          if($_SESSION["mod"] == false)    //added layer of security. Test by logging in as normal user then go to localhost/moderate.php 
          {
                 header("Location: homepage.php");
          }
          
            
            $q = $_SESSION["id"]; 
            $sql = "SELECT * FROM project WHERE id = '$q'";
            //echo "$sql <br/>"; // for debugging
            
            $result = pg_query($db, $sql);
            $numresults = pg_num_rows($result);
            if($numresults == 0){
                echo "Project with projectid $q not found. Please enter another query.";
            }else{
					$row = pg_fetch_assoc($result);
					$id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $curr = $row['curr$'];
                    $total = $row['total$'];
                    $start = $row['start_date'];
                    $end = $row['end_date'];
                    $keywords = $row['project_keywords'];
                    
                    
                    echo "<form name='display' action='moderate.php' method='POST' >
                    Title:<input type='text' name='new_title' value='$title'/>
                    Description:<input type='text' name='new_description' value='$description'/>
                    Current amount ($):<input type='text' name='new_curr' value='$curr'/>
                    Amount seeking ($):<input type='text' name='new_total' value='$total'/>
                    Start date:<input type='text' name='new_start' value='$start'/>
                    End date:<input type='text' name='new_end' value='$end'/>
                    Project keywords:<input type='text' name='new_keyword' value='$keywords'/>
                    <br>
                    <input type='submit' name='update' value='Update' />
                    <input type='submit' name='delete' value='Delete Project' />
                    
                    </form>";
	
	
                }
	
    	
    	
    
    	
    	   //update the project with whatever is in the fields
    if (isset($_POST['update'])) {	
   
      $id = $_SESSION["ID"];             
      $title = $_POST['new_title'];
      $description = $_POST['new_description'];
      $curr = $_POST['new_curr'];
      $end_date = $_POST['new_end'];
      $keywords = $_POST['new_keyword'];
      $total = $_POST['new_total'];
      $start_date = $_POST['new_start'];
      
    
    
    	$sql = "UPDATE project SET title = '$title', description = '$description', curr$ = '$curr', 
      total$ = '$total', start_date = '$start_date', end_date = '$end_date', project_keywords = '$keywords' WHERE id = '$id'";
			//echo $sql . "<br>";
			$result = pg_query($db, $sql);

			if($result) {
				echo "Your project details are updated!";
			}
			else {
				echo "Project $id was not updated.";
			}
		}
     
	   if (isset($_POST['delete'])) {	
   
      $id = $_SESSION["ID"];             
      
        $sql3 = "DELETE FROM own WHERE id = '$id'";    //manual delete cascading
        $sql2 = "DELETE FROM support WHERE id = '$id'";     //manual delete cascading
    	$sql = "DELETE FROM project WHERE id = '$id'";
			//echo $sql . "<br>";
			$result3 = pg_query($db,$sql3);
			$result2 = pg_query($db,$sql2);
			$result = pg_query($db, $sql);
			

			if($result) {
				echo "Your project details are updated!";
			}
			else {
				echo "Project $id was not updated.";
			}
		}
     
       if (isset($_POST['back_btn'])) {	
              header("Location: admin.php");
   }

?>

 

</body>
</html>
