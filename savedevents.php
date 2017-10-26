<?php
  session_start();
?>
<?php
  include("config.php");
  include("header.php");
?>

<!--myprofileheader could be included, but then we wouldn't be able to have it active at the same time as the lower tabs-->

<header id="myprofileheader">

    <nav id="profileorevents">
        <ul>
            <li><a href="profile.php">View profile</a></li>
            <li><a id="active" href="myevents.php">My events</a></li>
        </ul>
    </nav>
</header>

<?php
  include("myeventsheader.php");
?>

<?php
  include("footer.php");
?>
