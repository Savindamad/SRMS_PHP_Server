<?php
	$con = mysqli_connect("localhost", "root", "admin", "smart_rms");
    header('Content-Type: application/json');

    $userID = $_POST["userID"];
    $tableNum = $_POST["tableNum"];

	$sql_query1 = "UPDATE dining_table SET status='0' WHERE table_no='$tableNum';";
        $result1 = mysqli_query($con,$sql_query1);

    $num_of_rows = mysqli_num_rows($result1);

    $json["success"]="true";
    echo json_encode($json);
?>
