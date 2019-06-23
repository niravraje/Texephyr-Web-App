<?php
	include 'checklogin.php';
	function php2Alert($msg) {
    echo '<script type="text/javascript">if (confirm("' . $msg . '")){document.location="volunteer.php"}else{document.location="volunteer.php"}</script>';
}

    $id = $_POST['id'];
	$college = $_POST['college'];
    $date_in = $_POST['date_in'];
  	$date_out = $_POST['date_out'];
  	$time_in = $_POST['time_in'];
  	$time_out = $_POST['time_out'];
    $comments = $_POST['comments'];
    $cash = $_POST['cash_rec'];
    $cash_expected = $_POST['cash_to_be_rec'];
    
    //echo $cash_expected;
	//$select_query="select * from visit_volunteer_map where visit_id=".$id;
	//$vol_result = mysqli_query($conn,$select_query);


	$activity_status=0;		//for visit as well as volunteer
	if(strtotime($date_in) == '')
		$activity_status=1;

	$full_cash_rec_status=1;
	$amount_pending	=0;	
	
	if($cash < $cash_expected){		//in case of incomplete cash reception
		$full_cash_rec_status=0;
		$amount_pending = $cash_expected - $cash;
	}
	//echo "<br>".$full_cash_rec_status."<br>".$amount_pending;

    $edit_query= "UPDATE visit SET visit_active_status = '$activity_status', college_id = '$college', date_in = '$date_in', date_out = '$date_out', time_in = '$time_in', time_out = '$time_out', comments = '$comments', cash_recieved = '$cash', full_cash_rec_status = '$full_cash_rec_status', amount_pending = '$amount_pending' WHERE visit_id = '$id'";

	mysqli_query($conn, $edit_query);
	//echo '<br>'.mysql_affected_rows().'<br>';
    //echo mysqli_connect_error($conn);

		if($activity_status == 0){

				$vol_update_status = "UPDATE volunteer SET activity_status=0, visit_id=0 WHERE visit_id=".$id;
				$vol_visit_res = mysqli_query($conn, $vol_update_status);
		}
		else{
			//echo 'activity_status is 1';
			$select_query="SELECT * FROM visit_volunteer_map WHERE visit_id=".$id;
			$vol_result = mysqli_query($conn,$select_query);
			while($row = mysqli_fetch_array($vol_result)){
				$vol_id = $row['volunteer_id'];
				$vol_update_status = "UPDATE volunteer SET activity_status = 1, visit_id=". $id ."WHERE v_id =". $vol_id;
				$vol_visit_res = mysqli_query($conn, $vol_update_status);
			}
		}
		//echo mysqli_connect_error();
    	mysqli_close($conn);
	  	header("Location:visits.php");
?>
