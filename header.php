<!DOCTYPE html>
	  <html lang="en">
	  <head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans:300,400,600|Roboto:300,400,600,700" rel="stylesheet">
	  </head>


<?php
include("functions.php");

if (!isset($_SESSION['username'])) {
	header("location:login.php");
}

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
									<div id="myBtn" class="createeventbutton">
											 	<div class="theplus">+</div>
									</div>
					 </div>

					 <div id="myModal" class="modal">

					   <!-- Modal content -->
					   <div class="modal-content">
						    <div class="modal-header">
								       <span class="close">&times;</span>
								       <h2>Create a new event!</h2>
								</div>
								 	<div class="modal-body">
										<form action="" method="POST">
											<div id="eventform">
														<div class="row">
																 Name of Event<input type="text" name="eventname" class="eventregisterbar" placeholder="Name of Event" required>
														</div>
														<div class="row">
																 Adress<input type="text" name="adress" class="eventregisterbar" placeholder="i.e Fortunagatan 16B" required>
														</div>

														<div class="row">Select your region
															 <select name="region" placeholder="Select region">
																	 <option value="" disabled selected>Select your region</option>
																	 <?php

																			getregions();

																		?>
															 </select>
													 </div>

														<div class="row">Select your city
															 <select name="city" placeholder="Select city">
																	 <option value="" disabled selected>Select city</option>
																	 <?php

																			getcity();

																		?>
															 </select>
													 </div>

														<div class="row">
																<div class="innerdatewrap"><p>Start date</p><input type="date" name="startdate" class="test" placeholder="Time for event" required></div>
																<div class="innerdatewrap"><p>Start time</p><input type="time" name="starttime" class="test" placeholder="Time for event" required></div>

														</div>
														<div class="row">
																<div class="innerdatewrap"><p>End date</p><input type="date" name="enddate" class="test" placeholder="Time for event" required></div>
																<div class="innerdatewrap"><p>End time</p><input type="time" name="endtime" class="test" placeholder="Time for event" required></div>
														</div>
														<div class="row">
															Describe your event<textarea rows="4" cols="80" type="textarea" name="description" class="eventregisterbartext" placeholder="Description of event" required></textarea>
														</div>

														<div class="row">Select a tag
															 <select name="categoryID" placeholder="Select category">
																	 <option value="">Select category</option>
																	 <?php

																					getcategory();

																		?>
															 </select>
													 </div>

														 <div>
																 <input type="submit" class="registerbutton" name="createevent" value="Create event">
														 </div>
											 </div>

										</form>
										</div>


										</div>

										</div>

										<?php

										if (isset($_POST['createevent'])) {
											createEvent();
										}
										?>

	      </header>




            <div id="content">
