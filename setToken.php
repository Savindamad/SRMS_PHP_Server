<?php
require "init.php";

header('Content-Type: application/json');


$userId = $_POST["userId"];
$token = $_POST["token"];


$sql_query = "UPDATE user_account SET token = '$token' WHERE user_id = '$userId';";
$result = mysqli_query($con,$sql_query);

$sql_query1 = "SELECT user_type FROM user_account WHERE user_id = '$userId';";
$result1 = mysqli_query($con,$sql_query1);
$row1 = mysqli_fetch_assoc($result1);

if($row1['user_type']=="CLEANER"){
	$sql_query2 ="UPDATE cleaner_status SET token = '$token', avalability = '1', check_free = '1' WHERE user_id = '$userId';";
	$result2 = mysqli_query($con,$sql_query2);
}


?>