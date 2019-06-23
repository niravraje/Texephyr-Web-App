<?php

include 'checklogin.php';
$id = $_POST['visit_id'];

$reset_vol_status = "UPDATE volunteer SET activity_status=0 WHERE visit_id =".$id;
$reset_vol_visit_id = "UPDATE volunteer SET visit_id=0 WHERE visit_id = $id";
$del_visit_table = "DELETE FROM visit WHERE visit_id =".$id;
$del_map_table = "DELETE FROM visit_volunteer_map WHERE visit_id =".$id;


mysqli_query($conn, $reset_vol_status);
mysqli_query($conn, $reset_vol_visit_id);
mysqli_query($conn, $del_map_table);
mysqli_query($conn, $del_visit_table);

//echo mysqli_connect_error();
header("Location:visits.php");

 ?>
