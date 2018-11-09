<!--This file does the editing/deleting of projects. Used by admins and owners only-->

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
	
	<input type="submit" value="Back to Search" name="back_btn" >
</form>

<?php
            include('dbconnect.php');
          session_start();
          if($_SESSION["mod"] == false && !($_SESSION["from_location"] == "owner.php"))    //added layer of security. Test by logging in as normal user then go to localhost/moderate.php 
          {
                 header("Location: homepage.php");
          }
    
//SQL Query
//Tasks/Issues:
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
            
            $q = $_SESSION["id"];          //note session variable names are case sensitive!
            $sql = "SELECT * FROM project WHERE id = '$q'";
            $sql2 = "SELECT id, array_to_string(array_agg(word), ',') AS wordlist FROM keywords WHERE id = '$q' GROUP BY id";
        
            
            $result = pg_query($db, $sql);
            $result2 = pg_query($db,$sql2);
            $numresults = pg_num_rows($result);
            
            
      
//Pull out details to do with project with project id "id" for user to edit
//Tasks/Issues:
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                
            if($numresults == 0){
                echo "No projects found";
            }else{
					$row = pg_fetch_assoc($result);
					$row2 = pg_fetch_assoc($result2);
					$id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $curr = $row['curr$'];
                    $total = $row['total$'];
                    $start = $row['start_date'];
                    $end = $row['end_date'];
                    $keywords = $row2['wordlist'];
                    
                    
                    echo "<form name='display' action='moderate.php' method='POST' >
                    <table>
                    <tr>
                    <td>Title:
                    <td><input type='text' name='new_title' value='$title'/>
                    <tr>
                    <td>Description:
                    <td><input type='text' name='new_description' value='$description'/>
                    <tr>
                    <td>Current amount ($):
                    <td><input type='text' name='new_curr' value='$curr'/>
                    <tr>
                    <td>Amount seeking ($):
                    <td><input type='text' name='new_total' value='$total'/>
                    <tr>
                    <td>Start date:
                    <td><input type='text' name='new_start' value='$start'/>
                    <tr>
                    <td>End date:
                    <td><input type='text' name='new_end' value='$end'/>
                    <tr>
                    <td>Project keywords:
                    <td><input type='text' name='new_keyword' value='$keywords'/>
                    <br>
                    <input type='submit' name='update' value='Update' />
                    <input type='submit' name='delete' value='Delete Project' />
                    
                    </form>";
	
	
                }
	
    	
//Update button click event handler (admin/owner chooses to update project)
//Tasks/Issues: 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    if (isset($_POST['update'])) {	
   
      $id = $_SESSION["id"];             
      $title = $_POST['new_title'];
      $description = $_POST['new_description'];
      $curr = $_POST['new_curr'];
      $end_date = $_POST['new_end'];
      $update_keywords = $_POST['new_keyword'];    
      $myArray = explode(',', $update_keywords);
      $total = $_POST['new_total'];
      $start_date = $_POST['new_start'];
      
    
    	$sql = "UPDATE project SET title = '$title', description = '$description', curr$ = '$curr',
        total$ = '$total', start_date = '$start_date', end_date = '$end_date' WHERE id = '$id'";
        
        $sql2 = "DELETE FROM keywords WHERE id = '$q'";     //clear out the keywords table
        
          $result = pg_query($db, $sql);
          $result2 = pg_query($db, $sql2);
          
        
        //update keywords----------------------------------------------------------------------------------------
        foreach($myArray as $tag) {
            

            if ((preg_match("/^[a-zA-Z0-9]+$/", $tag) == 1)) { //1 as true, only a-z A-Z 0-9
              $sql_keyword = "INSERT INTO keywords (id, word) VALUES ('".$q."', '".$tag."')";
              $add_keyword = pg_query($db,$sql_keyword);
            }
          }
            
        
        //-------------------------------------------------------------------------------------------------------
		
    
            
            //if updated successfully, refresh page to reflect correct updated values else return an error message
			if($result) {
                header("Refresh:0");  //refresh the page
				echo "Project details updated!";
			}
			else {
				echo "Project with id $id was not updated.";
			}
		}
     
     
//Delete button click event handler (admin/owner chooses to delete project)
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
	   if (isset($_POST['delete'])) {	
   
      $id = $_SESSION["id"];             
      
        $sql3 = "DELETE FROM keywords WHERE id = '$id'";   //manual delete cascading
        $sql2 = "DELETE FROM support WHERE id = '$id'";     //manual delete cascading
    	$sql = "DELETE FROM project WHERE id = '$id'";
	
			$result3 = pg_query($db,$sql3);
			$result2 = pg_query($db,$sql2);
			$result = pg_query($db, $sql);
			

			if($result) {
				echo "Project deleted!!";
                 echo "<td> <form name=\"back_btn\" method=\"POST\">
                        <button type=\"back\" name=\"back\"> Back to Search
                        </form>";
				

                //this portion handles the back button that appears only after the project is deleted
				if(isset($_POST['back'])){
                       
                    if($_SESSION["from_location"] == "owner.php"){   //means user came from owner's view projects page
                        $_SESSION["from_location"] == "";        //reset variable 
                        header("Location: owner.php");
                                                                }
                    else{
                        header("Location: search.php");  //user was an admin
                        }
                                        }
				
			}
			else {
				echo "Project with id $id was not deleted.";
                }
            }
  
//Back button click event handler (Admin/owner is satisfied and wants to return to where he previously came from)
//$_SESSION["from_location"] is only used in owner.php to indicate that the user came from owner.php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////      
       if (isset($_POST['back_btn']) || isset($_POST['back'])) {	
            
            if($_SESSION["from_location"] == "owner.php"){   //means user came from owner's view projects page
                $_SESSION["from_location"] == "";        //reset variable 
                header("Location: owner.php");
            }else{
              header("Location: search.php");  //user was an admin
              }
   }

?>

 

</body>
</html>
