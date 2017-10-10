<?php
  include("header.php");
  include("config.php");
?>

<!--<a href="index.php#" class="goback">&larr;</a>-->

<?php

$EventID = trim($_GET['EventID']);
echo '<INPUT type="hidden" name="bookid" value=' . $EventID . '>';

$EventID = trim($_GET['EventID']);      // From the hidden field
$EventID = addslashes($EventID);

echo $EventID;

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $query = "SELECT User.UserName, User.ProfilePicture, Event.Title, Event.StartDate, Event.StartTime, Event.Information, Location.StreetAdress
              FROM User
              JOIN Event
              ON User.UserID=Event.UserID
              JOIN Location
              ON Event.LocationID=Location.LocationID
              WHERE Event.EventID=$EventID
              ";


    $stmt = $db->prepare($query);
    $stmt->bind_result($UserName, $ProfilePicture, $Title, $StartDate, $StartTime, $Information, $StreetAdress);
    $stmt->execute();

#here I'm sending us back to index page, the idea is to land on the heading of the same event


echo "<a href='index.php#" . urlencode($Title) . "' class='goback'>&larr;</a>";

    while ($stmt->fetch()) {
        echo "<div class='eventpagebox'>";
        echo "<h3 class='profiletitle'>$Title</h3>";
        echo "<img src='$ProfilePicture' class='profilepic'/>";
        echo "<div class='specifics'>";
        echo "<p><img src='img/place.png' />$StreetAdress</p> <br />";
        echo "<p><img src='img/time.png' />$StartDate kl $StartTime</p>";
        echo "</div>";
        echo "<p class='description'>$Information</p>";
        echo "</div>";
    }


?>

<?php
  include("footer.php");
?>
