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

									               <div class="row">Select your region
																	 	<select name="region" form="eventform" placeholder="Select region">
																				<option value="" disabled selected>Select your region</option>
																				<?php
																				function getregions(){

																						include ("config.php");
																						@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

																						if ($db->connect_error) {
																								echo "could not connect: " . $db->connect_error;
																								printf("<br><a href=index.php>Return to home page </a>");
																								exit();
																						}

																						$getregion = "SELECT State.state_id, State.state_name
																											FROM State
																											";

																						$stmt = $db->prepare($getregion);
																						$stmt->bind_result($regionid, $showregion);
																						$stmt->execute();

																						while ($stmt->fetch()) {
																									echo "<option value='$regionid'>$showregion</option>";
																						}
																				};
																           getregions(); 
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
																 <div class="row">
										               Select tags
																		 	<select name="tag" form="eventform" placeholder="Select tags">
																					<option value="" disabled selected>Select tags</option>
																	        <option value="firsttag">First option</option>
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


					 function createEvent(){
						 include("config.php");

						 @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

				         if ($db->connect_error) {
				             echo "could not connect: " . $db->connect_error;
				             printf("<br><a href=index.php>Return to home page </a>");
				             exit();
				         }

						        $eventname = trim($_POST['eventname']);
						        $region = trim($_POST['region']);
						        $startdate = trim($_POST['startdate']);
										$enddate = trim($_POST['enddate']);
										$starttime = trim($_POST['starttime']);
										$endtim = trim($_POST['endtime']);
										$description = trim($_POST['description']);
						        $tag = trim($_POST['tag']);

										$eventname = addslashes($eventname);
										$region = addslashes($region);
										$startdate = addslashes($startdate);
										$enddate = addslashes($enddate);
										$starttime = addslashes($starttime);
										$endtim = addslashes($endtim);
										$description = addslashes($description);
										$tag = addslashes($tag);



						         $stmt = $db->prepare("INSERT INTO Event (Event.Title, Event.StartDate, Event.EndDate, Event.StartTime, Event.EndTime, Event.Information, Event.Tags)
										 												VALUES (?, ?, ?, ?, ?, ?, ?)");
						         $stmt->bind_param('siiiiss', $eventname, $region, $startdate, $enddate, $starttime, $endtim, $description, $tag);
						         $stmt->execute();
						         printf("Event created!");
					 }

if (isset($_POST['createevent'])) {
	createEvent();
}

			     ?>

	      </header>




            <div id="content">
