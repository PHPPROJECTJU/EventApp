<?php
  session_start();
?>

<?php
  include("header.php");
?>

<div class="searchwrapper">
    <div class="searchwrapper_second">
        <form class="searcheventsform" action="eventfeed.php" method="POST">
              <input type="text" name="searchevent" class="searchbar" placeholder="Search events">
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
    echo "<a href='eventfeed.php' style='text-align:center; cursor:pointer; display: block; width:150px; margin: 0 auto;color:#999; border:none; text-decoration:underline; font-size:75%;' >RESET SEARCHBAR</a>";

    $searchphrase = htmlentities($_POST['searchevent']);

    $searchphrase = trim($searchphrase);

    $searchphrase = mysqli_real_escape_string($db, $searchphrase);

    $searchphrase = addslashes($searchphrase);


    $search = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Status, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, City.city_name, State.state_name, Category.Categoryname
              FROM User
              JOIN Event
              ON User.UserID=Event.UserID
              JOIN City
              ON Event.city_id=City.city_id
              JOIN State
              ON Event.state_id=State.state_id
              JOIN Category
              ON Event.CategoryID=Category.CategoryID
              WHERE Title LIKE '%" . $searchphrase . "%'
              OR Information LIKE '%" . $searchphrase . "%'
              OR UserName LIKE '%" . $searchphrase . "%'
              OR Categoryname LIKE '%" . $searchphrase . "%'
              ORDER BY Event.EventID DESC
              ";

          $stmt = $db->prepare($search);
          $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Status, $Title, $StartDate, $StartTime, $Information, $StreetAdress, $cityname, $statename, $Category);
          $stmt->execute();
} else {

/*--Getting stuff from database without searching-----------------------------------------*/

      $getevent = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Status, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, City.city_name, State.state_name, Category.Categoryname
                FROM User
                JOIN Event
                ON User.UserID=Event.UserID
                JOIN City
                ON Event.city_id=City.city_id
                JOIN State
                ON Event.state_id=State.state_id
                JOIN Category
                ON Event.CategoryID=Category.CategoryID
                ORDER BY Event.EventID DESC
                ";

      $stmt = $db->prepare($getevent);
      $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Status, $Title, $StartDate, $StartTime, $Information, $StreetAdress, $cityname, $statename, $Category);
      $stmt->execute();

    } /*<--end of the if/else post isset statement*/


while ($stmt->fetch()) {
    if ($Status == 1) {

              echo "<div class='box'>";
              echo "<a name='". urldecode($UserID) ."'><h3 class='profiletitle'>$Title</h3></a>";
              echo "<span class='pictureandname'>";
              echo "<img src='../$ProfilePicture' class='profilepic'/>";
              echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
              echo "</span>";
              echo "<div class='specifics'>";
              echo "<p><img src='img/place-black.png' />$StreetAdress<br> $cityname</p> <br />";
              echo "<p><img src='img/time-black.png' />$StartDate <br>kl $StartTime</p>";
              echo "<p><img src='img/tag-black.png' />$Category</p>";
              echo "</div>";
              echo "<p class='description'>$Information</p>";
              echo "<a class='seemore' href='event.php?EventID=" . urlencode($EventID) . " '>more...</a>";
              echo "</div>";

    }//if status is 1
}//while fetch

?>

</div>


<?php

  include("footer.php");

?>
