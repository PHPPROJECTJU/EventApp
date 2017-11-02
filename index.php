<?php
  session_start();
?>

<?php
  include("config.php");
  include("header.php");
?>

<button onclick="goToTop()" id="topButton" title="Go to top">
    &uarr;
</button>

<div class="searchwrapper">
    <div class="searchwrapper_second">
        <img class="chooselocation" src="img/pin.png" title="Choose location">

        <form class="searcheventsform" action="index.php" method="POST">
              <input type="text" name="searchevent" class="searchbar" placeholder="Search events">
              <input type="submit" class="searchbutton" name="search" value="GO">
        </form>
    </div>
    <ul id='regionmenu'>
      <div class="liwrapper">
        <form name="chooseregion">
        <?php
            @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

            if ($db->connect_error) {
                echo "could not connect: " . $db->connect_error;
                printf("<br><a href=index.php>Return to home page </a>");
                exit();
            }

            $getregion = "SELECT State.state_id, State.state_name
                      FROM State
                      ";

            $stmt = $db->prepare($getregion);
            $stmt->bind_result($regionid, $showregion);
            $stmt->execute();

              while ($stmt->fetch()) {
                  echo "<input type='hidden' name='regionid' value=' . $regionid . '>";
                  echo "<a class='regionbuttons' href='index.php?regionid=" . urlencode($regionid) . "'><li>$showregion</li></a>";
              }
         ?>
       </form>
       </div>
     </ul>
</div>

<div id="browse">

  <?php

      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }


/*--Search function-----------------------------------------*/

if (isset($_POST['search']) && !empty($_POST['searchevent'])) {

    $searchphrase = htmlentities($_POST['searchevent']);

    $searchphrase = trim($searchphrase);

    $searchphrase = mysqli_real_escape_string($db, $searchphrase);

    $searchphrase = addslashes($searchphrase);


    $search = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, City.city_name
              FROM User
              JOIN Event
              ON User.UserID=Event.UserID
              JOIN City
              ON Event.city_id=City.city_id
              WHERE Title LIKE '%" . $searchphrase . "%'
              OR Information LIKE '%" . $searchphrase . "%'
              OR UserName LIKE '%" . $searchphrase . "%'
              ORDER BY Event.EventID DESC
              ";

          $stmt = $db->prepare($search);
          $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Title, $StartDate, $StartTime, $Information, $StreetAdress, $cityname);
          $stmt->execute();
} else {

/*--Getting stuff from database without searching-----------------------------------------*/

      $getevent = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, City.city_name
                FROM User
                JOIN Event
                ON User.UserID=Event.UserID
                JOIN City
                ON Event.city_id=City.city_id
                ORDER BY Event.EventID DESC
                ";

      $stmt = $db->prepare($getevent);
      $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Title, $StartDate, $StartTime, $Information, $StreetAdress, $cityname);
      $stmt->execute();



    } /*<--end of the if/else post isset statement*/

    while ($stmt->fetch()) {
        echo "<div class='box'>";
        echo "<a name='". urldecode($UserID) ."'><h3 class='profiletitle'>$Title</h3></a>";
        echo "<span class='pictureandname'>";
        echo "<img src='$ProfilePicture' class='profilepic'/>";
        echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
        echo "</span>";
        echo "<div class='specifics'>";
        echo "<p><img src='img/place-black.png' />$StreetAdress, $cityname</p> <br />";
        echo "<p><img src='img/time-black.png' />$StartDate kl $StartTime</p>";
        echo "</div>";
        echo "<p class='description'>$Information</p>";
        echo "<a class='seemore' href='event.php?EventID=" . urlencode($EventID) . " '>more...</a>";
        echo "</div>";
    }
  ?>

</div>



<script type="text/javascript" src="js/index.js"></script>

<?php

  include("footer.php");

?>
