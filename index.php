<?php
session_start();
if (!isset($_SESSION['username'])) {
	header("location:login.php");
}


//Setting a cookie with our region for the search field

ini_set('session.cookie_httponly', true);

    if (isset($_COOKIE['regionpick'])) {
      $region = $_COOKIE['regionpick'];
    } else {
      $region = "";
    }

    if (isset($_POST['regionpick'])) {
      $region = $_POST['regionpick'];
      setcookie('regionpick', $region, time() + 24 * 3600);
      unset($_POST);
      ?>
        <script>
            window.location.href = "index.php";
        </script>
        <?php
    }

    if (isset($_POST['allregions'])) {
      setcookie("regionpick","",time()-24 * 3600);
      unset($_POST);
      ?>
        <script>
            window.location.href = "index.php";
        </script>
        <?php
    }

?>

<?php
  include("config.php");
  include("header.php");
?>



<button onclick="goToTop()" id="topButton" title="Go to top">
    &uarr;
</button>

<div class="searchwrapper">
    <div class="searchwrapper_second">

				<div id="together">
	        <img class="chooselocation" src="img/redpin.png" title="Choose location">
					<p id="inregion"><?php echo $region; ?></p>
				</div>

        <form class="searcheventsform" action="index.php" method="POST">
              <input type="text" name="searchevent" class="searchbar" placeholder="Search events">
              <input type="submit" class="searchbutton" name="search" value="GO">
        </form>
    </div>

    <ul id='regionmenu'>
      <div class="liwrapper">
        <form action="index.php" name="chooseregion" method="POST">

        <?php
            @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

            if ($db->connect_error) {
                echo "could not connect: " . $db->connect_error;
                printf("<br><a href=index.php>Return to home page </a>");
                exit();
            }

            $getregion = "SELECT State.state_id, State.state_name
                      FROM State
                      ";

            $stmt = $db->prepare($getregion);
            $stmt->bind_result($regionid, $showregion);
            $stmt->execute();

              while ($stmt->fetch()) {
                  echo "<input type='hidden' name='regionid' value=' . $regionid . '>";
                  echo "<input type='submit' name='regionpick' class='regionbuttons' value='$showregion'>";
              }
              echo "<input type='submit' name='allregions' class='regionbuttons' value='All regions'>";
         ?>
       </form>
       </div>
     </ul>
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
    echo "<a href='index.php' style='text-align:center; cursor:pointer; display: block; width:150px; margin: 0 auto;color:#999; border:none; text-decoration:underline; font-size:75%;' >RESET SEARCHBAR</a>";

    $searchphrase = htmlentities($_POST['searchevent']);

    $searchphrase = trim($searchphrase);

    $searchphrase = mysqli_real_escape_string($db, $searchphrase);

    $searchphrase = addslashes($searchphrase);

		if (isset($_COOKIE['regionpick'])) {
			$search = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Status, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, Event.EndDate, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, City.city_name, State.state_name, Category.Categoryname
	              FROM User
	              JOIN Event
	              ON User.UserID=Event.UserID
	              JOIN City
	              ON Event.city_id=City.city_id
	              JOIN State
	              ON Event.state_id=State.state_id
	              JOIN Category
	              ON Event.CategoryID=Category.CategoryID
	              WHERE (Event.EndDate >= CURDATE()-1) AND (Event.Status = 1) AND (State.state_name = '{$region}') AND (Title LIKE '%" . $searchphrase . "%'
	              OR Information LIKE '%" . $searchphrase . "%'
	              OR UserName LIKE '%" . $searchphrase . "%'
	              OR Categoryname LIKE '%" . $searchphrase . "%')

	              ORDER BY Event.EventID DESC
	              ";
		} else {
			$search = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.EventID, Event.Status, Event.Title, DATE_FORMAT(StartDate, '%D %M, %Y') AS `StartDate`, Event.EndDate, DATE_FORMAT(`StartTime`, '%H:%i') AS `StartTime`, Event.Information, Event.StreetAdress, City.city_name, State.state_name, Category.Categoryname
	              FROM User
	              JOIN Event
	              ON User.UserID=Event.UserID
	              JOIN City
	              ON Event.city_id=City.city_id
	              JOIN State
	              ON Event.state_id=State.state_id
	              JOIN Category
	              ON Event.CategoryID=Category.CategoryID
	              WHERE (Event.EndDate >= CURDATE()-1) AND (Event.Status = 1) AND (Title LIKE '%" . $searchphrase . "%'
	              OR Information LIKE '%" . $searchphrase . "%'
	              OR UserName LIKE '%" . $searchphrase . "%'
	              OR Categoryname LIKE '%" . $searchphrase . "%')

	              ORDER BY Event.EventID DESC
	              ";
		}




          $stmt = $db->prepare($search);
          $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Status, $Title, $StartDate, $EndDate, $StartTime, $Information, $StreetAdress, $cityname, $statename, $Category);
          $stmt->execute();
          $stmt->store_result();

          $totalcount = $stmt->num_rows();


					if ($totalcount == 0 ) {
							echo "<div class='noRows'>";
							echo "<p>There are no events matching your search</p>";
							echo "<form method='POST' action='index.php'>";
							echo "<input type='submit' id='seeattenders' name='allregions' value='Continue browsing'>";
							echo "</form>";
							echo "</div>";
					}

} else {

/*--Getting stuff from database without searching-----------------------------------------*/

			if (isset($_COOKIE['regionpick'])) {
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
	                WHERE (Event.EndDate >= CURDATE()-1) AND (Event.Status = 1) AND (State.state_name = '{$region}')
	                ORDER BY Event.EventID DESC
	                ";
			} else {
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
	                WHERE (Event.EndDate >= CURDATE()-1) AND (Event.Status = 1) /*----Don't display older events than one day after current date.---*/
	                ORDER BY Event.EventID DESC
	                ";
			}


      $stmt = $db->prepare($getevent);
      $stmt->bind_result($UserName, $ProfilePicture, $UserID, $EventID, $Status, $Title, $StartDate, $StartTime, $Information, $StreetAdress, $cityname, $statename, $Category);
      $stmt->execute();
			$stmt->store_result();
			$totalcount = $stmt->num_rows();

			if ($totalcount == 0 ) {
					echo "<div class='noRows'>";
					echo "<p>There are no events matching your search</p>";
					echo "<form method='POST' action='index.php'>";
					echo "<input type='submit' id='seeattenders' name='allregions' value='Continue browsing'>";
					echo "</form>";
					echo "</div>";
			}

    } /*<--end of the if/else post isset statement*/

while ($stmt->fetch()) {


        if (isset($_COOKIE['regionpick'])) {
            if ($region == $statename) {

              echo "<div class='box'>";
              echo "<a name='". urldecode($UserID) ."'><h3 class='profiletitle'>$Title</h3></a>";
              echo "<span class='pictureandname'>";
              echo "<img src='$ProfilePicture' class='profilepic'/>";
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
            } //check if the cookie region matches the event region

        } elseif (!isset($_COOKIE['regionpick'])) {

              echo "<div class='box'>";
              echo "<a name='". urldecode($UserID) ."'><h3 class='profiletitle'>$Title</h3></a>";
              echo "<span class='pictureandname'>";
              echo "<img src='$ProfilePicture' class='profilepic'/>";
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

          } //cookie check

}//while fetch

?>

</div>



<script type="text/javascript" src="js/index.js"></script>

<?php

  include("footer.php");

?>
