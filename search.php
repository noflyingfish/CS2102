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
            //echo "$sql <br/>"; // for debugging

    	}
    	else{
            $sql = "SELECT title, description, start_date, end_date, curr$, total$ FROM project";
            //echo "$sql <br/>"; // for debugging
            $q = "everything";
    	}

    	$result = pg_query($db, $sql);

    	//here on prints the seach results nicely in a table
        $i = 0;
        echo "<html><body><table><tr>";
        while ($i < pg_num_fields($result))
        {
            $fieldName = pg_field_name($result, $i);
            echo "<td>  " . $fieldName . " </td>";
            $i = $i + 1;
        }
        echo "</tr>";
        $i = 0;

        while ($row = pg_fetch_row($result))
        {
            echo "<tr>";
            $count = count($row);
            $y = 0;
            while ($y < $count)
            {

                $c_row = current($row);


                   if ($y % 4 == 0 && $y != 0){
                      echo "<td> " . $c_row . " &nbsp <button type = ".button.">Support</button> </td>";

                }else{
                       echo "<td> " . $c_row . " &nbsp </td>";
                }


                next($row);
                $y = $y + 1;
            }
            echo "</tr>";
            $i = $i + 1;
        }
        pg_free_result($result);
        echo "</table></body></html>";


    	if($result) echo "Search results for $q returned <br/>";
        $check = true;
    }

    if(isset($_POST['back_btn'])){
         header("Location: profile.php");
    }
?>
</body>
</html>
