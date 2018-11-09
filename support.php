<!DOCTYPE html>
<html>
<head>
	<title>Support Project</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="display.css"/>
</head>
<body>

<h1>Project Details</h1>



<?php
error_reporting(E_ERROR | E_PARSE);
	include('dbconnect.php');
	session_start();
	$id = $_SESSION["id"];

	$sql = "SELECT * FROM project WHERE id = '$id'";
	$result = pg_query($db, $sql);





	///boolean.check that the user viewing this is the admin or owner.
?>
<table border ="1">
	<tr><td>Project Title:</td>
		<td><?php
			$title = pg_fetch_result($result, 0, 3); //fetch ($resource, row, col) from the database
			echo "$title";
		?></td>
		<td><form name="Support" action="support.php" method="POST">
	<li>Enter an amount:
	<input type="number" name ="amount"> </li>
	<input type="submit" value="I agree to support this amount" name="support" >
	<input type="submit" value="Back" name="back_btn" >
    </form></td> <!-- echo edit and delete button if owner/admin is the  -->

	<tr><td>Description:</td>
		<td><?php
			$desc = pg_fetch_result($result, 0, 4);
			echo "$desc";
		?></td>

	<tr><td>Target Amount:</td>
		<td><?php
			$target = pg_fetch_result($result, 0, 2);
			echo "$target";
		?></td>

		<td>Current Amount:</td>
		<td><?php
			$curr = pg_fetch_result($result, 0, 1);
			echo "$curr";
		?></td>

	<tr><td>Start Date:</td>
		<td><?php
			$start = pg_fetch_result($result, 0, 5);
			echo "$start";
		?></td>

		<td>Start Date:</td>
		<td><?php
			$end = pg_fetch_result($result, 0, 6);
			echo "$end";
		?></td>


<?php

    if(isset($_POST['back_btn'])){
           header("Location: search.php");
        }

        if(isset($_POST['support'])){
           $amount = $_POST['amount'];
           if($amount == "" || $amount <= 0){
                echo "Please key in a valid amount!";
								throw new Exception('process_z failed');
           }
           $email = $_SESSION["user_email"];
           $id = $_SESSION["id"];
           echo "Amount supported:"; echo "$amount";
			$sql = "UPDATE project SET curr$ = curr$ + $amount WHERE id = '$id'";
			$result = pg_query($db, $sql); // the result of the query
			
		   	// calculate row
			$sql3 = "SELECT email From support Where email = '$email'AND id = '$id'";
			$result3 = pg_query($db,$sql3);
			$col = pg_num_fields($result3);

		   // Supporting first time
			$sql2 = "INSERT INTO support (email, id, amt_supported) VALUES('".$email."', '".$id."', '".$amount."')";
			//$result2 = pg_query($db, $sql2); // the result of the second query
			$sql4 = "UPDATE support set amt_supported = amt_supported +$amount where id = '$id'";

			//check to see if its first time supporting
			if($col == 1){
				$result5 = pg_query($db,$sql4);
			}else{ // first time
				$result5 = pg_query($db,$sql2);
			}


            if($result && $result5){
                echo ". Thank you for your contribution!";
			}else{
                echo "Something went wrong, please try again!";
            }

        }
?>

</body>
</html>
