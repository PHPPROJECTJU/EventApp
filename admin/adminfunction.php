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

            #to be able to delete event
            echo "<form action='' method='POST'>";
            echo '<INPUT type="hidden" name="eventid" value=' . $EventID . '>';
            echo "<input type='submit' class='closedark' name='deleteevent' value='×'>";
            echo "</form>";
            #

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

            if (isset($_POST['deleteevent'])) {
              $EventID = ($_POST['eventid']);
              adminDeleteEvent($EventID);
              unset($_POST);
              ?>
              <script>
                  window.location.href = "eventfeed.php";
              </script>
              <?php
            }


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

          #To be able to delete a comment
            echo "<form action='' method='POST'>";
            echo '<INPUT type="hidden" name="commentid" value=' . $Commentid . '>';
            echo "<input type='submit' class='closedark' name='deletecomment' value='×'>";
            echo "</form>";

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

function adminDeleteEvent($EventID){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

  $deleteevent = "UPDATE Event
                  SET Status=0
                  WHERE
                  Event.EventID = ?
                  ";

                  $stmt = $db->prepare($deleteevent);
                  $stmt->bind_param('i', $EventID);
                  $response = $stmt->execute();
}

function adminDeleteUser($UserID){

  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

  $deleteuser =   "DELETE FROM
                  User
                  WHERE
                  User.UserID = ?
                  ";

                  $stmt = $db->prepare($deleteuser);
                  $stmt->bind_param('i', $UserID);
                  $response = $stmt->execute();

}


?>
