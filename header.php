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
include("functions.php");

$date = date('Y-m-d');


if (!isset($_SESSION['username'])) {
	header("location:login.php");
}

$username = $_SESSION['username'];

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
												<li><a href="profile.php"><?php echo "<img src='$ProfilePicture' id='menuprofilepic'/>"; ?></a></li>
												<li><img src="img/user-32.png" class="menuicons" /><a class ="slide-effect" id="<?php echo ($current_page == 'profile.php') ? 'active' : NULL ?>" href="profile.php"><?php echo $username; ?></a></li>
												<li><a href="logout.php" id="logout2"></a></li>
							  </ul>
										</div>

								<ul id="menuitems">
								<li><img src="img/literature-32.png" class="menuicons" /><a class ="slide-effect" id="<?php echo ($current_page == 'index.php' || $current_page == '') ? 'active' : NULL ?>" href="index.php">Browse</a></li>
								<li><img src="img/info-32.png" class="menuicons" /><a class ="slide-effect" id="<?php echo ($current_page == 'about.php') ? 'active' : NULL ?>" href="about.php">About</a></li>
								<li><img src="img/mail-2-32.png" class="menuicons" /><a class ="slide-effect" id="<?php echo ($current_page == 'contact.php') ? 'active' : NULL ?>" href="contact.php">Contact</a></li>
								<li><img src="img/account-logout-32.png" class="menuicons" /><a class ="slide-effect" href="logout.php" id="logout1">Logout</a></li>
							</ul>
						</nav>

						<div id="headbox">
								 <div id="hamb" onclick="openNav()" title="Menu">&#9776;</div>
								 <a title="Start page" class="logolink" href="index.php"><img class="logo" src="img/eventually.png"/></a>
									<div id="myBtn" class="createeventbutton" title="Create event">
											 	<div class="theplus">+</div>
									</div>
					 </div>
<!--Everything event modal-->

<div id="myModal" class="modal">
			<div class="modal-content">
					<div class="modal-header">
							<span class="close">&times;</span>
							<h2 class="createeventheader">New event</h2>
					</div>

					<div class="modal-body">
							<form action="" method="POST">
									<div id="eventform">

										<?php
												getUserID($username);
										 ?>

											<div class="row">
													<h4 class="eventheaders">
														What?
													</h4>
													<input type="text" name="eventname" class="eventregisterbar" placeholder="Best birthday ever" required>
											</div>
											<div class="row">
												<h4 class="eventheaders">
													Where?
												</h4>
													<input type="text" name="adress" class="eventregisterbar" placeholder="Fortunagatan 16B" required>
											</div>
											<div class="row">

													<select name="region" placeholder="Select region" onchange="getId(this.value);">
															<option value="" disabled selected>Select region</option>
																	 <?php
																			getregions();
																		?>
													</select>
											</div>
											<script>
									        function getId(val){
									          console.log(val)
									          //$theID = alert(hej);
									          $.ajax({
									              type: "POST",
									               url: "AjaxGetCities.php",
									               data: "state_id="+val,
									               success: function(data){
									              $("#cityList").html(data);
									               }
									          });
									        }

									    </script>
											<div class="row">

													<select name="city" id="cityList">
														<option value="" disabled selected>Select city</option>

									            <?php
									            include ("AjaxGetCities.php");
									            getcity(val);

									            ?>

									        </select>
											</div>

											<div class="row">
												<h4 class="eventheaders">
													When?
												</h4>
													<div class="innerdatewrap">

															<p>Start date</p>
															<input type="date" name="startdate" class="firsttime" placeholder="Time for event" min="<?php echo $date;?>" required>
													</div>
													<div class="innerdatewrap">
															<p>Start time</p>
															<input type="time" name="starttime" class="test" placeholder="Time for event" required>
													</div>
											</div>
											<div class="row">
													<div class="innerdatewrap">
															<p>End date</p>
															<input type="date" name="enddate" class="test" placeholder="Time for event" min="<?php echo $date;?>" required>
													</div>
													<div class="innerdatewrap">
															<p>End time</p>
															<input type="time" name="endtime" class="secondtime" placeholder="Time for event" required>
													</div>
											</div>
											<div class="row">
												<h4 class="eventheaders">
													How?
												</h4>
												<!--Following function where we count characters in text field is based on http://www.java-samples.com/showtutorial.php?tutorialid=733 friday 10 nov 2017-->
															<textarea maxlength="500" rows="4" cols="80" type="textarea" name="description" class="eventregisterbartext" placeholder="Everything you need to know about my event..." onblur="textCounter(this,this.form.counter,500);" onkeyup="textCounter(this,this.form.counter,500);" required></textarea>
															<br>
															<div class="countwrap">
																<input class="charcount" onblur="textCounter(this.form.recipients,this,500);" disabled  onfocus="this.blur();" tabindex="999" maxlength="3" size="3" value="500" name="counter">
																<p class="charlefttext">characters left: </p>
															</div>
															<script>
															function textCounter( field, countfield, maxlimit ) {
																	 if ( field.value.length > maxlimit ) {
																	  field.value = field.value.substring( 0, maxlimit );
																	  field.blur();
																	  field.focus();
																	  return false;
																	 } else {
																	  countfield.value = maxlimit - field.value.length;
																	 }
															}
															</script>
											</div>
											<div class="row">
												<h4 class="eventheaders">
													Categories
												</h4>
															<select name="categoryID" placeholder="Select category">
																	<option value="">Select category</option>
																	 <?php
																			getcategory();
																		?>
															 </select>
											</div>
											<div>
													<input type="submit" class="colorblockbutton" name="createevent" value="Create event">
												</div>
								</div>
						</form>
			</div>
</div>
</div>

<!--create new event-->

<?php
if (isset($_POST['createevent'])) {
		createEvent();
}
?>

</header>

<section id="content">
