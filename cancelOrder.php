<?php
	$con = mysqli_connect("localhost", "root", "admin", "smart_rms");
	header('Content-Type: application/json');
    $orderNum = $_POST["order_no"];
    //$orderNum = "1081";

	$sql_query = "SELECT status FROM customer_order where order_no='$orderNum';";
	$result = mysqli_query($con,$sql_query);

	if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        $status = $row["status"];
        if($status=="0"){
        	$sql_query1 = "UPDATE `customer_order` SET `status` = '5' WHERE `order_no` = '$orderNum';";
        	$result1 = mysqli_query($con,$sql_query1);
        	$json["status"] = "success";
        	echo json_encode($json);
        }
        else{
        	$json["status"] = "not success";
        	echo json_encode($json);
        }
    }
    else{
    	$json["status"] = "fail";
    	echo json_encode($json);
    }
?>
