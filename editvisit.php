<?php
  include 'checklogin.php';
  function getName($table,$param,$value,$conn,$req) {
  $select = "select * from $table where $param = $value ";
  $result = mysqli_query($conn,$select);
  $row = mysqli_fetch_array($result);
  $name =  $row["$req"];
  //echo $name;
  if(mysqli_num_rows($result)>0)
  {
    return $name;
  }
  else {
    return 0;
  }
}
  $id = $_POST['visit_id'];


  $select = "SELECT * FROM visit WHERE visit_id = $id ";
  $result = mysqli_query($conn,$select);
  $row = mysqli_fetch_array($result);

//Event Details retrieved
  $visit_id = $row['visit_id'];
  $date_in = $row['date_in'];
  $date_out = $row['date_out'];
  $time_in = $row['time_in'];
  $time_out = $row['time_out'];
  $college = getName("college","c_id",$row['college_id'],$conn,"c_name"); //table, para, value, conn, name
  $comments = $row['comments'];
  $pr_name = getName("login","login_id",$row['pr_id'],$conn,"login_username");
  $cash_recieved = $row['cash_recieved'];
  $cash_to_be_received = $row['cash_to_be_received'];


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Visit</title>
    <meta name="description" content="">
    <meta name="author" content="templatemo">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
          <div class="row">
            <nav class="templatemo-top-nav col-lg-12 col-md-12">
                <h1>Edit Visit</h1>
            </nav>
          </div>
        </div>
        <div class="templatemo-content-container">
          <div class="templatemo-content-widget white-bg">
            <h2 class="margin-bottom-10">Edit Visit details</h2>
            <form action="modifyvisit.php" class="templatemo-login-form" method="post" enctype="multipart/form-data">

              <input type ="hidden" value="<?php echo $visit_id; ?>" name="id">
              
              <div class="row form-group">
                  <div class="col-lg-6 col-md-6 form-group">
                      <label for="inputEvent">Visit ID</label>
  					          <input type="text" name="visit_id" value = "<?php echo $visit_id;?>" class="form-control" disabled>
                  </div>

                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputBusNum">College</label>
          					<select name="college" class="form-control">
          					<?php
          					$sp_query = "SELECT * FROM college";
          					$sp_res = mysqli_query($conn,$sp_query);
          					if(mysqli_num_rows($sp_res)<=0)
          					{
          						?>
          						<option value="0">No Option Available</option>
          					<?php
          					}
          					else
          					{

          						while($dept = mysqli_fetch_array($sp_res))
          						{
                        

          						?>
          						<option value="<?php echo $dept['c_id'];?>" > <?php echo $dept['c_name'];?> </option>
          						<?php

          						}
          					}
          					?>
          				</select>
                          </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputEvent">Date out</label>
                    <input type="date" name="date_out"   value ="<?php echo $date_out;?>" class="form-control">
                </div>
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputEvent">Date in</label>
                    <input type="date" name="date_in"   value ="<?php echo $date_in;?>" class="form-control">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputEvent">Time out</label>
                    <input type="time" name="time_out"   value ="<?php echo $time_out;?>" class="form-control">
                </div>
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputEvent">Time in</label>
                    <input type="time" name="time_in"   value ="<?php echo $time_in;?>" class="form-control">
                </div>
            </div>

			  <div class="row form-group">
		          <div class="col-lg-6 col-md-6 form-group">
		              <label for="inputSport">Cash to be received</label> <br>
		              <input type="number" class="form-control"  value ="<?php echo $cash_to_be_received;?>" disabled />
		              <input type="hidden" name="cash_to_be_rec" value = "<?php echo $cash_to_be_received;?>" />
		          </div>
		          <div class="col-lg-6 col-md-6 form-group">
		              <label for="inputSport">Cash received</label> <br>
		              <input type="number" class="form-control" name="cash_rec" value ="<?php echo $cash_recieved;?>" />
		          </div>
      		  </div>

      		  <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
		              <label for="inputSport">Comments</label> <br>
		              <input type="text" class="form-control" name="comments" value ="<?php echo $comments;?>" />
		          </div>
            </div>
        <center><input type="submit" class="templatemo-blue-button"/>
        </div>

            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- JS -->
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>        <!-- jQuery -->
    <script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script>  <!-- http://markusslima.github.io/bootstrap-filestyle/ -->
    <script type="text/javascript" src="js/templatemo-script.js"></script>        <!-- Templatemo Script -->
  </body>
</html>
