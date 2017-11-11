<!DOCTYPE html>
	  <html lang="en">
	  <head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
				<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,600,700,900|Noto+Sans:300,400,700" rel="stylesheet">
				<script type="text/javascript" src="js/jquery.min.js"></script>
	  </head>


<?php
include("config.php");
include("../functions.php");
include("adminfunction.php");

$date = date('Y-m-d');


if (!isset($_SESSION['adminusername'])) {
	header("location:login.php");
}

$username = $_SESSION['adminusername'];

?>

	  <body>
		    <main id="main">
	      <header id="mainheader">

<?php
@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

if ($db->connect_error) {
echo "could not connect: " . $db->connect_error;
printf("<br><a href=index.php>Return to home page </a>");
exit();
}

$query = "SELECT User.ProfilePicture
					FROM User
					WHERE User.UserName = '{$username}'
					";

$stmt9 = $db->prepare($query);
$stmt9->bind_result($ProfilePicture);
$stmt9->execute();
$stmt9->store_result();
$stmt9->fetch();
 ?>


						<nav id="mainmenu">
									<div id="close" onclick="closeNav()">×</div>
										<div id="menuprofilelinks">
								<ul>
												<li><img src="img/user-32.png" class="menuicons" /><a id="adminname"><?php echo $username; ?></a></li>
												<li><a href="logout.php" id="logout2" title="Logout"></a></li>
							  </ul>
										</div>

								<ul id="menuitems">
								<li><img src="img/home-7-32.png" class="menuicons" /><a class ="slide-effect" id="<?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : NULL ?>" href=index.php>Home</a></li>
								<li><img src="img/calendar-11-32.png" class="menuicons" /><a class ="slide-effect" id="<?php echo ($current_page == 'eventfeed.php') ? 'active' : NULL ?>" href=eventfeed.php>Events</a></li>
								<li><img src="img/user-32.png" class="menuicons" /><a class ="slide-effect" id="<?php echo ($current_page == 'userfeed.php') ? 'active' : NULL ?>" href="userfeed.php">Users</a></li>
								<li><img src="img/info-32.png" class="menuicons" /><a class ="slide-effect" id="<?php echo ($current_page == 'rules.php') ? 'active' : NULL ?>" href="rules.php">Rules</a></li>
								<li><img src="img/account-logout-32.png" class="menuicons" /><a class ="slide-effect" href="logout.php" id="logout1">Logout</a></li>
							</ul>
						</nav>

						<div id="headbox">
								 <div id="hamb" onclick="openNav()" title="Menu">&#9776;</div>
								 <a title="Start page" class="logolink" href="index.php"><img class="logo" src="img/eventually_admin_head.png"/></a>
					 </div>


</header>

<section id="content">
