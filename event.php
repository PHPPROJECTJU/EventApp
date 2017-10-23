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

?>

<!--Comment form---------->

<h2 class='commentheader'>Comments</h2>

<form action="" method="POST">

  <textarea name="commentfield"></textarea>
  <div id="logoutbox">
    <div id="logoutbuttonwrap">
      <input type="submit" name="postcomment" class="loginbutton" />
    </div>
  </div>

</form>

<!--Comments---------->

<?php

function postComment($comment) {
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }


  $myusername = $_SESSION['username'];
  $EventID = trim($_GET['EventID']);


    $comment = htmlentities($_POST['commentfield']);
    $comment = mysqli_real_escape_string($db, $comment);

    $commentquery = ("INSERT INTO Comments (Text, EventID, UserName)
                  VALUES ('{$comment}', '{$EventID}', '{$myusername}')
                  ");

    $stmt = $db->prepare($commentquery);
    $stmt->execute();

    $query = ("SELECT Comments.Text, Comments.UserName, User.ProfilePicture
              FROM Comments
              JOIN User
              ON Comments.UserName=User.UserName
              WHERE EventID=$EventID
              ");
    $stmt2 = $db->prepare($query);
    $stmt2->bind_result($Text, $Commenter, $Profilepic);
    $stmt2->execute();


    while ($stmt2->fetch()) {
        echo "<div class='eventpagebox'>";
        echo $Commenter . " said:";
        echo  " " . $Text;
        echo "</div>";
    }
}

if (isset($_POST['postcomment']) && !empty($_POST['postcomment']) ) {
  postComment($_POST['commentfield']);
}


?>


<?php
  include("footer.php");
?>
