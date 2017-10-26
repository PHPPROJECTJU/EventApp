<?php
  session_start();
  if (!isset($_SESSION['adminusername'])) {
    header("location:login.php");
  }
?>
<?php
  include("header.php");
  include("config.php");
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



    while ($stmt->fetch()) {
        echo "<a href='eventfeed.php#". urlencode($UserID) ."' class='goback'>&larr;</a>";
        echo "<a href='deleteevent.php?EventID=". urlencode($EventID) ."' id='deletebutton'>×</a><br />";
        echo "<div class='eventpagebox'>";
        echo "<h3 class='profiletitle'>$Title</h3>";
        echo "<span class='pictureandname'>";
        echo "<img src='../$ProfilePicture' class='profilepic'/>";
        echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
        echo "</span>";
        echo "<div class='specifics'>";
        echo "<p><img src='../img/place.png' />$StreetAdress</p> <br />";
        echo "<p><img src='../img/time.png' />$StartDate kl $StartTime</p>";
        echo "</div>";
        echo "<p class='description'>$Information</p>";
        echo "</div>";
    }


?>

<?php

echo "<h2 class='commentheader'>Comments</h2>";

?>

<?php
  include("footer.php");
?>
