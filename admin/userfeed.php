<?php
  session_start();

//Setting a cookie with our region for the search field

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
            window.location.href = "userfeed.php";
        </script>
        <?php
    }

    if (isset($_POST['allregions'])) {
      setcookie("regionpick","",time()-24 * 3600);
      unset($_POST);
      ?>
        <script>
            window.location.href = "userfeed.php";
        </script>
        <?php
    }

?>

<?php
  include("header.php");
?>

<button onclick="goToTop()" id="topButton" title="Go to top">
    &uarr;
</button>

<div class="searchwrapper">
    <div class="searchwrapper_second">
        <img class="chooselocation" src="img/pin.png" title="Choose location">

        <form class="searcheventsform" action="userfeed.php" method="POST">
              <input type="text" name="searchevent" class="searchbar" placeholder="Search events">
              <input type="submit" class="searchbutton" name="search" value="GO">
        </form>
    </div>
    <p id="inregion"><?php echo $region; ?></p>
    <ul id='regionmenu'>
      <div class="liwrapper">
        <form action="userfeed.php" name="chooseregion" method="POST">


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

        if (isset($_COOKIE['regionpick'])) {
            if ($region == $statename) {

              echo "<div class='userfeedbox'>";
              echo "<img src='../$ProfilePicture' id='feedprofilepic'/>";
              echo "</br>";
              echo "<a href='user.php?UserID=" . urlencode($UserID) . " '>";
              echo "<h3 class='personalusername'>$UserName</h3>";
              echo "</a>";
              echo "</div>";
            } //check if the cookie region matches the event region

        } elseif (!isset($_COOKIE['regionpick'])) {

          echo "<div class='userfeedbox'>";
          echo "<img src='../$ProfilePicture' id='feedprofilepic'/>";
          echo "</br>";
          echo "<a href='user.php?UserID=" . urlencode($UserID) . " '>";
          echo "<h3 class='personalusername'>$UserName</h3>";
          echo "</a>";
          echo "</div>";
          } //cookie check
}//while fetch

?>

</div>



<?php

  include("footer.php");

?>
