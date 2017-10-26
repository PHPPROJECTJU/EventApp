<?php
  session_start();
  if (!isset($_SESSION['adminusername'])) {
    header("location:login.php");
  }
?>
<?php
  include("config.php");
  include("header.php");
?>

<div class="searchwrapper">
    <form class="searchform" action="userfeed.php" method="POST">
          <input type="text" name="searchuser" class="searchbar" placeholder="Search users">
          <input type="submit" class="searchbutton" name="submit" value="GO">
    </form>
</div>

<?php

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    /*-----showing the feed of users that can be administered--------*/

    /*--Search function-----------------------------------------*/

    if (isset($_POST) && !empty($_POST)) {

        $searchphrase = htmlentities($_POST['searchuser']);

        $searchphrase = trim($searchphrase);

        $searchphrase = mysqli_real_escape_string($db, $searchphrase);

        $searchphrase = addslashes($searchphrase);


        $search = "SELECT User.UserID, User.UserName, User.Password, User.EmailAdress, User.FirstName, User.LastName, User.Birthdate, User.About, User.ProfilePicture
                  FROM User
                  WHERE UserName LIKE '%" . $searchphrase . "%'
                  OR About LIKE '%" . $searchphrase . "%'
                  OR FirstName LIKE '%" . $searchphrase . "%'
                  OR LastName LIKE '%" . $searchphrase . "%'
                  ORDER BY User.UserID DESC
                  ";

              $stmt = $db->prepare($search);
              $stmt->bind_result($UserID, $UserName, $Password, $EmailAdress, $FirstName, $LastName, $Birthdate, $About, $ProfilePicture);
              $stmt->execute();
    } else {


    $query = "SELECT User.UserID, User.UserName, User.Password, User.EmailAdress, User.FirstName, User.LastName, User.Birthdate, User.About, User.ProfilePicture
              FROM User
              ";


    $stmt = $db->prepare($query);
    $stmt->bind_result($UserID, $UserName, $Password, $EmailAdress, $FirstName, $LastName, $Birthdate, $About, $ProfilePicture);
    $stmt->execute();

    }

    while ($stmt->fetch()) {
        echo "<div class='profileboxfeed'>";
        echo "<img src='../$ProfilePicture' class='profilepicfeed'/>";
        echo "</br><a name='". $UserID ."'><h3 class='personalusername'>$UserName</h3></a>";
        echo "<a class='seemore' href='user.php?UserID=". urlencode($UserID) ."'>administrate...</a>";
        echo "</div>";
      }

?>

<?php
  include("footer.php");
?>
