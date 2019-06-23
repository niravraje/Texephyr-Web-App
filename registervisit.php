<?php
	include 'checklogin.php';
	function php2Alert($msg) {
	    echo '<script type="text/javascript">if (confirm("' . $msg . '")){document.location="volunteer.php"}else{document.location="volunteer.php"}</script>';
	}

	$pr_id = $_POST['pr_id'];
	$college_id = $_POST['college'];
	$date_out = $_POST['date_out'];
	$time_out = $_POST['time_out'];
	$comments = $_POST['comments'];

	$vol_count = $_POST['vol_count'];
	$activity_status = 1;

	$j=0;
	for($i=1; $i<=$vol_count; $i++){
		$v = 'volunteer'.$i;
		$vol_ids[$j] = $_POST[$v];
		$j++;
	}

	$add_visit_query = "INSERT INTO `visit`(`visit_id`,`date_out`, `time_out`, `college_id`, `comments`, `pr_id`) VALUES ('0','$date_out', '$time_out', '$college_id', '$comments', '$pr_id')";
	echo $add_visit_query ;

	$result = mysqli_query($conn,$add_visit_query);
	//if(!$result) echo mysqli_error($conn);

	$visit_id = mysqli_insert_id($conn);		//get last id

	//Insert into map table
	for($k=0; $k<$vol_count; $k++){

		$x = $vol_ids[$k];
		$vol_visit_add = "INSERT INTO `visit_volunteer_map`(`volunteer_id`, `visit_id`) VALUES ('$x', '$visit_id' )";
		$vol_visit_res = mysqli_query($conn, $vol_visit_add);

		
		$vol_update_status = "UPDATE volunteer SET activity_status=1, visit_id='".$visit_id."' WHERE v_id=".$x;
		$vol_visit_res = mysqli_query($conn, $vol_update_status);
		//if($vol_visit_res==false) echo mysqli_error($conn);
		
	
	}
	header("Location:visits.php");
	mysqli_close($conn); ?>
