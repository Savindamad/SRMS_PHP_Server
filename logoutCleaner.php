<?php
	require "init.php";
	header('Content-Type: application/json');

	$userId = $_POST["user_id"];

	$sql_query = "UPDATE user_account SET token = '0' WHERE user_id = '$userId';";
	$result = mysqli_query($con,$sql_query);

	$sql_query1 ="UPDATE cleaner_status SET token = '0', avalability = '0', check_free = '0' WHERE user_id = '$userId';";
	$result1 = mysqli_query($con,$sql_query1);

	$json["success"]='logout';
	echo json_encode($json);

?>