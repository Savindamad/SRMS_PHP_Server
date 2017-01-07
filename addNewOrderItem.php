<?php

$con = mysqli_connect("localhost", "root", "admin", "smart_rms");
header('Content-Type: application/json');

$json = json_decode(file_get_contents("php://input"), true);
$json1 = $json['order'];
$table_no = $json['table_no'];
$user_id = $json['user_id'];


$arraySize = count($json1);


for($i=0; $i<$arraySize; $i++){
	$item_code = $json1[$i]["item_code"];
	$item_qty = $json1[$i]["item_qty"];
	$order_id = $json1[$i]["order_id"];
	$sql_query = "insert into order_item (item_id,order_no,quantity) values ('$item_code','$order_id','$item_qty');";
	$result = mysqli_query($con,$sql_query);
}


//$sql_query1 = "select order_no from customer_order where table_no = '$table_no' and accepted != 4;";
$sql_query1 = "select order_no from customer_order where table_no = '$table_no' and status != 3;";

$result1 = mysqli_query($con,$sql_query1);
$num_of_rows = mysqli_num_rows($result1);
$temp_array = array();

$arr = array(
	array(
    	array(
        "order_no" => "None",
        "item_id" => "None"
    	)
    )
);


if($num_of_rows>0){
	while($row=mysqli_fetch_assoc($result1)){
		$temp_array1 = array();
		$orderNo = $row['order_no'];
		$sql_query2 =  "select * from order_item where order_no = '$orderNo';";
		$result2 = mysqli_query($con,$sql_query2);
		$num_of_rows1 = mysqli_num_rows($result2);
		if($num_of_rows1>0){
			while($row1=mysqli_fetch_assoc($result2)){
				$temp_array1[] = $row1;
			}
			$temp_array[] = $temp_array1;
		}
	}
	echo json_encode(array("orders"=>$temp_array));
}
else{
	echo json_encode(array("orders"=>$arr));
}

//	echo json_encode(array("order"=>$json);




?>
