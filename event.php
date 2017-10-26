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

function displayEvent(){
  include("config.php");


  $EventID = trim($_GET['EventID']);


      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.Title, Event.StartDate, Event.StartTime, Event.Information, Event.StreetAdress
                FROM User
                JOIN Event
                ON User.UserID=Event.UserID
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

}

displayEvent();

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

function makeComment($comment){

  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }


  $myusername = $_SESSION['username'];
  $EventID = trim($_GET['EventID']);

    $comment = $comment;
    $comment = htmlentities($comment);
    $comment = mysqli_real_escape_string($db, $comment);

    $commentquery = ("INSERT INTO Comments (Text, EventID, UserName)
                  VALUES (?, ?, ?)
                  ");

    $stmt2 = $db->prepare($commentquery);
    $stmt2->bind_param('sis', $comment, $EventID, $myusername);
    $stmt2->execute();

    unset($_POST);
    ?>
      <script>
          window.location.href = "event.php?EventID=<?php echo $EventID?>";
      </script>
      <?php
}


if (isset($_POST['postcomment']) && !empty($_POST['commentfield'])) {
  makeComment($_POST['commentfield']);
}



function getComment(){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $EventID = trim($_GET['EventID']);

      $getcomment = ("SELECT Comments.Text, Comments.UserName, User.UserID, User.ProfilePicture
                FROM Comments
                JOIN User
                ON Comments.UserName=User.UserName
                WHERE EventID=$EventID
                ");
      $stmt3 = $db->prepare($getcomment);
      $stmt3->bind_result($Text, $Commenter, $UserID, $Profilepic);
      $stmt3->execute();

      while ($stmt3->fetch()) {
          echo "<div class='comment'>";
          echo "<img src='$Profilepic' class='commenterpic'/>";
          echo "<a href='user.php?UserID= " . urlencode($UserID) . " '> $Commenter </a> says";
          echo "<div id='commentBox'>";
          echo "<div class='commentarrow'></div>";
          echo "<div id='commenttext'><p>";
          echo $Text;
          echo "</p></div>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
      }
}


getComment();




?>


<?php
  include("footer.php");
?>
