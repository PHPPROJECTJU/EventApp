<?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header("location:login.php");
  }
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
        <img class="chooselocation" src="img/pin.png">

        <form class="searcheventsform" action="index.php" method="POST">
              <input type="text" name="searchevent" class="searchbar" placeholder="Search events">
              <input type="submit" class="searchbutton" name="submit" value="GO">
        </form>
    </div>
    <ul id='regionmenu'>
      <div class="liwrapper">
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
                  echo "<li><a class='regionbuttons' href='index.php?regionid=" . urlencode($regionid) . "'>$showregion</a></li>";

              }
         ?>
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

if (isset($_POST) && !empty($_POST)) {

    $searchphrase = htmlentities($_POST['searchevent']);

    $searchphrase = trim($searchphrase);

    $searchphrase = mysqli_real_escape_string($db, $searchphrase);

    $searchphrase = addslashes($searchphrase);


    $search = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Title, Event.StartDate, Event.StartTime, Event.Information, Location.StreetAdress
              FROM User
              JOIN Event
              ON User.UserID=Event.UserID
              JOIN Location
              ON Event.LocationID=Location.LocationID
              WHERE Title LIKE '%" . $searchphrase . "%'
              OR Information LIKE '%" . $searchphrase . "%'
              OR UserName LIKE '%" . $searchphrase . "%'
              ORDER BY Event.EventID DESC
              ";

          $stmt = $db->prepare($search);
          $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Title, $StartDate, $StartTime, $Information, $StreetAdress);
          $stmt->execute();
} else {

/*--Getting stuff from database without searching-----------------------------------------*/

      $getevent = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Title, Event.StartDate, Event.StartTime, Event.Information, Location.StreetAdress
                FROM User
                JOIN Event
                ON User.UserID=Event.UserID
                JOIN Location
                ON Event.LocationID=Location.LocationID
                ORDER BY Event.EventID DESC
                ";

      $stmt = $db->prepare($getevent);
      $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Title, $StartDate, $StartTime, $Information, $StreetAdress);
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
        echo "<p><img src='img/place.png' />$StreetAdress</p> <br />";
        echo "<p><img src='img/time.png' />$StartDate kl $StartTime</p>";
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
