<?php
  include ("connection.php");
 ?>


<!DOCTYPE html>
<html>
<head>
<title>Dropdown ajax</title>
<script type="text/javascript" src="jquery.min.js"></script>
</head>
<style type="text/css">
  .region, .city{
    margin: 20px;
    text-align: center;
  }
</style>

<body>
    <div class="region">
        <label>Region</label>
        <select name="region" onchange="getId(this.value);">
            <option value="">Select country</option>
            <?php
            function getregions(){

                include ("connection.php");
                @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

                if ($db->connect_error) {
                    echo "could not connect: " . $db->connect_error;
                    printf("<br><a href=index.php>Return to home page </a>");
                    exit();
                }

                $getregion = "SELECT State.state_id, State.state_name
                          FROM State
                          ";

                $stmt3 = $db->prepare($getregion);
                $stmt3->bind_result($regionid, $showregion);
                $stmt3->execute();

                while ($stmt3->fetch()) {
                      echo "<option value='$regionid'>$showregion</option>";
                }
              };
              getregions();
             ?>
        </select>
    </div>




    <script>
        function getId(val){
          console.log(val)
          //$theID = alert(hej);
          $.ajax({
              type: "POST",
               url: "getdata2.php",
               data: "state_id="+val,
               success: function(data){
              $("#cityList").html(data);
               }
          });
        }

    </script>

    <div class="city">
        <label>City</label>
        <select name="city" id="cityList">

            <?php
            include ("getdata2.php");
            getcity(val);

            ?>

        </select>
    </div>


</body>

</html>
