<!DOCTYPE html>
  <html>
    <head>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    	<title>Successful Funded Projects</title>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<link rel="stylesheet" type="text/css" href="display.css"/>
    </head>
    <body>

    <h1>Successful Funded Projects</h1>
    <h3>List of projects that have been successfully funded</h3>

    <form name="search" action="success_project.php" method="POST">
      <input type="submit" value="Done with this page? Go Back" name="back_btn">
    </form>
    <br>

  <?php
      include('dbconnect.php');
      session_start();

      $sql = "SELECT DISTINCT p.id, p.title, p.description, p.curr$, p.total$, p.own
              FROM project p
              WHERE p.curr$ >= p.total$";
      $result = pg_query($db, $sql); // the result of the query
      $col = pg_num_fields($result); // the number of column

      //print table headers
      echo '<table border = "1"><tr>'; //html code for the table
      echo "<th>S/N</th>";
      for($x = 1; $x < $col; $x++) { //for loop to print the table headings, starts at 1 to skip id
          //if($x == 0)
          $fieldName = pg_field_name($result, $x); //$result as an array, $x as index
          echo "<th>".$fieldName."</th>";
      }

      $c = 1; // c as a counter to loop through, and index of each row
      while ($row = pg_fetch_row($result)){ //$row is an array of each row of data

        echo "<tr>"; //html for new row, for data
        echo"<td>$c</td>";
        for($y = 1; $y < $col; $y++){ // starts at 1 to skip id
            echo "<td> $row[$y] </td>";
        };

        $c = $c +1;
      }
      echo "</table>";

      if(isset($_POST['back_btn'])){
        //reroute back to the correct page since admin is sharing usage of this page as well
        header("Location: search.php");
      }
    ?>

  </body>
</html>
