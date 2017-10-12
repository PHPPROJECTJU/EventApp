<?php
  include("header.php");
  include("config.php");

  session_start();
  if (!isset($_SESSION['username'])) {
    header("login.php");
  }
?>

<!--<a href="index.php#" class="goback">&larr;</a>-->

<?php

$EventID = trim($_GET['EventID']);


    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.Title, Event.StartDate, Event.StartTime, Event.Information, Location.StreetAdress
              FROM User
              JOIN Event
              ON User.UserID=Event.UserID
              JOIN Location
              ON Event.LocationID=Location.LocationID
              WHERE Event.EventID=$EventID
              ";

    $stmt = $db->prepare($query);
    $stmt->bind_result($UserName, $ProfilePicture, $UserID, $Title, $StartDate, $StartTime, $Information, $StreetAdress);
    $stmt->execute();

  /* $gettag = "SELECT Tags.TagName
                 FROM Tags
                 JOIN GetTag
                 ON Tags.TagID=GetTag.TagID
                 JOIN Event
                 ON Event.EventID=GetTag.EventID
                 WHERE Event.EventID=$EventID
                 ";

    $stmt2 = $db->prepare($gettag);
    $stmt2->bind_result($TagName);
    $stmt2->execute();*/

#Here I'm sending us back to index page, the idea is to land on the heading of the same event






    while ($stmt->fetch()) {
        echo "<a href='index.php#". urlencode($UserID) ."' class='goback'>&larr;</a>";
        echo "<div class='eventpagebox'>";
        echo "<h3 class='profiletitle'>$Title</h3>";
        echo "<span class='pictureandname'>";
        echo "<img src='$ProfilePicture' class='profilepic'/>";
        echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
        echo "</span>";
        echo "<div class='specifics'>";
        echo "<p><img src='img/place.png' />$StreetAdress</p> <br />";
        echo "<p><img src='img/time.png' />$StartDate kl $StartTime</p>";
        echo "</div>";
        echo "<p class='description'>$Information</p>";
        echo "</div>";
    }

  /*  while ($stmt2->fetch()) {
        echo "$TagName";
    }*/

?>

<?php

echo "<h2 class='commentheader'>Comments</h2>";

?>

<?php
  include("footer.php");
?>
