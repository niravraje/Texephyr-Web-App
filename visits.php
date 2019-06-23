<?php

  include 'checklogin.php' ;
  function getName($table,$param,$value,$conn,$req) {
    $select = "select * from $table where $param = $value ";
    $result = mysqli_query($conn,$select);
    $row = mysqli_fetch_array($result);
    $name =  $row["$req"];
    //echo $name;
    if(mysqli_num_rows($result)>0){
      return $name;
    }
    else {
      return 0;
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visits</title>
    <meta name="description" content="">
    <meta name="author" content="templatemo">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">
  </head>


  <body>
  <!-- Left column (MENU PART) -->
  <div class="templatemo-flex-row">
    <div class="templatemo-sidebar">
      <header class="templatemo-site-header">
        <div class="square"></div>
        <h1>Texephyr '17</h1>
      </header>
      <div class="profile-photo-container">
        <!-- <img src="images/summit.png" alt="Profile Photo" class="img-responsive">  -->
        <div class="profile-photo-overlay"></div>
      </div>

      <div class="mobile-menu-icon">
        <i class="fa fa-bars"></i>
      </div>

      <nav class="templatemo-left-nav">
        <ul>
          <li><a href="analysis.php"><i class="fa fa-bolt fa-fw"></i>Analysis</a></li>
          <li><a href="volunteers.php" ><i class="fa fa-user fa-fw"></i>Volunteers</a></li>
          <li><a href="#" class="active"><i class="fa fa-motorcycle fa-fw"></i>Visits</a></li>
          <li><a href="registrations.php"><i class="fa fa-pencil-square fa-fw"></i>Registrations</a></li>
          <li><a href="events.php"><i class="fa fa-play fa-fw"></i>Events</a></li>
          <li><a href="colleges.php" class=""><i class="fa fa-university fa-fw"></i>Colleges</a></li>
          <li><a href="signout.php"><i class="fa fa-sign-out fa-fw"></i>Sign Out</a></li>
        </ul>
      </nav>
    </div>



      <!-- Main content -->
      <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
          <div class="row">
            <nav class="templatemo-top-nav col-lg-12 col-md-12">
              <h1>Visits</h1><br>
              <div class="templatemo-content-container">
                <div class="templatemo-flex-row flex-content-row">
                  <form class="templatemo-search-form" action="" method='post'>
                    <div class="input-group">

                      <!-- SEARCH BOX -->
                      <input type="text" class="form-control" placeholder="Search" name="searchterm" id="srch-term">
                      <br><br>
                      <center><input type="submit" name="submit_search" class="templatemo-blue-button"></input></center>

                    </div>
                  </form>
                </div>
              </div>
            </nav>

              <nav class="templatemo-top-nav col-lg-12 col-md-12">
                  <ul class="text-uppercase">
                  <li><a class="userd_signup" href="newvisit.php">Add</a></li>
                </ul>
              </nav>

              </div>
          </div>

<!-- Search Visits -->

<?php



  if(isset($_POST['submit_search'])){

    $searchterm = $_POST["searchterm"];
    
    $select = "SELECT * FROM visit v WHERE v.college_id = (SELECT c.c_id FROM college c WHERE c.c_name LIKE '%".$searchterm."%')";
  }
  else{
    $select = "SELECT * FROM visit ORDER BY visit_id DESC";
  }

  $result = mysqli_query($conn,$select);

  if(mysqli_num_rows($result) <= 0)
  {
?>
      <div class="templatemo-content-widget white-bg col-2" >
        <i class="fa fa-times"></i>
          <div class="square"></div>
          <h2 class="templatemo-inline-block">No Results Found</h2>
      </div>

<?php

  }
  else
  {
    while($row = mysqli_fetch_array($result))
    {

    	$visit_id = $row['visit_id'];
      $date_in = $row['date_in'];
      $date_out = $row['date_out'];
      $time_in = $row['time_in'];
      $time_out = $row['time_out'];
      $comments = $row['comments'];
      $college = getName("college","c_id",$row['college_id'],$conn,"c_name");
      $pr_name = getName("login","login_id",$row['pr_id'],$conn,"login_username");
      $cash_recieved = $row['cash_recieved'];

      $amount_pending = $row['amount_pending'];
      $full_cash_rec_status = $row['full_cash_rec_status'];
      $visit_active_status = $row['visit_active_status'];

      $volunteers = array();
      $select_volunteers = "SELECT * FROM visit_volunteer_map WHERE visit_id=".$visit_id;
      $result_volunteers = mysqli_query($conn,$select_volunteers);

      //Store the names of the volunteers in $volunteers array
      while($row_volunteers = mysqli_fetch_array($result_volunteers)){
        array_push($volunteers, getName("volunteer","v_id",$row_volunteers['volunteer_id'],$conn,"v_name"));
      }

?>

          <div class="templatemo-content-widget white-bg col-2" >
      <form action="editvisit.php" method="post">
              <i class="fa fa-times"></i>
              <div class="square"></div>
              <h2 class="templatemo-inline-block"><?php echo "Visit ID:&nbsp;&nbsp;&nbsp;".  $visit_id ?></h2><br><br>
              
              <center>
                <h2 class="templatemo-inline-block">
                  <?php 
                    if($visit_active_status==0)
                      echo "Visit Status:&nbsp;&nbsp;&nbsp;Complete";
                    else
                      echo "Visit Status:&nbsp;&nbsp;&nbsp;Ongoing";
                  ?>
                  
                </h2>
              </center><br>
<?php 
    if($visit_active_status==0 && $full_cash_rec_status==0){
      ?>
        <center><h2 class="templatemo-inline-block"><?php echo "<font color=\"red\"><b>Incomplete Payment Received</b></font>" ?></h2></center><br>
        <center><h3 class="templatemo-inline-block"><?php echo "<font color=\"red\"><b>Amount Pending:</b> &nbsp;&nbsp;'$amount_pending'</font>" ?></h2></center><br>
      <?php
    }
 ?>
 
              
         <center><h1><?php echo $college ?></h1></center>
               <br>
                <center><h3><?php echo "Period: ".$date_out." ".$time_out." to ".$date_in." ".$time_in ?></h3></center><br>
                <br><br>
                  <center><h3><?php echo "Comments: ".$comments ?></h3></center><br>
         <center><h2>
           <?php  echo "Volunteers"?><br><br>
           <?php foreach ($volunteers as $each_volunteer) {
                   echo $each_volunteer;
                   echo "<br>";
                 }
         ?></h2></center><br><br>
        <center> <h3>PR:<?php echo $pr_name; ?></h3>
          <h3>Cash_recieved: <?php echo $cash_recieved; ?></h3>
          <br>
           <input type="hidden" name="visit_id" value="<?php echo $visit_id;?>"</input>
          <input type="submit" class="templatemo-blue-button" value="  Edit   " name="s"></input><br><br>
        </form>
        <form action="deletevisit.php" method="POST">
          <input type="hidden" name="visit_id" value="<?php echo $visit_id;?>" </input>
          <input type="submit" class="templatemo-blue-button" value="Delete" name="delete"></input>
        </form>
        </center>
        </div>
<?php
    }
  }
?>

 <!-- JS -->
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>  
    <script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script> 
    <script type="text/javascript" src="js/templatemo-script.js"></script> 
</body>
</html>

<?php mysqli_close($conn); ?>
