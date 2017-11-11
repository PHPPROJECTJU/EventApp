<?php
  session_start();
?>

<?php
  include("header.php");
?>

<button onclick="goToTop()" id="topButton" title="Go to top">
    &uarr;
</button>

<div class="searchwrapper">
    <div class="searchwrapper_second">
        <form class="searcheventsform" action="userfeed.php" method="POST">
              <input type="text" name="searchevent" class="searchbar" placeholder="Search users">
              <input type="submit" class="searchbutton" name="search" value="GO">
        </form>
    </div>
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

if (isset($_POST['search']) && !empty($_POST['searchevent'])) {
    echo "<a href='userfeed.php' style='text-align:center; cursor:pointer; display: block; width:150px; margin: 0 auto;color:#999; border:none; text-decoration:underline; font-size:75%;' >RESET SEARCHBAR</a>";

    $searchphrase = htmlentities($_POST['searchevent']);

    $searchphrase = trim($searchphrase);

    $searchphrase = mysqli_real_escape_string($db, $searchphrase);

    $searchphrase = addslashes($searchphrase);


    $search = "SELECT User.UserID, User.UserName, User.ProfilePicture
              FROM User
              WHERE UserName LIKE '%" . $searchphrase . "%'
              OR About LIKE '%" . $searchphrase . "%'
              OR FirstName LIKE '%" . $searchphrase . "%'
              OR LastName LIKE '%" . $searchphrase . "%'
              ORDER BY User.UserName DESC
              ";

          $stmt = $db->prepare($search);
          $stmt->bind_result($UserID, $UserName, $ProfilePicture);
          $stmt->execute();
} else {

/*--Getting stuff from database without searching-----------------------------------------*/

$search = "SELECT User.UserID, User.UserName, User.ProfilePicture
          FROM User
          ORDER BY User.UserName DESC
          ";

      $stmt = $db->prepare($search);
      $stmt->bind_result($UserID, $UserName, $ProfilePicture);
      $stmt->execute();

    } /*<--end of the if/else post isset statement*/


while ($stmt->fetch()) {


              echo "<div class='userfeedbox'>";
              echo "<img src='../$ProfilePicture' id='feedprofilepic'/>";
              echo "</br>";
              echo "<a href='user.php?UserID=" . urlencode($UserID) . " '>";
              echo "<h3 class='personalusername'>$UserName</h3>";
              echo "</a>";
              echo "</div>";

}//while fetch

?>

</div>



<?php

  include("footer.php");

?>
