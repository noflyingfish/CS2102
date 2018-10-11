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

    if(isset($_POST['search_btn'])){
    	$q = $_POST['query'];
        $check = true;

        if($q == ""){
            $check = false;
        }

        if($check){
            $sql = "SELECT title, description, start_date, end_date, curr$, total$ FROM project WHERE title LIKE '%$q%'";
    	}else{
            $sql = "SELECT title, description, start_date, end_date, curr$, total$ FROM project";
            $q = "everything";
    	}

    	$result = pg_query($db, $sql); // the result of the query
        $col = pg_num_fields($result); // the number of column

        echo '<table border = "1"><tr>'; //html code for the table
        for($x = 0; $x < $col; $x++) { //for loop to print the table headings
            $fieldName = pg_field_name($result, $x); //$result as an array, $x as index
            echo "<th>".$fieldName."</th>";
        }
        echo "<th>Sarpork!</th>";
        
        while ($row = pg_fetch_row($result)){ //$row is an array of each row of data
            echo "<tr>"; //html for new row, for data
            echo "<td> $row[0] </td>";
            echo "<td> $row[1] </td>";
            echo "<td> $row[2] </td>";
            echo "<td> $row[3] </td>";
            echo "<td> $row[4] </td>";
            echo "<td> $row[5] </td>";
            echo "<td> <form name=\"support_btn\" method=\"POST\">
                        <button type=\"support\" name=\"support\"> SUPPORT
                        <button type=\"support\" name=\"support\"> SUPPORT
                        <button type=\"support\" name=\"support\"> SUPPORT
                        </form>";
        }
        echo "</table>";

    	if($result) echo "Search results for $q returned <br/>";
        $check = true;
    }
    if(isset($_POST['support'])){
      header("Location: placeholder.php");
    }

    if(isset($_POST['back_btn'])){
         header("Location: profile.php");
    }
?>
</body>
</html>
