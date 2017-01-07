<?php
$con = mysqli_connect("localhost", "root", "admin", "smart_rms");

header('Content-Type: application/json');

$sql_query = "select * from dining_table;";

$result = mysqli_query($con,$sql_query);
$num_of_rows = mysqli_num_rows($result);

$temp_array = array();

if($num_of_rows>0){
	while($row=mysqli_fetch_assoc($result)){
		$temp_array[] = $row;
	}
}

echo json_encode(array("table_info"=>$temp_array));

?>