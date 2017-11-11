<?php
  session_start();
  if (!isset($_SESSION['username'])) {
  	header("location:login.php");
  }
?>

<?php
  include("config.php");
  include("header.php");

  $myusername = $_SESSION['username'];


?>
<div id="whitecontent">

<div id="headerwrap">
      <h2 id="aboutheader">Good to see you, <?php echo $myusername?>!</h2>
</div>

<div class="about">
  <p class="aboutintro">
    Welcome to Eventually!
    This is a web application where you can see events hosted nearby you. Go to Browse through the side menu to see what is going on right now, or click the plus button in the header to create your own event.
  </p>
    <h2>Q&amp;A</h2>
      <ul>
        <li>
            <p class="qa">Q</p><p class="question">I'm not sure if I'll go to an event, but I don't want to lose track of it in the feed. Can I add it to a "maybe" list?</p>
            <p class="qa">A</p><p class="answer">Absolutely! This is what the Save button is for. You'll find it on the event's page, and clicking it will save it to your profile. Only you can view this list.</p>
            <hr />
        </li>
        <li>
            <p class="qa">Q</p><p class="question">Why do I have to upload a profile picture? I don't have any photos of myself.</p>
            <p class="qa">A</p><p class="answer">At Eventually you can't be anonymous. This is because our goal is for our users to meet new people. To do this in a safe way, users need to be open about who they are. And don't try to fool us, everyone with a smartphone has taken at least one selfie.</p>
            <hr />
        </li>
        <li>
            <p class="qa">Q</p><p class="question">I misclicked and accidentally attended an event. How do I unattend it?</p>
            <p class="qa">A</p><p class="answer">On your profile you'll find all events you have something to do with; Events you're hosting, attending or have  saved. Go to Attending, find the event and click Cancel on it.</p>
            <hr />
        </li>
        <li>
            <p class="qa">Q</p><p class="question">I've seen someone promote their night club in the feed just about every week. Is this allowed?</p>
            <p class="qa">A</p><p class="answer">No, promoting a business is not allowed on Eventually. This is an application for private events. Our admins scan the feed continuously, and users repeating unallowed actions after being warned get their accounts deleted.</p>
            <hr />
        </li>
      </ul>
    </p>

  <br>
  <p>Got a question of your own? <a href="contact.php">Contact us</a></p>
</div>

<?php
  include("footer.php");
?>
</div>
