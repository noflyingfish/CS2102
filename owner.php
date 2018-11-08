<!--This file is used by owners of projects, to view and update/edit their own projects. Reach this page by pressing 'my projects' button in profile.php-->

<!DOCTYPE html>
<html>
<head>
	<title>My Projects</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="display.css"/>
</head>
<body>

<h1>My Projects</h1>
<h2>My Projects</h2>


<?php
    include('dbconnect.php');
    session_start();
    $user_email = $_SESSION["user_email"];

    
    
    
//SQL QUERY
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    
    
            $sql = "SELECT id, title, description, start_date, end_date, curr$, total$ FROM project WHERE own = '$user_email'";

            $result = pg_query($db, $sql); // the result of the query
            $col = pg_num_fields($result); // the number of column

            //if no projects owned
            if ($col == 0){
                echo "No projects found";
                
            }
   
//Print query results in table   
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////      
			
            echo '<table border = "1"><tr>'; //html code for the table
            for($x = 1; $x < $col; $x++) { //for loop to print the table headings, starts at 1 to skip id
                $fieldName = pg_field_name($result, $x); //$result as an array, $x as index
                echo "<th>".$fieldName."</th>";
                }
              
          
            while ($row = pg_fetch_row($result)){ //$row is an array of each row of data

                echo "<tr>"; //html for new row, for data
                for($y = 1; $y < $col; $y++){ // starts at 1 to skip id
                        echo "<td> $row[$y] </td>";
                                            };
                                        

        //view details buton
                    echo "<td> 
                    <form name='support_btn' method='POST'>
                    <button type='submit' name='details' value='$row[0]'> View Details
                    </form>";

                    
                    
        //modify button
                   echo "<td> 
                    <form name='modify_btn' method='POST'>
                    <button type='submit' name='modify' value='$row[0]'> Modify
                    </form>";
                    }
            echo "</table>";
      
             echo "<td> 
                    <form name='back_btn' method='POST'>
                    <button type='submit' name='back_btn' > Back
                    </form>";
      
//Button handler/events
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   

    
    if(isset($_POST['details'])){
        $_SESSION["id"] = $_POST['details'];
         $_SESSION["from_location"] = "owner.php";
        header("Location: item.php");
    }

    //back button
    if(isset($_POST['back_btn'])){
   
            header("Location: profile.php");
        }
    
    
    //moderate button
     if(isset($_POST['modify'])){
        $_SESSION["id"] = $_POST['modify'];//pass id into moderate page. moderate.php will now directly pull up the project with id $_SESSION["id"] for the admin/owner to edit
        $_SESSION["from_location"] = "owner.php";
        header("Location: moderate.php");
    }


?>


</body>
</html>
