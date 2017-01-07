<?php
require "init.php";
header('Content-Type: application/json');

//$userId = $_POST["user_id"];
$userId = "10";
$sql_query = "SELECT * FROM message_info WHERE received_user_id = '$userId' AND (status = '2' OR status = '3') AND DATE_FORMAT(message_time, '%y-%m-%d')  = CURDATE();";

$result = mysqli_query($con,$sql_query);
$num_of_rows = mysqli_num_rows($result);

$temp_array = array();

if($num_of_rows>0){
	while($row=mysqli_fetch_assoc($result)){
		$temp_array[] = $row;
	}
}

echo json_encode(array("pending_works"=>$temp_array));

?>
