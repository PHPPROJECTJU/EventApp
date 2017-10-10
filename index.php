<?php
  include("config.php");
  include("header.php");

?>


<form action="index.php" method="POST">
  <table id="searchevents">

    <tr>
      <td><input type="text" name="searchevent" class="searchbar" placeholder="search events"></td>
      <td><INPUT type="submit" class="searchbutton" name="submit" value="GO"></td>
    </tr>
  </table>
</form>

<div id="browse">


  <div class="box">
      <h3 class="profiletitle">Bowling &amp; pizza</h3>
      <hr />
      <img src="img/ellen.jpg" class="profilepic"/>
      <div class="specifics">
          <p><img src="img/place.png" />Jönköping centrum</p>
          <br />
          <p><img src="img/time.png" />24/7 kl 10.00</p>
      </div>
      <p class="description">Some text about events event evsnesabdija
        cdasfaifhnjkn hfsfeoscndnvcdsoifjdsiccxjnzkcjnzjk
        Hje här ör lite text om ingenting för att elenne ska ska hur detta ser ut stavar jag ens rtt???
      </p>
      <br />
      <a href="event.php" class="seemore">more...</a>
  </div>

  <div class="box">
      <h3 class="profiletitle">Bowling &amp; pizza</h3>
      <hr />
      <img src="img/ellen.jpg" class="profilepic"/>
      <div class="specifics">
          <p><img src="img/place.png" />Jönköping centrum</p>
          <br />
          <p><img src="img/time.png" />24/7 kl 10.00</p>
      </div>
      <p class="description">Some text about events event evsnesabdija
        cdasfaifhnjkn hfsfeoscndnvcdsoifjdsiccxjnzkcjnzjk
        Hje här ör lite text om ingenting för att elenne ska ska hur detta ser ut stavar jag ens rtt???
      </p>
      <br />
      <a href="event.php" class="seemore">more...</a>
  </div>

  <?php
      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $query = "SELECT User.UserName, User.ProfilePicture, Event.EventID, Event.Title, Event.StartDate, Event.StartTime, Event.Information, Location.StreetAdress
                FROM User
                JOIN Event
                ON User.UserID=Event.UserID
                JOIN Location
                ON Event.LocationID=Location.LocationID";

      $stmt = $db->prepare($query);
      $stmt->bind_result($UserName, $ProfilePicture, $EventID, $Title, $StartDate, $StartTime, $Information, $StreetAdress);
      $stmt->execute();

      while ($stmt->fetch()) {
          echo "<div class='box'>";
          echo "<h3 class='profiletitle'>$Title</h3>";
          echo "<img src='$ProfilePicture' class='profilepic'/>";
          echo "<div class='specifics'>";
          echo "<p><img src='img/place.png' />$StreetAdress</p> <br />";
          echo "<p><img src='img/time.png' />$StartDate kl $StartTime</p>";
          echo "</div>";
          echo "<p class='description'>$Information</p>";
          echo "<a class='seemore' href='event.php?EventID= " . urlencode($EventID) . " '>more...</a>";
          echo "</div>";
      }


  ?>


  <div class="box">
      <h3 class="profiletitle">Gå på Jurassic Park-premiären</h3>
      <hr />
      <img src="img/ellen.jpg" class="profilepic"/>
      <div class="specifics">
          <p><img src="img/place.png" />SF Bergakungen</p>
          <br />
          <p><img src="img/time.png" />30/7 kl 20.30</p>
      </div>
      <p class="description">Some text about events event evsnesabdija
        cdasfaifhnjkn hfsfeoscndnvcdsoifjdsiccxjnzkcjnzjk
      </p>
      <br />
      <a href="event.php" class="seemore">more...</a>
  </div>

  <div class="box">
      <h3 class="profiletitle">Bowling &amp; pizza</h3>
      <hr />
      <img src="img/ellen.jpg" class="profilepic"/>
      <div class="specifics">
          <p><img src="img/place.png" />Folkungagatan 156 tredje våningen portkod 4343</p>
          <br />
          <p><img src="img/time.png" />24/7 kl 10.00 eller kanske kl 13.00 vad tycker ni</p>
      </div>
      <p class="description">Some text about events event evsnesabdija
        cdasfaifhnjkn hfsfeoscndnvcdsoifjdsiccxjnzkcjnzjk
        Hje här ör lite text om ingenting för att elenne ska ska hur detta ser ut stavar jag ens rtt???
      </p>
      <br />
      <a href="event.php" class="seemore">more...</a>
  </div>

  <div class="box">
    <p class="description">Some text about events event evsnesabdija
      cdasfaifhnjkn hfsfeoscndnvcdsoifjdsiccxjnzkcjnzjk
    </p>
  </div>

  <div class="box">
    <p class="description">Some text about events event evsnesabdija
      cdasfaifhnjkn hfsfeoscndnvcdsoifjdsiccxjnzkcjnzjk
    </p>
  </div>

</div>


<?php
  include("footer.php");
?>
