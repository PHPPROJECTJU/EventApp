<?php
  include("config.php");
  include("functions.php");

  ob_start();
?>

<!DOCTYPE html>
	  <html lang="en">
	  <head>
		    <meta charset="UTF-8">
	      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <link rel="stylesheet" href="css/main.css">
	      <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,600,700,900|Noto+Sans:300,400,700" rel="stylesheet">
        <script type="text/javascript" src="js/jquery.min.js"></script>

	  </head>

	  <body id="notloggedin">
		    <main id="main">

<div>

      <a id="aboutbutton">About</a>
      <div id="aboutBox">
          <div class="arrow"></div>
          <div id="about">
              <p>Welcome to Eventually!<br>This is a web application where you can see events hosted nearby. Register and create an event you too. Eventually you'll get some new friend!</p>
          </div>
      </div>
        <img src="img/event_ually.png" class="startlogo"/>

        <form action="register.php" method="POST">
          <table id="registerform">
            <tr>
              <td><input type="text" name="username" class="registerbar" placeholder="Username" required></td>
            </tr>
            <tr>
              <td><input type="email" name="email" class="registerbar" placeholder="E-mail address" required></td>
            </tr>
            <tr>
              <td class="qwrap"><input type="password" name="password" class="registerbar" placeholder="Password" required><img src="img/question.png" class="question2" id="passwordquestion" onclick="showPassReqs()"/>
                <div id="PassBox">
                    <div class="arrow2"></div>
                    <div id="PassAbout">

                        <p>Required:<br>&rarr;Lowercase, uppercase and at least one number.<br>&rarr;Use at least 8 characters.</p>
                    </div>
                </div>
              </td>

            </tr>
            <tr>
              <td><input type="password" name="repeatpassword" class="registerbar" placeholder="Repeat password" required></td>
            </tr>
              <td><input type="submit" class="blockbutton" name="submit" value="Register"></td>
            </tr>

          </table>
        </form>

              <p class="already">Already registered? <a href="login.php" class="transparentbutton">Sign in</a></p>

    </div>
<script type="text/javascript" src="js/menu.js"></script>

<?php

if (isset($_POST['submit'])) {
  registerUser();
}

?>
<script>
$('#aboutBox').css("display", "none");

$(document).on('click', function(e) {
if ( $(e.target).closest('#aboutbutton').length ) {
    $("#aboutBox").css("display", "block");
}else if ( ! $(e.target).closest('#aboutBox').length ) {
    $('#aboutBox').css("display", "none");
}
});

$('#PassBox').css("display", "none");

$(document).on('click', function(e) {
if ( $(e.target).closest('#passwordquestion').length ) {
    $("#PassBox").css("display", "block");
}else if ( ! $(e.target).closest('#PassBox').length ) {
    $('#PassBox').css("display", "none");
}
});


</script>
</main>
</body>

</html>
