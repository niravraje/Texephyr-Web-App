<?php 

	//Connection
	$hostname = "localhost";
	$username = "root";
	$password = "nirav@123";
	$dbname = "tex17";

	$con = mysqli_connect($hostname, $username, $password, $dbname);
	if(!$con)
		die("Connection Failed: ".mysqli_connect_error());

	//Registration
	$v_id = $_POST['v_id'];	
	$visit_id = $_POST['visit_id'];	
	$p_name = $_POST['name'];		
	$college_name = $_POST['college'];		//
	$event_name = $_POST['event'];		//
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$total = $_POST['total'];
	$paid = $_POST['paid'];
	$transactionId = $_POST['transactionId'];

	//Get college id
	$get_col_id = "SELECT c_id FROM college WHERE c_name ='".$college_name."'";
	$res_col_id = mysqli_query($con, $get_col_id);
	if(mysqli_num_rows($res_col_id) > 0){
		$row_col = mysqli_fetch_assoc($res_col_id);
		$col_id = $row_col['c_id'];
	}

	//Get event id
	$get_event_id = "SELECT e_id FROM event WHERE e_name = '".$event_name."'";
	$res_event_id = mysqli_query($con, $get_event_id);
	if(mysqli_num_rows($res_event_id) > 0){
		$row_event = mysqli_fetch_assoc($res_event_id);
		$event_id = $row_event['e_id'];
	}

	//Update partial payment status
	if($total != $paid)
		$partial_status = 1;
	else 
		$partial_status = 0;

	//Update date and time
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d', time());
	$time = date('H:i:s', time());

	//Insert into table
	$insert_participant = "INSERT INTO `registration`(`r_event_id`, `r_volunteer_id`, `r_visit_id`, `r_p_college_id`, `r_p_name`, `r_p_phone`, `r_fees`, `r_paid`, `r_partial_status`, `r_date`, `r_time`, `r_p_email`, `transaction_id`) VALUES ('$event_id', '$v_id', '$visit_id', '$col_id', '$p_name', '$phone', '$total', '$paid', '$partial_status', '$date', '$time', '$email', '$transactionId')";

	$res_insert = mysqli_query($con, $insert_participant);

	if($res_insert){

		echo "1";
		require_once("PHPMailer/PHPMailerAutoload.php");
		$mail = new PHPMailer();
		/*
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = "tls";
		$mail->Port     = 25;  
		$mail->Host     = "mail.texephyr.com";
		$mail->Mailer   = "smtp";
		*/
		$mail->Username = "registration@texephyr.com";
		$mail->Password = "registertex2017";
		
		$mail->From="registration@texephyr.com";
		$mail->FromName = "TEX 17";
		$mail->AddReplyTo("registration@texephyr.com", "TEX 17");
		$mail->AddAddress("rajenirav@gmail.com");

		$mail->WordWrap   = 80;
		$mail->IsHTML(true);
		$mail->Subject = "Registration Confirmation";
		$mail->Body = "<b>Your registration for X event has been confirmed.</b>";
		$mail->AltBody = "Plain text Version of email";
				
		$mail->send();

	}
	else
		echo mysqli_error($con);
		

 ?>
