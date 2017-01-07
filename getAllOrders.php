<?php
	$con = mysqli_connect("localhost", "root", "admin", "smart_rms");
	header('Content-Type: application/json');

	//$tableNum = $_POST["table_no"];
	//$tableNum = "2";
	//status
	//0-ordered
	//1-accept
	//2-finish
	//3-deliverd
	//4-order finish
	//5-cancel order

	$sql_query = "select * from customer_order where table_no='2' and (status='0' or status='1');";
	$result = mysqli_query($con,$sql_query);

	$num_of_rows = mysqli_num_rows($result);


	$temp_array = array();

    if($num_of_rows>0){
		while($row=mysqli_fetch_assoc($result)){
			$temp_array1 = array();
		
			$orderId=$row["order_no"];
			$status=$row["status"];
			$temp_array1["status"]=$status;

			$sql_query1 = "select * from order_item where order_no='$orderId';";
			$result1 = mysqli_query($con,$sql_query1);

			$temp_array2 = array();
			while($row1=mysqli_fetch_assoc($result1)){
				$temp_array2[] = $row1;
			}
			$temp_array1["order"] = $temp_array2;
			$temp_array[]=$temp_array1;
		}
		echo json_encode(array("orders"=>$temp_array));
	}
    else{
        $json["fail"]='fail';
        echo json_encode($json);
    }



?>
