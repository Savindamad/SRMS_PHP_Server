<?php
	$con = mysqli_connect("localhost", "root", "admin", "smart_rms");
	header('Content-Type: application/json');

	$user_id = $_POST["userId"];
	$table_no = $_POST["tableNum"];
	$order = $_POST["order"];

	$orderArray = json_decode($order, true);

	$sql_query = "INSERT INTO `customer_order` (`order_no`, `order_time`, `table_no`, `ordered_by`, `cust_name`, `status`) VALUES (NULL, CURRENT_TIMESTAMP, '$table_no', '$user_id', NULL, '0');";

	$result = mysqli_query($con,$sql_query);
	$sql_query1 = "select order_no from customer_order where order_no=(select MAX(order_no) from customer_order);";

	$result1 = mysqli_query($con,$sql_query1);
	$row=mysqli_fetch_assoc($result1);
	$order_no = $row["order_no"];
	

	foreach ($orderArray as $key => $value) {
		$itemId = $value["itemId"];
		$orderNo = $value["itemQty"];

		$sql_query2 = "INSERT INTO `order_item` (`order_item_id`, `item_id`, `order_no`, `quantity`) VALUES (NULL, '$itemId', '$order_no', '$orderNo');";
		$result2 = mysqli_query($con,$sql_query2);
  	}

    echo json_encode("success");
?>
