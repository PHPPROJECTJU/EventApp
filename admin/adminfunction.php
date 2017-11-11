<?php
function adminlogin(){

  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
  echo "could not connect: " . $db->connect_error;
  exit();
  }

  $getusername =  stripslashes($_POST['getusername']);
  $getpassword =  stripslashes($_POST['getpassword']);

  $getusername = htmlentities($getusername);
  $getpassword = htmlentities($getpassword);

  $query = "SELECT User.Password, User.Admin
            FROM User
            WHERE User.UserName = '{$getusername}'
            ";

            $stmt2 = $db->prepare($query);
            $stmt2->bind_result($hashedpassword, $isadmin);
            $stmt2->execute();
            $stmt2->store_result();

            $totalcount = $stmt2->num_rows();

            $stmt2->fetch();

            if(password_verify($getpassword, $hashedpassword) AND ($isadmin == 1)) {
                $_SESSION['adminusername'] = $getusername;
                header("location:index.php");
            } elseif (!password_verify($getpassword, $hashedpassword)) {
              echo "<p class='wrongpasstext'>Wrong username or password. Please try again.</p>";
            } elseif ($isadmin == 0) {
              echo "<p class='wrongpasstext'>User is not an admin</p>";
            }


}



/*Event.php-------------------------------------------*/

#showing the event card

function adminDisplayEvent(){
  include("config.php");


  $EventID = trim($_GET['EventID']);


      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.Title, Event.Status, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(EndDate, '%D %M, %Y') AS `EndDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, DATE_FORMAT(`EndTime`, '%H:%i') AS `EndTime`, Event.Information, Event.StreetAdress, City.city_name, Category.Categoryname
                FROM User
                JOIN Event
                ON User.UserID=Event.UserID
                JOIN City
                ON Event.city_id=City.city_id
                JOIN Category
                ON Event.CategoryID=Category.CategoryID
                WHERE Event.EventID=$EventID AND Event.EndDate >= CURDATE()-1
                ";

      $stmt = $db->prepare($query);
      $stmt->bind_result($UserName, $ProfilePicture, $UserID, $Title, $Status, $StartDate, $EndDate, $StartTime, $EndTime, $Information, $StreetAdress, $cityname, $category);
      $stmt->execute();


      while ($stmt->fetch()) {
          if ($Status == 1) {

            echo "<div class='firsteventbox'>";
            echo "<div id='deletebutton'>×</div>";
            echo "<h3 class='profiletitle'>$Title</h3>";
            echo "<span class='pictureandname'>";
            echo "<img src='../$ProfilePicture' class='profilepic'/>";
            echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
            echo "</span>";
            echo "<div class='specifics'>";
            echo "<p><img src='img/place-black.png' />$StreetAdress<br>  $cityname</p> <br />";
            if($StartDate == $EndDate){
              echo "<p><img src='img/time-black.png' />$StartDate <br>kl $StartTime - $EndTime</p>";
              echo "<p><img src='img/tag-black.png' />$category</p>";
              echo "</div>";
              echo "<p class='description'>$Information</p>";
            } elseif ($StartDate !== $EndDate){
              echo "<p><img src='img/time-black.png' />$StartDate <br>kl $StartTime</p>";
              echo "<p><img src='img/tag-black.png' />$category</p>";
              echo "</div>";
              echo "<p class='description'>$Information</p>";
              echo "<p class='description'><b>Event ends:</b> $EndDate kl $EndTime</p>";
            }
            howManyAttenders($EventID);
            echo "</div>";
            }


          }


/*
No matter if we want to save or attend the event,
we need to get the logged in user's ID to insert
into the middle table Event_User. We get it by using
our previous function getUserID (see above) to echo
out a hidden input with the desired ID. When the form
is submitted, we can capture the id to use and pass
with either the function saveEvent or attendEvent.
(se below) Note: We also need the ID of the Event host,
hence the hidden input "eventhostid"
*/

        if (isset($_POST['save']) OR isset($_POST['attend'])) {
            $myuserid = trim($_POST['userid']);
            $eventhostid = trim($_POST['eventhostid']);
        }

        if (isset($_POST['save'])) {
            saveEvent($myuserid, $EventID, $eventhostid);
        }
        else if (isset($_POST['attend'])) {
            attendEvent($myuserid, $EventID, $eventhostid);
        }

#to be able to unattend or unsave at the event page:

        if (isset($_POST['unattend'])) {
          $myuserid = trim($_POST['userid']);
          unattendEvent($EventID, $myuserid);
          unset($_POST);
          ?>
            <script>
                window.location.href = "event.php?EventID=<?php echo $EventID?>";
            </script>
          <?php
        } else if (isset($_POST['unsave'])) {
          $myuserid = trim($_POST['userid']);
          unsaveEvent($EventID, $myuserid);
          unset($_POST);
          ?>
            <script>
                window.location.href = "event.php?EventID=<?php echo $EventID?>";
            </script>
          <?php
        }

}

#getting and displaying comments

function adminGetComment(){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $myusername = $_SESSION['username'];

      $EventID = trim($_GET['EventID']);

      $getcomment = ("SELECT Comments.CommentID, Comments.Text, Comments.UserName, User.UserID, User.ProfilePicture
                FROM Comments
                JOIN User
                ON Comments.UserName=User.UserName
                WHERE EventID=$EventID
                ORDER BY CommentID DESC
                ");
      $stmt3 = $db->prepare($getcomment);
      $stmt3->bind_result($Commentid, $Text, $Commenter, $UserID, $Profilepic);
      $stmt3->execute();


      while ($stmt3->fetch()) {
          echo "<div class='comment'>";
          echo "<img src='../$Profilepic' class='commenterpic'/>";
          echo "<a href='user.php?UserID= " . urlencode($UserID) . " '> $Commenter </a> says:";
          echo "<div id='commentBox'>";

          #If this is our own comment we want to be able to delete it
          if ($Commenter == $myusername) {
            echo "<form action='' method='POST'>";
            echo '<INPUT type="hidden" name="commentid" value=' . $Commentid . '>';
            echo "<input type='submit' class='closedark' name='deletecomment' value='×'>";
            echo "</form>";
          }

          echo "<div class='commentarrow'></div>";
          echo "<div id='commenttext'><p>";
          echo $Text;
          echo "</p></div>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
      }

      if (isset($_POST['deletecomment'])) {
        $Commentid = ($_POST['commentid']);
        deleteComment($Commentid);
        unset($_POST);
        ?>
        <script>
            window.location.href = "event.php?EventID=<?php echo $EventID?>";
        </script>
        <?php
      }
}



?>
