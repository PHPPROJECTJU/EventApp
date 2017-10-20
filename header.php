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
												 <form action="index.php" method="POST">
								           <table id="eventform">
								             <tr>

								               <td>Name of Event<input type="text" name="eventname" class="registerbar" placeholder="Name of Event" required></td>
								             </tr>
								             <tr>
								               <td>Select your region
																 	<select name="region" form="eventform" placeholder="Select region">
																			<option value="" disabled selected>Select your region</option>
																			<?php
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
															                  echo "<option>$showregion</option>";
															              }
															         ?>
															 		</select>
															</td>
								             </tr>
														 <tr>
								               <td>Start date<input type="date" name="startdate" class="registerbar" placeholder="Time for event" required></td>
								             </tr>
														 <tr>
															 	<td>End date<input type="date" name="enddate" class="registerbar" placeholder="Time for event" required></td>
								             </tr>
								             <tr>
								               <td>Start time<input type="time" name="starttime" class="registerbar" placeholder="Time for event" required></td>
								             </tr>
														 <tr>
															 	<td>End time<input type="time" name="endtime" class="registerbar" placeholder="Time for event" required></td>
								             </tr>
								             <tr>
								               <td>Describe your event<input type="textarea" name="description" class="registerbar" placeholder="Description of event" required></td>
														 <tr>
								               <td>Select tags
																 	<select name="tag" form="eventform" placeholder="Select tags">
																			<option value="" disabled selected>Select tags</option>
															        <option>First option</option>
															 		</select>
															</td>
								             </tr>
														 </tr>
															 <td><input type="submit" class="registerbutton" name="submit" value="Create event"></td>
														 </tr>
								           </table>
								         </form>
									 </div>


					   </div>

					 </div>

					 <?php
			     if (isset($_POST['submit'])) {
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



			         # Open the database using the "librarian" account
			     @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

			         if ($db->connect_error) {
			             echo "could not connect: " . $db->connect_error;
			             printf("<br><a href=index.php>Return to home page </a>");
			             exit();
			         }

			         // Prepare an insert statement and execute it
			         $stmt = $db->prepare("INSERT INTO Event (Event.Title, Event.StartDate, Event.EndDate, Event.StartTime, Event.EndTime, Event.Information, Event.Tags) VALUES (?, ?, ?, ?, ?, ?, ?)");
			         $stmt->bind_param('sssssss', $eventname, $region, $startdate, $enddate, $starttime, $endtim, $description, $tag);
			         $stmt->execute();
			         printf("<br><br><br><br>User Added!");
			         //exit;
			     }

			     // Not a postback, so present the book entry form
			     ?>

	      </header>




            <div id="content">
