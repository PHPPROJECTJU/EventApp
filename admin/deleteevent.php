<?php
  session_start();
  if (!isset($_SESSION['adminusername'])) {
    header("location:login.php");
  }
?>
<?php
  include("header.php");
  include("config.php");
?>

<?php

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $EventID = trim($_GET['EventID']);

    $query = "SELECT User.Username, Event.Title
              FROM User
              JOIN Event
              ON User.UserID=Event.UserID
              WHERE Event.EventID=$EventID
              ";

    $stmt = $db->prepare($query);
    $stmt->bind_result($UserName, $Title);
    $stmt->execute();

    while ($stmt->fetch()) {
        echo "<h3>Delete ". $UserName ."'s event ". $Title ."? This action cannot be reversed.</h3>";
    }



    if(isset($_GET['submit'])) {
      deleteEvent($EventID);
    }




    function deleteEvent($EventID){
      include("config.php");


      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $EventID = trim($_GET['EventID']);

      $deleteevent = "DELETE
                      FROM
                      Event
                      WHERE
                      EventID = $EventID
                      ";


      $stmt = $db->prepare($deleteevent);
      $stmt->bind_param('i', $EventID);
      $response = $stmt->execute();
      echo "<h3>Event deleted</h3>";

    }

?>


<form action="deleteevent.php" method="GET">

  <?php
$EventID = trim($_GET['EventID']);
echo '<INPUT type="hidden" name="EventID" value=' . $EventID . '>';
?>

    <INPUT type="submit" class="search" name="submit" value="Delete">

</form>



<?php
  include("footer.php");
?>
