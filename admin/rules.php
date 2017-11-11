<?php
  session_start();
  if (!isset($_SESSION['adminusername'])) {
    header("location:login.php");
  }
?>

<?php
  include("config.php");
  include("header.php");
?>

<div id="whitecontent">

<!-- <div id="headerwrap">
      <h2 id="aboutheader">Rules and guidelines for Admin</h2>
</div> -->

<div class="about">
  <p class="aboutintro">
    <strong>Welcome to the rules and guidelines for Admins</strong> <br>
    <em>This guide will help you understand how to use the admin-site and how to administrade users and events</em>
  </p>
    <h2>Rules and Guidelines</h2>
      <ul>
        <li>
            <p class="qa"></p><p class="question">Purpose</p>
            <p class="qa"></p><p class="answer">The purpose of admin is to be able to check and delete inappropiate users and events that have been published on the site Eventually. We do this to ensure the quality, professionalism and the trustworthyness of the website.</p>
            <hr />
        </li>
        <li>
            <p class="qa"></p><p class="question">Event tab</p>
            <p class="qa"></p><p class="answer">On the event tab the admin is able to see all published events on Eventually. To read more or delete event click on the event. In the event the admin has the possibility to delete event by clicking on the x.</p>
            <hr />
        </li>
        <li>
            <p class="qa"></p><p class="question">User tab</p>
            <p class="qa"></p><p class="answer">On the user tab the admin is able to see all registered users of Eventually. To read more or delete user click on the user profile. In the user profile the admin has the possibility to delete user by clicking on the x.</p>
            <hr />
        </li>
        <li>
            <p class="qa"></p><p class="question">Rules</p>
            <p class="qa"></p><p class="answer">- Inappropriate users should be deleted<br>- Inappropriate events should be deleted<br>- Sceptical events should be checked to ensure trustworthyness<br>- Sceptical users should be checked to ensure trustworthyness</p>
            <hr />
        </li>
      </ul>
    </p>

  <br>
  <p>Better safe than sorry! Something you are unsure about? <a href="">Contact the head admin</a></p>
</div>

<?php
  include("footer.php");
?>
