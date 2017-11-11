<!DOCTYPE html>
	  <html lang="en">
	  <head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
				<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,600,700,900|Noto+Sans:300,400,700" rel="stylesheet">
				<script type="text/javascript" src="../js/jquery.min.js"></script>
	  </head>

	  <body>
		    <main id="main">
	      <header id="mainheader">

						<nav id="mainmenu">
							<div id="close" onclick="closeNav()">×</div>
							<ul>
								<li><a class ="slide-effect" id="<?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : NULL ?>" href="index.php">Home</a></li>
								<li><a class ="slide-effect" id="<?php echo ($current_page == 'eventfeed.php') ? 'active' : NULL ?>" href="eventfeed.php">Events</a></li>
								<li><a class ="slide-effect" id="<?php echo ($current_page == 'userfeed.php') ? 'active' : NULL ?>" href="userfeed.php">Users</a></li>
								<li><a class ="slide-effect" id="<?php echo ($current_page == 'rules.php') ? 'active' : NULL ?>" href="rules.php">Rules</a></li>
								<li><a class ="slide-effect" href="logout.php">Logout</a></li>
							</ul>

						</nav>

						<div id="headbox">
						 <div id="hamb" onclick="openNav()">&#9776;</div>
						 <img class="logo" src="img/eventually.png"/>
					 </div>

	      </header>




            <div id="content">
