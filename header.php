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
								 	<div class="modal-body">
										 <form action="index.php" method="POST">
						           <table id="registerform">
						             <tr>
						               <td><input type="text" name="eventname" class="registerbar" placeholder="Event name" required></td>
						             </tr>
						             <tr>
						               <td>
														 	<select name="select region" form="eventform" placeholder="Select region">
																	<option value="" disabled selected>Select your region</option>
																	<option>1</option>
													        <option>2</option>
													        <option>3</option>
													        <option>4</option>
													 		</select>
													</td>
						             </tr>
						             <tr>
						               <td><input type="password" name="password" class="registerbar" placeholder="Time for event" required></td>
						             </tr>
						             <tr>
						               <td><input type="password" name="repeatpassword" class="registerbar" placeholder="Description of event" required></td>
						             </tr>
						               <td><input type="submit" class="registerbutton" name="submit" value="Register"></td>
						             </tr>
						           </table>
						         </form>
									 </div>

					     </div>
					   </div>

					 </div>

	      </header>




            <div id="content">
