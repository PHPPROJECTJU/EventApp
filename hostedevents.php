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

getHostedEvents($myuserid);

?>

<script type="text/javascript" src="js/attendedmodal.js"></script>

<?php
  include("footer.php");
?>
