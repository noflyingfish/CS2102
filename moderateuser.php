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
          
          
      
          
//SQL QUERY
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    
    
            $sql = "SELECT name, email FROM users";

            $result = pg_query($db, $sql); // the result of the query
            $col = pg_num_fields($result); // the number of column

           
   
//Print query results in table   
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////      
			
            echo '<table border = "1"><tr>'; //html code for the table
            for($x = 0; $x < $col; $x++) { //for loop to print the table headings, starts at 1 to skip id
                $fieldName = pg_field_name($result, $x); //$result as an array, $x as index
                echo "<th>".$fieldName."</th>";
                }
              
          
            while ($row = pg_fetch_row($result)){ //$row is an array of each row of data

                echo "<tr>"; //html for new row, for data
                for($y = 0; $y < $col; $y++){ // starts at 1 to skip id
                        echo "<td> $row[$y] </td>";
                                            };
                                        
                    
                    
        //modify button
                   echo "<td> 
                    <form name='modify_btn' method='POST'>
                    <button type='submit' name='modify' value='$row[1]'> Modify
                    </form>";
                    }
            echo "</table>";
      
             echo "<td> 
                    <form name='back_btn' method='POST'>
                    <button type='submit' name='back_btn' > Back
                    </form>";
      
//Button handler/events
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   

 

    //back button
    if(isset($_POST['back_btn'])){
   
            header("Location: admin.php");
        }
    
    
    //moderate button
     if(isset($_POST['modify'])){
        $_SESSION["_email"] = $_POST['modify'];//pass id into moderate page. moderate.php will now directly pull up the project with id $_SESSION["id"] for the admin/owner to edit
        $_SESSION["from_location"] = "moderateuser.php";
        header("Location: moderateuser2.php");
    }


?>          

            
 

</body>
</html>
