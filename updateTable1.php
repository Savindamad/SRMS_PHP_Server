<?php
	$con = mysqli_connect("localhost", "root", "admin", "smart_rms") or die;
    header('Content-Type: application/json');

    $tableNum = $_POST["tableNum"];

	$sql_query = "update table_type set waiter_id='0' where table_no='$tableNum';";
	$result = mysqli_query($con,$sql_query);
	$num_of_rows = mysqli_num_rows($result);

	$sql_query1 = "update customer_order set status=3 where table_no = '$tableNum' and status != 9;";
	$result1 = mysqli_query($con,$sql_query1);
    $num_of_rows1 = mysqli_num_rows($result1);

    $json["success"]="true";
    echo json_encode($json);
?>
