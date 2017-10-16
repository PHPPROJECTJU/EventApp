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

<div class="searchwrapper">
    <form class="searchform" action="index.php" method="POST">
          <input type="text" name="searchevent" class="searchbar" placeholder="Search events">
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

    $query = "SELECT User.UserID, User.UserName, User.Password, User.EmailAdress, User.FirstName, User.LastName, User.Birthdate, User.About, User.ProfilePicture
              FROM User
              ";


    $stmt = $db->prepare($query);
    $stmt->bind_result($UserID, $UserName, $Password, $EmailAdress, $FirstName, $LastName, $Birthdate, $About, $ProfilePicture);
    $stmt->execute();

    while ($stmt->fetch()) {
        echo "<div class='profilebox'>";
        echo "<img src='../$ProfilePicture' id='personalprofilepic'/>";
        echo "</br><h3 class='personalusername'>$UserName</h3></br></br>";
        echo "Name:</br> $FirstName $LastName</br>";
        echo "</br>Birthdate:</br>$Birthdate</br>";
        echo "</br>Email:</br> $EmailAdress</br>";
        echo "</br>About:</br>$About</br>";
        echo "</br></br><a class='profilebutton' href='hostedevents.php?UserID= " . urlencode($UserID) . " '>See hosted events</a>";
        echo "</div>";
    }

?>

<?php
  include("footer.php");
?>
