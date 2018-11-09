<!DOCTYPE html>
<html>
<head>
	<title>User Moderation</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<!--get variables from view MY project page-->
<h1>Crowd Funding</h1>
<h2>User Moderation</h2>



<?php
            include('dbconnect.php');
          session_start();
          if($_SESSION["mod"] == false)    //added layer of security. Test by logging in as normal user then go to localhost/moderate.php 
          {
                 header("Location: homepage.php");
          }
          
          
       
          
            $q = $_SESSION["_email"];
    
            $sql = "SELECT * FROM users WHERE email = '$q'";
           
           // echo "$sql <br/>"; // for debugging
            
            $result = pg_query($db, $sql);
            $numresults = pg_num_rows($result);
            if($numresults == 0){
                echo "User with email $q not found. Please enter another query.";
            }else{
					$row = pg_fetch_assoc($result);
					$name = $row['name'];
                    $email = $row['email'];
                    $password = $row['password'];    //adding this feature for now. Clarify with tutor if admin has the privilege of seeing/changing pw or not.
                    
                  
                    
                    echo "<form name='display' action='moderateuser2.php' method='POST' >
                    <table><tr>
                    <td>Name:
                    <td><input type='text' name='new_name' value='$name'/>
                    <tr>
                    <td>Email:
                    <td><input type='text' name='new_email' value='$email'/>
                    <tr>
                    <td>Password:
                    <td><input type='text' name='new_password' value='$password'/>
                    </table>
                    <br>
                    <input type='submit' name='update' value='Update' />
                    <input type='submit' name='back' value='Back' />
                    
                    </form>";
	
	
                }
	

    	
    	
    	
    	

    

    
    	
    //update the project with whatever is in the fields
    if (isset($_POST['update'])) {	
        
      
      $q = $_SESSION["_email"];
      $email = $_POST['new_email'];
      $name = $_POST['new_name'];
      $password = $_POST['new_password'];
     
      
    
    
    	$sql = "UPDATE users SET name = '$name', email = '$email', password = '$password' WHERE email = '$q'";
			//echo $sql . "<br>";
			$result = pg_query($db, $sql);

			if($result) {
                header("Refresh:0");
				echo "User details are updated!";
			}
			else {
				echo "User with email $q was not updated.";
			}
		}
     
   /* DEPRECATED
     //deletion
	   if (isset($_POST['delete'])) {	
   
      $q = $_SESSION["_email"];             
      
      
          $sql3 = "DELETE FROM own WHERE email = '$q'";    //manual delete cascading
        $sql2 = "DELETE FROM support WHERE email = '$q'";     //manual delete cascading
        $sql = "DELETE FROM users WHERE email = '$q'";
			//echo $sql . "<br>";
			$result3 = pg_query($db,$sql3);
			$result2 = pg_query($db,$sql2);
			$result = pg_query($db, $sql);

			if($result) {
                header("Refresh:0");
				echo "User deleted!";
			}
			else {
				echo "User with email $q could not be deleted.";
			}
		}
		*/
     
       if (isset($_POST['back'])) {	
              header("Location: moderateuser.php");
   }

?>

 

</body>
</html>
