<!DOCTYPE html>
	  <html lang="en">
	  <head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans:300,400,600|Roboto:300,400,600,700" rel="stylesheet">
	  </head>


<?php

$username = $_SESSION['username'];

?>

	  <body>
		    <main id="main">
	      <header id="mainheader">

						<nav id="mainmenu">
							<div id="close" onclick="closeNav()">×</div>
							<ul>
								<li><a class ="slide-effect" id="<?php echo ($current_page == 'profile.php') ? 'active' : NULL ?>" href="profile.php"><?php echo $username; ?></a></li>
								<li><a class ="slide-effect" id="<?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : NULL ?>" href="index.php">Browse</a></li>
								<li><a class ="slide-effect" id="<?php echo ($current_page == 'about.php') ? 'active' : NULL ?>" href="about.php">About</a></li>
								<li><a class ="slide-effect" id="<?php echo ($current_page == 'contact.php') ? 'active' : NULL ?>" href="contact.php">Contact</a></li>
								<li><a class ="slide-effect" href="logout.php">Logout</a></li>
							</ul>

						</nav>

						<div id="headbox">
						 <div id="hamb" onclick="openNav()">&#9776;</div>
						 <img class="logo" src="img/eventually.png"/>
						 <a href="createevent.php"><div class="createeventbutton"><div class="theplus">+</div></div></a>
					 </div>

	      </header>




            <div id="content">
