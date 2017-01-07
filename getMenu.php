<?php
require "init.php";
$sql_query = "select * from menu_item; ";

$result = mysqli_query($con,$sql_query);
$num_of_rows = mysqli_num_rows($result);

$temp_array = array();

if($num_of_rows>0){
	while($row=mysqli_fetch_assoc($result)){
		$temp_array[] = $row;
	}
}

header('Content-Type: application/json');
echo json_encode(array("menu_items"=>$temp_array));

?>
