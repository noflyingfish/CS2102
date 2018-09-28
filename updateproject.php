<!DOCTYPE html>
<html>
<head>
	<title>Project Update</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<!--get variables from view MY project page-->
<h1>Crowd Funding</h1>
<h2>Project Update</h2>

  <!--display project id and title-->

	<form name="display" action="updateproject.php" method="POST" >
		title:<input type="text" name="new_title" />
    description:<input type="text" name="new_description" />
    Amount seeking ($):<input type="text" name="new_amt" />
    End date:<input type="text" name="new_date" />
    Project keywords:<input type="text" name="new_keyword" />
		<input type="submit" name="submit" />
	</form>

	<?php
		include('dbconnect.php');

		//getting variable from another php
	  //session_start();
		//$_SESSION['$project'];

		//get project row from view projects
    $project = <add in project row here>;
		//or die("Cannot execute query: $query\n");
		if($db) echo "db connected <br>" . $project . "<br>";

    //validate the input data
		if (isset($_POST['submit'])) {

			if(!isset($email) || trim($email) == '') {
				echo "<br>" . 'No email typed';
				throw new Exception('process_z failed');
			}
			else if($count_email <> 1) {
				echo "<br>" . 'Invalid email';
				throw new Exception('process_z failed');
			}

				echo "<ul><form name='update' action='updateproject.php' method='POST' >
				<li>title:</li>
				<li><input type='text' name='new_title' value='$row[title]' /></li>
				<li>description:</li>
				<li><input type='text' name='new_description' value='$row[description]' /></li>
        <li>Amount seeking ($):</li>
        <li><input type='text' name='new_amt' value='$row[total$]' /></li>
        <li>End date:</li>
        <li><input type='text' name='new_date' value='$row[end_date]' /></li>
        <li>Project keywords:</li>
        <li><input type='text' name='new_keyword' value='$row[project_keywords]' /></li>
				<li><input type='hidden' name='find_email' value='$email' /></li>
				<li><input type='submit' name='new' /></li>
			</form>
		</ul>";
		}

		if (isset($_POST['new'])) {	// Submit the update SQL command
			$title = $_POST['new_title'];
			$description = $_POST['new_description'];
      $amt = $_POST['new_amt'];
      $end_date = $_POST['new_date'];
      $keywords = $_POST['new_keyword'];
      $curr$ = <input current amount from query>;

			//below conditions checks all fills are filled
      if(count(array_filter($_POST))!=count($_POST)){
        echo "Something is empty";
        throw new Exception('process_z failed');
      }
      /* constraints should hav taken care of these cases
      else if($amt < $curr$) {
        echo "Amount seeking must be equal or larger than current amount collected!";
        throw new Exception('process_z failed');
      }
      else if($end_date < $curr$) {
        echo "";
        throw new Exception('process_z failed');
      }
      */

			$sql = "UPDATE users SET title = '$title', description = '$description',
      total$ = '$amt', end_date = '$end_date', project_keywords = '$keywords' WHERE id = '$id'";
			//echo $sql . "<br>";
			$result = pg_query($db, $sql);

			if($result) {
				echo 'Your project details are updated!';
			}
			else {
				echo 'Project was not updated.';
			}
		}
	?>

</body>
</html>
