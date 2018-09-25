<!DOCTYPE html>
<html>
<head>
	<title>db connection</title>
</head>
<body>

<?php

	$server = "localhost";
	$port = "5432";
	$db_name = "CS2102";
	$user = "postgres";
	$password = "awzhikuan";

	$db = pg_pconnect("host=$server port=$port dbname=$db_name user=$user password=$password");
	//if($db) echo "db connected in dbconnect.php <br/>";

	//show error message
	ini_set("display_errors", "1");
	error_reporting(E_ALL);
?>

</body>
</html>
