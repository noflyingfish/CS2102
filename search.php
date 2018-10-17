<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="display.css"/>
</head>
<body>

<h1>Search</h1>
<h2>Search for a Project</h2>

<form name="search" action="search.php" method="POST">
	Enter search here:
	<input type="text" name ="query">
	<input type="submit" value="search" name="search_btn" >
	&nbsp
	<input type="submit" value="go back to profile" name="back_btn" >
</form>

<?php
    include('dbconnect.php');
    session_start();

    if(isset($_POST['search_btn'])){
    	$q = $_POST['query'];
        $check = true;

        if($q == ""){
            $check = false;
        }

        if($check){
            $sql = "SELECT id, title, description, start_date, end_date, curr$, total$ FROM project WHERE title LIKE '%$q%'";
    	}else{
            $sql = "SELECT id, title, description, start_date, end_date, curr$, total$ FROM project";
            $q = "everything";
    	}

    	$result = pg_query($db, $sql); // the result of the query
        $col = pg_num_fields($result); // the number of column

        echo '<table border = "1"><tr>'; //html code for the table
        for($x = 1; $x < $col; $x++) { //for loop to print the table headings, starts at 1 to skip id
            $fieldName = pg_field_name($result, $x); //$result as an array, $x as index
            echo "<th>".$fieldName."</th>";
        }
        echo "<th>Sarpork!</th>";
        
        while ($row = pg_fetch_row($result)){ //$row is an array of each row of data
            echo "<tr>"; //html for new row, for data
            for($y = 1; $y < $col; $y++){ // starts at 1 to skip id
                echo "<td> $row[$y] </td>";
            };
            echo "<td> <form name=\"support_btn\" method=\"POST\">
                    <button type=\"support\" name=\"support\"> SUPPORT
                    <button type=\"details\" name=\"details\" value=\" $row[0]\"> View Details";
                        
                    //admin.php will route here to use search.php to find projects to modify. This checks if the session requesting this page is mod-enabled or not and if so, //returns an additional button for moderators to use
                    if($_SESSION["mod"] == true){           
                        echo "<button type=\"modify\" name=\"modify\" value=\" $row[0]\"> Modify";
                    }
                        echo "</form>";
            // support row, hidden by default. // need to make this appear on click on support button
            echo "<tr name=\"support_row\" style =\"display:none\">
                    <td>Amount to support:</td>
                    <td><input type=\"text\" placeholder =\"Supporting Amount\" name=\"amt_support\"></td> 
                    <td><input type = \"submit\" value =\"Support Your Amount!\" name=\"btn_support\"></td>";
        }
        echo "</table>";

    	if($result) echo "Search results for $q returned <br/>";
        $check = true;
    }

    if(isset($_POST['support'])){
        header("Location: placeholder.php");
    }
    if(isset($_POST['details'])){
        $_SESSION["id"] = $_POST['details'];
        header("Location: item.php");
    }

    if(isset($_POST['back_btn'])){
        //reroute back to the correct page since admin is sharing usage of this page as well
        if($_SESSION["mod"] == true){
            header("Location: admin.php");
        }else{
        header("Location: profile.php");
        }
    }
    
    //for admin use only
     if(isset($_POST['modify'])){
        $_SESSION["id"] = $_POST['modify'];//pass id into moderate page. moderate.php will now directly pull up the project with id $_SESSION["id"] for the admin to edit
        header("Location: moderate.php");
    }
?>

</body>
</html>
