<?php
  include("config.php");
  #Can't really make the min date work?
  $date = date('Y-m-d');
?>

<!DOCTYPE html>
	  <html lang="en">
	  <head>
		    <meta charset="UTF-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans:300,400,600|Roboto:300,400,600,700" rel="stylesheet">
	  </head>

<!--formfields should only be required if there is no input from before-->
<div id="editprofile">
    <form method="POST" name="editprofile" action="createprofile.php">
        <h1>Welcome!<br> Create your profile</h1>
          <br>
          <input type="name" name="firstname" placeholder="Firstname" required/>
          <br>
          <input type="name" name="lastname" placeholder="Lastname" required/>
          <br>
          <input type="date" name="bday" min="<?php $date ?>" required/>
          <br>

          <p>Upload your own profile picture:</p>
          <!--Don't really know how to fix this one, heh...-->
          <!--Uploaded pic should get the id of the usr that uploaded the pic and be displayed-->
          <input type="file" name="fileupload" id="fileupload">

          <h3>About me</h3>
          <textarea name="about" placeholder="Tell me something about yourself!"></textarea>
          <br>
          <input type="submit" name="submit" value="Submit" />
    </form>
</div>

</html>
