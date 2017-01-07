<?php
	require "init.php";
	header('Content-Type: application/json');


	$status = $_POST["status"];
	$messageId = $_POST["message_id"];
	$sentUserId = $_POST["sent_user_id"];
	$receivedUserName = $_POST["received_user_name"];

	$statusNo = "1";
	if($status == "decline"){
		$statusNo = "2";
	}
	else if ($status == "finish"){
		$statusNo = "3";
	}

	$sql_query = "UPDATE message_info SET status = '$statusNo' WHERE id = '$messageId';";
	$result = mysqli_query($con,$sql_query);

	$sql_query1 = "SELECT token FROM user_account WHERE user_id = '$sentUserId';";
	$result = mysqli_query($con,$sql_query);
	$row = mysqli_fetch_assoc($result);
	$token = $row["token"];

	if($status == "accept"){
		send("Your request is accepted","Your request is accepted by $receivedUserName",$token);
	}


	function send($title,$message,$token){

		$path_to_fcm = "https://fcm.googleapis.com/fcm/send";
		$server_key = "AAAAyr0dnGI:APA91bHgA3nLeGcPXFtJs4Gr6e-Q4L59lc6nWq-AXfgLhupncQG_YzmfBUA70oSeA_z_X5dMsfSXz4DNgGvLOosWhrVdyjrxJpge89nrN6sbEq3jjmWoNW_N4w40wjbjVos-LFvAEMXUwK0QTn8Y2lke1lRhFY_v4w";
		$header = array(
						'Authorization:key='.$server_key,
						'Content-Type:application/json'
				);
		$fields = array(
						'to'=>$token,
						'notification'=>array('title'=>$title,'body'=>$message)
				);
		$payload = json_encode($fields);
		$curl_session = curl_init();

		curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
		curl_setopt($curl_session, CURLOPT_POST, true);
		curl_setopt($curl_session, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);

		$result = curl_exec($curl_session);
		curl_close($curl_session);

	}

?>