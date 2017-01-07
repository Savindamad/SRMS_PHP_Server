<?php
	require "init.php";
	While(true){

		$query = "select * from customer_order where status='2';";
		$res = mysqli_query($con,$query);
		$num_of_rows = mysqli_num_rows($res);
		if($num_of_rows>0){
			while($row=mysqli_fetch_assoc($res)){

				$userId = $row["ordered_by"];
				$query2 = "select token from user_account where user_id = '$userId';";
				$res2 = mysqli_query($con,$query2);
				$row2 = mysqli_fetch_assoc($res2);
				$token = $row2["token"];

				if($token!="0"){
					$orderNo = $row["order_no"];
					$query1 = "UPDATE customer_order SET status = '3' WHERE order_no = '$orderNo';";
					$res1 = mysqli_query($con,$query1);

					$title = "Order ready";
					$message = "Table ".$row['table_no']." order is ready";

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
					echo "send notification\n";

				}
			}
		}

	}

?>