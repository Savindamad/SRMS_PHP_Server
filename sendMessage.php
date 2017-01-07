<?php
	require "init.php";


	header('Content-Type: application/json');

	//$userID = $_POST["user_id"];
	//$message = $_POST["message"];
	//$tableNo = $_POST["table_no"];

	$userID = "6";
	$message = "Need a help";
	$tableNo = "0";
	
	$sql_query = "SELECT * FROM cleaner_status WHERE avalability = '1' and check_free = '1' ORDER BY RAND() LIMIT 0,1;";
	$result = mysqli_query($con,$sql_query);
	$num_Of_rows = mysqli_num_rows($result);

	if($num_Of_rows==1){
		$row=mysqli_fetch_assoc($result);
		$cleanerID = $row['user_id'];
		$token = $row['token'];
		$numWorks = $row['num_of_works'];
		$numWorks = $numWorks+1;

		//query for update cleaner status
		$sql_query3 = "UPDATE cleaner_status SET num_of_works = '$numWorks', check_free = '0' WHERE user_id = '$cleanerID';";
		$result3 = mysqli_query($con,$sql_query3);

		//get sender username
		$sql_query6 = "SELECT f_name, l_name FROM user_account WHERE user_id = '$userID';";
		$result6 = mysqli_query($con,$sql_query6);
		$row6 = mysqli_fetch_assoc($result6);
		$sendUserName = $row6["f_name"]." ".$row6["l_name"];

		//get receivers username
		$sql_query7 = "SELECT f_name, l_name FROM user_account WHERE user_id = '$cleanerID';";
		$result7 = mysqli_query($con,$sql_query7);
		$row7 = mysqli_fetch_assoc($result7);
		$receivedUserName = $row7["f_name"]." ".$row7["l_name"];

		//query for update message
		$sql_query4 = "INSERT INTO message_info (message, sent_user_id, sent_user_name, recieved_user_id, received_user_name, table_no) VALUES ('$message', '$userID', '$sendUserName', '$cleanerID', '$receivedUserName', '$tableNo');";
		$result4 = mysqli_query($con,$sql_query4);

		$title1 = "Waiter ".$sendUserName." send you a message";
		send($title1,$message,$token);

		$json["message"]="Your message has been sent";
		echo json_encode($json);
	}
	else{
		$sql_query1 = "SELECT * FROM cleaner_status WHERE avalability = '1' ORDER BY RAND() LIMIT 0,1;";
		$result1 = mysqli_query($con,$sql_query1);
		$num_Of_rows1 = mysqli_num_rows($result1);
		if($num_Of_rows1==1){
			$row1 = mysqli_fetch_assoc($result1);
			$cleanerID = $row1['user_id'];
			$token = $row1['token'];
			$numWorks = $row1['num_of_works'];
			$numWorks = $numWorks+1;

			//query for update cleaner status
			$sql_query3 = "UPDATE cleaner_status SET num_of_works = '$numWorks', check_free = '0' WHERE user_id = '$cleanerID';";
			$result3 = mysqli_query($con,$sql_query3);

			//query for update message
			$sql_query4 = "INSERT INTO message_info (message, sent_user_id, recieved_user_id) VALUES ('$message', '$userID', '$cleanerID');";
			$result4 = mysqli_query($con,$sql_query4);

			$sql_query5 = "select f_name,l_name from user_account where user_id='$userID';";
			$result5 = mysqli_query($con,$sql_query5);
			$row5 = mysqli_fetch_assoc($result5);

			send("Waiter ".$row5['f_name']." send you a message",$message,$token);

			$json["message"]='There are not any free waiter, but your message is sent to availabale waiter';
			echo json_encode($json);
		}
		else{
			$json["message"]='There is not available waiter';
			echo json_encode($json);
		}
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