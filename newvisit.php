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

  $pr_id = $_SESSION['pr_id'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Visit</title>
    <meta name="description" content="">
    <meta name="author" content="templatemo">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-style.css" rel="stylesheet">
    <link href="css/form-style.css" rel="stylesheet">


    <script type="text/javascript">

      //Increment volunteer count and add volunteer dropdown box
      function incrCount(){
        document.form1.vol_count.value = parseInt(document.form1.vol_count.value) + 1;
        addVol();
      }

      //Decrement volunteer count and remove volunteer dropdown box
      function decCount(){
        document.form1.vol_count.value = parseInt(document.form1.vol_count.value) - 1;
        removeVol();
      }

      var i=1;

      //Add volunteer dropdown box
      function addVol(){
        i++;
        var select = document.getElementById("volunteer");
        var cln = select.cloneNode(true);
        cln.setAttribute("name","volunteer"+ i);
        
        var parent = document.getElementById("parent_vol_id");
        parent.appendChild(cln);
      }

      //Remove volunteer dropdown box
      function removeVol(){
        var parent = document.getElementById("parent_vol_id");
        parent.removeChild(parent.lastChild);
      }

    </script>
  </head>


  <body>
      <div class="templatemo-content col-1 light-gray-bg">

        <div class="templatemo-top-nav-container">
          <div class="row">
            <nav class="templatemo-top-nav col-lg-12 col-md-12">
                <h1>Add Visit</h1>
            </nav>
          </div>
        </div>


        <div class="templatemo-content-container">
          <div class="templatemo-content-widget white-bg">
            <h2 class="margin-bottom-10">Add Visit details</h2>

            <form name="form1" action="registervisit.php" class="templatemo-login-form" method="post" enctype="multipart/form-data">

            <!-- PR ID from session login -->
            <input type="hidden" value="<?php echo $pr_id; ?>" name="pr_id" >

            <!-- Choose College -->
            <div class="row form-group">
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


            <!-- Add Volunteers (dynamic) -->

            <input type="hidden" name="vol_count" id="vol_count" value="1"> <!-- JS to increment value -->

            <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <button class="templatemo-blue-button" type="button" id="add_volunteer_id" onclick="incrCount();">
                      Add Volunteer
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="templatemo-blue-button" type="button" id="remove_volunteer_id" onclick="decCount();">
                      Remove Volunteer
                    </button>
                  </div>
            </div>


            
            <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputBusNum">Volunteers</label>
                    <div id="parent_vol_id">
                    <select name="volunteer1" id="volunteer" class="form-control" >
                    <?php
                    $sp_query = "SELECT * FROM volunteer WHERE activity_status = 0";
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
                      <option value="<?php echo $dept['v_id'];?>" > <?php echo $dept['v_name'];?> </option>
                      <?php

                      }
                    }
                    ?>
                  </select>
                  </div>

                  
                </div>

            

            
            </div>

            <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputEvent">Date out</label>
                    <input type="date" name="date_out"   value ="" class="form-control" >
                </div>

            </div>

            <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputEvent">Time out</label>
                    <input type="time" name="time_out"   value ="" class="form-control" >
                </div>
            </div>

            <div class="row form-group">
                <div class="col-lg-6 col-md-6 form-group">
                    <label for="inputSport">Comments</label> <br>
                    <input type="text" class="form-control" name="comments"  value ="" required />
                </div>
            </div>



            <div class="form-group text-">
                <input type="submit" class="templatemo-blue-button"></input>
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
