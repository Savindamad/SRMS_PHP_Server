<?php
require "init.php";

header('Content-Type: application/json');

$username = $_POST["username"];
$password = $_POST["password"];

//$username = "waiter1";
//$password = "saman@123";
$password_en = md5($password);

$sql_query = "select user_id,f_name,l_name,user_type from user_account where username='$username' and password='$password_en';";
$result = mysqli_query($con,$sql_query);
$num_of_rows = mysqli_num_rows($result);

if($num_of_rows>0){
	$row=mysqli_fetch_assoc($result);
	echo json_encode($row);
}
else{
	$json["fail"]='login fail';
	echo json_encode($json);
}

?>
