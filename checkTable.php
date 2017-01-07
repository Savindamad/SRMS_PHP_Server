<?php
	$con = mysqli_connect("localhost", "root", "admin", "smart_rms");
	header('Content-Type: application/json');


    $tableNum = $_POST["tableNum"];
    $userID = $_POST["userID"];

    //$tableNum = "2";
    //$userID = "3";

    //$tableNum = "1";


	$sql_query = "select * from dining_table where table_no='$tableNum';";
	$result = mysqli_query($con,$sql_query);
    $num_of_rows = mysqli_num_rows($result);


    if($num_of_rows>0){
        $row=mysqli_fetch_assoc($result);

        $sql_query1 = "UPDATE dining_table SET status='$userID' WHERE table_no='$tableNum';";
        $result1 = mysqli_query($con,$sql_query1);
        echo json_encode($row);
    }
    else{
        $json["fail"]='fail';
        echo json_encode($json);
    }

?>
