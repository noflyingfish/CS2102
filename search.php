<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="display.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<h1>Search</h1>
<h2>Search for a Project</h2>

<form name="search" action="search.php" method="POST">

    <select name ="type" >
        <option value="title">Title</option>
        <option value="keyword">Keyword</option>
    </select>

	<input type="text" name ="query" placeholder="Search">
	<input type="submit" value="search" name="search_btn" >
	&nbsp
	<input type="submit" value="go back to profile" name="back_btn" >
</form>

<?php
    include('dbconnect.php');
    session_start();
    $c = 1;

    if(isset($_POST['search_btn'])){
    	$q = $_POST['query'];
        $check = true;

        if($q == ""){
            $check = false;
        }

        if($check){
            $sql = //"SELECT p.id, p.title, p.description, p.start_date, p.end_date, p.curr$, p.total$
					//FROM project p WHERE UPPER(p.title) LIKE UPPER('%$q%')";
					"SELECT DISTINCT p.id, p.title, p.description, p.curr$, p.total$
					FROM project p, keywords k
					WHERE k.id = p.id
					AND ((UPPER(p.title) LIKE UPPER('%$q%')) OR (UPPER(k.word) LIKE UPPER('%$q%')))";
    	}else{
            $sql = "SELECT id, title, description, curr$, total$ FROM project";
            $q = "everything";
    	}

        $result = pg_query($db, $sql); // the result of the query
        $col = pg_num_fields($result); // the number of column
        if($result) echo "Search results for $q returned <br/>";
			//print table headers
      echo '<table border = "1"><tr>'; //html code for the table
      for($x = 1; $x < $col; $x++) { //for loop to print the table headings, starts at 1 to skip id
          $fieldName = pg_field_name($result, $x); //$result as an array, $x as index
          
          if($x == 3){   
          } else if($x == 4){
            echo "<th> Status </th>";
          }else{
            echo "<th>".$fieldName."</th>";
          }
      }
      echo "<th>View Details</th>";

      $c = 1; // c as a counter to loop through, and index of each row
      while ($row = pg_fetch_row($result)){ //$row is an array of each row of data
        $currAmt = 0;
        $totalAmt = 0;
        echo "<tr>"; //html for new row, for data
        for($y = 1; $y < $col; $y++){ // starts at 1 to skip id
            if($y == 3){
                $currAmt = $row[$y];
            }else if($y == 4){
                $totalAmt = $row[$y];
                $sta = $totalAmt - $currAmt;
                if($sta <= 0){
                    echo "<td>Funded!</td>";
                }else{ 
                    echo "<td>Looking for Funds!</td>";
                }
            }else{
                echo "<td> $row[$y] </td>";
            }
        };
        echo "<td> 
				<form name=\"support_btn\" method=\"POST\">
                <button type=\"submit\" name=\"details\" value=\" $row[0]\"> View Details
							</form>";

        //admin.php will route here to use search.php to find projects to modify. This checks if the session requesting this page is mod-enabled or not and if so, //returns an additional button for moderators to use
        if($_SESSION["mod"] == true){
            echo "<button type=\"modify\" name=\"modify\" value=\" $row[0]\"> Modify";
        }

        $c = $c +1;
      }
      echo "</table>";

	      $check = true;
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
