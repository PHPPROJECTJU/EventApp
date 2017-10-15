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
<div class="searchwrapper">
    <img class="chooselocation" src="img/pin.png">
    <form class="searchform" action="index.php" method="POST">
          <input type="text" name="searchevent" class="searchbar" placeholder="Search events">
          <input type="submit" class="searchbutton" name="submit" value="GO">
    </form>
</div>

<div id="browse">

  <?php

      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Title, Event.StartDate, Event.StartTime, Event.Information, Location.StreetAdress
                FROM User
                JOIN Event
                ON User.UserID=Event.UserID
                JOIN Location
                ON Event.LocationID=Location.LocationID
                ORDER BY Event.EventID DESC
                ";

      $stmt = $db->prepare($query);
      $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Title, $StartDate, $StartTime, $Information, $StreetAdress);
      $stmt->execute();

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

<?php
  include("footer.php");
?>
