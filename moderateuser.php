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

<form name="search" action="moderateuser.php" method="POST">
	Enter email of user to moderate:
	<input type="text" name ="user_email">
	<input type="submit" value="Retrieve" name="search_btn" >
	<input type="submit" value="Go Back" name="back_btn" >

</form>


<?php
          session_start();
          if($_SESSION["mod"] == false)    //added layer of security. Test by logging in as normal user then go to localhost/moderate.php 
          {
                 header("Location: homepage.php");
          }
          
          
          include('dbconnect.php');
          
if(isset($_POST['search_btn'])){
    	$q = $_POST['user_email'];
        $check = true;

        if($q == ""){
            $check = false;
            echo "Please enter a query.";
        }

        if($check){
            $_SESSION["_email"] = $q;       //make ID 'global' to access it below
            $sql = "SELECT * FROM users WHERE email = '$q'";
           
            //echo "$sql <br/>"; // for debugging
            
            $result = pg_query($db, $sql);
            $numresults = pg_num_rows($result);
            if($numresults == 0){
                echo "User with email $q not found. Please enter another query.";
            }else{
					$row = pg_fetch_assoc($result);
					$name = $row['name'];
                    $email = $row['email'];
                    $password = $row['password'];    //adding this feature for now. Clarify with tutor if admin has the privilege of seeing/changing pw or not.
                    
                  
                    
                    echo "<form name='display' action='moderateuser.php' method='POST' >
                    Name:<input type='text' name='new_name' value='$name'/>
                    Email:<input type='text' name='new_email' value='$email'/>
                    Password:<input type='text' name='new_password' value='$password'/>
                  
                    <br>
                    <input type='submit' name='update' value='Update' />
                    <input type='submit' name='delete' value='Delete User' />
                    
                    </form>";
	
	
                }
	

    	}
    	
    	
    	
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
				echo "User details are updated!";
			}
			else {
				echo "User with email $q was not updated.";
			}
		}
     
     
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
				echo "User deleted!";
			}
			else {
				echo "User with email $q could not be deleted.";
			}
		}
     
       if (isset($_POST['back_btn'])) {	
              header("Location: admin.php");
   }

?>

 

</body>
</html>
