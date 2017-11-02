<?php
  include_once ("connection.php");

  if(!empty($_POST["state_id"])){
    $state_id = $_POST["state_id"];
    
    include ("config.php");
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $getcityname = "SELECT City.city_name, City.city_id
              FROM City
              WHERE city_state_id = $state_id
              ";

    $stmt4 = $db->prepare($getcityname);
    $stmt4->bind_result($showcityname, $cityid);
    $stmt4->execute();

    while ($stmt4->fetch()) {
          echo "<option value='$cityid'>$showcityname</option>";
    }
  }
 ?>
