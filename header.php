<!DOCTYPE html>
	  <html lang="en">
	  <head>
		    <meta charset="UTF-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans:300,400,600|Roboto:300,400,600,700" rel="stylesheet">
	  </head>

	  <body>
		    <main>
	      <header>

						<nav id="mainmenu">
							<div id="close" onclick="closeNav()"></div>
							<ul>
								<li><a class="<?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : NULL ?>" href="index.php">Home</a></li>
								<li><a class="<?php echo ($current_page == 'profile.php' || $current_page == '') ? 'active' : NULL ?>" href="profile.php">My profile</a></li>
								<li><a class="<?php echo ($current_page == 'about.php' || $current_page == '') ? 'active' : NULL ?>" href="about.php">About</a></li>
								<li><a class="<?php echo ($current_page == 'contact.php' || $current_page == '') ? 'active' : NULL ?>" href="contact.php">Contact</a></li>
							</ul>

						</nav>

						<div id="headbox">
						 <div id="hamb" onclick="openNav()"></div>
					 </div>

	      </header>




            <div id="content">
