<?php 

//Connection
	$hostname = "localhost";
	$username = "rohan_user";
	$password = "dbkapassword";
	$dbname = "tex17";

	$con = mysqli_connect($hostname, $username, $password, $dbname);
	if(!$con)
		die("Connection Failed: ".mysqli_connect_error());




//Check Login

	$username = $_POST['user_name'];
	$password = $_POST['password'];

	$query = "SELECT v_name, v_id, visit_id FROM volunteer WHERE v_email = '".$username."' AND v_password = '".$password."' ";
	$result = mysqli_query($con, $query);	// Contains the array of all results mathching the query
	$row = mysqli_fetch_assoc($result);		// Fetch the first record from the entire result of query

	if( mysqli_num_rows($result) > 0 ){
		
		echo "1\n";

		echo $row['v_name'];
		echo "\n";
		
		echo $row['v_id'];
		echo "\n";
		
		echo $row['visit_id'];
		echo "\n";
		
		$get_colleges = "SELECT c_name FROM college";
		$res_colleges = mysqli_query($con, $get_colleges);

		if(mysqli_num_rows($res_colleges) > 0){
			while($row = mysqli_fetch_assoc($res_colleges)){
				echo $row['c_name'];
				echo "\n";
			}
		}
		echo "events\n";

		$get_events = "SELECT e_name, e_fees FROM event";
		$res_events = mysqli_query($con, $get_events);

		if(mysqli_num_rows($res_events)){
			while($row = mysqli_fetch_assoc($res_events)){
				echo $row['e_name'];
				echo "\n";
				echo $row['e_fees'];
				echo "\n";
			}
		}	
	}
	else
		echo "0";

?>
