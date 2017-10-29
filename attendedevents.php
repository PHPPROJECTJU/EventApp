<?php
  session_start();
?>

<?php
  include("config.php");
  include("header.php");

?>

<!--myprofileheader could be included, but then we wouldn't be able to have it active at the same time as the lower tabs-->

<header id="myprofileheader">

    <nav id="profileorevents">
        <ul>
            <li><a href="profile.php">View profile</a></li>
            <li><a id="active" href="myevents.php">My events</a></li>
        </ul>
    </nav>
</header>

<?php
  include("myeventsheader.php");
?>

<?php

$username = $_SESSION['username'];

@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

if ($db->connect_error) {
echo "could not connect: " . $db->connect_error;
printf("<br><a href=index.php>Return to home page </a>");
exit();
}

$query = "SELECT UserID
          FROM User
          WHERE User.UserName = '{$username}'
          ";

$stmt9 = $db->prepare($query);
$stmt9->bind_result($myuserid);
$stmt9->execute();
$stmt9->store_result();
$stmt9->fetch();

getAttendedEvents($myuserid);

?>

<?php
  include("footer.php");
?>
