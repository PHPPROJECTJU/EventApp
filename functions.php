<?php



/*Header.php-------------------------------------------*/


#fetch regions

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

    $stmt3 = $db->prepare($getregion);
    $stmt3->bind_result($regionid, $showregion);
    $stmt3->execute();

    while ($stmt3->fetch()) {
          echo "<option value='$regionid'>$showregion</option>";
    }
};

#get cities

function getcity(){

    include ("config.php");
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $getcityname = "SELECT City.city_name, City.city_id
              FROM City
              ";

    $stmt4 = $db->prepare($getcityname);
    $stmt4->bind_result($showcityname, $cityid);
    $stmt4->execute();

    while ($stmt4->fetch()) {
          echo "<option value='$cityid'>$showcityname</option>";
    }
};

#get categories

function getcategory(){

    include ("config.php");
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $getcategory = "SELECT Category.Categoryname, Category.CategoryID
              FROM Category
              ORDER BY Category.Categoryname ASC
              ";

    $stmt = $db->prepare($getcategory);
    $stmt->bind_result($getcategoryname, $getcategoryid);
    $stmt->execute();

    while ($stmt->fetch()) {
          echo "<option value='$getcategoryid'>$getcategoryname</option>";
    }
};

#get UserID

function getUserID($username){
    include("config.php");

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
    echo "could not connect: " . $db->connect_error;
    printf("<br><a href=index.php>Return to home page </a>");
    exit();
    }

    $query = "SELECT UserID
              FROM User
              WHERE User.UserName = '{$username}'
              ";

    $stmt9 = $db->prepare($query);
    $stmt9->bind_result($userid);
    $stmt9->execute();
    $stmt9->store_result();
    $stmt9->fetch();

    echo '<INPUT type="hidden" name="userid" value=' . $userid . '>';

}

#creating a new event

function createEvent(){
    include("config.php");

    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
    echo "could not connect: " . $db->connect_error;
    printf("<br><a href=index.php>Return to home page </a>");
    exit();
    }

    $userid = trim($_POST['userid']);
    $eventname = trim($_POST['eventname']);
    $adress = trim($_POST['adress']);
    $region = trim($_POST['region']);
    $cityID = trim($_POST['city']);
    $startdate = trim($_POST['startdate']);
    $enddate = trim($_POST['enddate']);
    $starttime = trim($_POST['starttime']);
    $endtime = trim($_POST['endtime']);
    $description = trim($_POST['description']);
    $categoryID = trim($_POST['categoryID']);

    $userid = addslashes($userid);
    $eventname = addslashes($eventname);
    $adress = addslashes($adress);
    $region = addslashes($region);
    $cityID = addslashes($cityID);
    $startdate = addslashes($startdate);
    $enddate = addslashes($enddate);
    $starttime = addslashes($starttime);
    $endtime = addslashes($endtime);
    $description = htmlentities($description);
    $categoryID = addslashes($categoryID);

    $stmt = $db->prepare("INSERT INTO Event (Event.UserID, Event.Title, Event.StreetAdress, Event.state_id, Event.city_id, Event.StartDate, Event.EndDate, Event.StartTime, Event.EndTime, Event.Information, Event.CategoryID)
    									 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issiisssssi', $userid, $eventname, $adress, $region, $cityID, $startdate, $enddate, $starttime, $endtime, $description, $categoryID);
    $stmt->execute();

    printf("Event created!");

    unset($_POST);
    ?>
      <script>
          window.location.href = "index.php";
      </script>
      <?php

}

/*Event.php-------------------------------------------*/

#showing the event card

function displayEvent(){
  include("config.php");


  $EventID = trim($_GET['EventID']);


      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $query = "SELECT User.UserName, User.ProfilePicture, User.UserID, Event.Title, Event.StartDate, Event.StartTime, Event.Information, Event.StreetAdress
                FROM User
                JOIN Event
                ON User.UserID=Event.UserID
                WHERE Event.EventID=$EventID
                ";

      $stmt = $db->prepare($query);
      $stmt->bind_result($UserName, $ProfilePicture, $UserID, $Title, $StartDate, $StartTime, $Information, $StreetAdress);
      $stmt->execute();


      while ($stmt->fetch()) {
          echo "<a href='index.php#". urlencode($UserID) ."' class='goback'>&larr;</a>";
          echo "<div class='eventpagebox'>";
          echo "<h3 class='profiletitle'>$Title</h3>";
          echo "<span class='pictureandname'>";
          echo "<img src='$ProfilePicture' class='profilepic'/>";
          echo "<a class='username' href='user.php?UserID= " . urlencode($UserID) . " '> $UserName </a>";
          echo "</span>";
          echo "<div class='specifics'>";
          echo "<p><img src='img/place.png' />$StreetAdress</p> <br />";
          echo "<p><img src='img/time.png' />$StartDate kl $StartTime</p>";
          echo "</div>";
          echo "<p class='description'>$Information</p>";
          echo "<form action='' method='POST'>";
          echo "<input type='submit' class='attendsave' name='save' value='Save'>";
          echo "<input type='submit' class='attendsave' name='attend' value='Attend'>";
          echo "</form>";
          echo "</div>";
      }

}

/*---Register.php-----------------------------------------*/

function checkUsername(){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

  if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      printf("<br><a href=index.php>Return to home page </a>");
      exit();
  }

  $username = trim($_POST['username']);
  $username = addslashes($username);

  $query = "SELECT *
            FROM User
            WHERE User.UserName = '{$username}'
            ";

  $stmt8 = $db->prepare($query);
  $stmt8->execute();
  $stmt8->store_result();

  $totalcount = $stmt8->num_rows();

  $stmt8->fetch();

  if (isset($totalcount)) {
        if ($totalcount != 0) {
          echo "Username already exists";
          exit();
        }
  }


};


/*-------------------------createprofile.php--------------------------*/

function finishtheuser(){
      include("config.php");

      @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $UserID = $_SESSION['userid'];

      #Getting the image upload:
      if (isset($_FILES['fileupload'])) {

            $allowedextensions = array('jpg', 'jpeg', 'gif', 'png');

            $extension = strtolower(substr($_FILES['fileupload']['name'], strrpos($_FILES['fileupload']['name'], '.') + 1));

            $error = array ();

            if(in_array($extension, $allowedextensions) === false){
              $error[] = 'Not an allowed file format.';
            }

            if($_FILES['fileupload']['size'] > 1000000){
              $error[]='This file is over the 1MB limit.';
            }

            if(empty($error)){
              move_uploaded_file($_FILES['fileupload']['tmp_name'], "profilepics/user$UserID.$extension");
            } else {
                foreach ($error as $err){
                  echo $err;
                }
            }
      } else {
        echo "not uploaded";
      }

      $firstname = trim($_POST['firstname']);
      $lastname = trim($_POST['lastname']);
      $bday = trim($_POST['bday']);
      $fileupload = "user".$UserID.".".$extension;
      $about = trim($_POST['about']);

      $firstname = addslashes($firstname);
      $lastname = addslashes($lastname);
      $bday = addslashes($bday);
      $fileupload = addslashes($fileupload);
      $about = addslashes($about);

      $stmt = $db->prepare("UPDATE User
                            SET FirstName='$firstname', LastName='$lastname', Birthdate='$bday', ProfilePicture='profilepics/$fileupload', About='$about'
                            WHERE UserID=$UserID");
      $stmt->bind_param('sssss', $firstname, $lastname, $bday, $fileupload, $about);
      $stmt->execute();

      ?>
        <script>
            window.location.href = "index.php";
        </script>
        <?php
  }

/*Event comments*/

#post a new comment

function makeComment($comment){

  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }


  $myusername = $_SESSION['username'];
  $EventID = trim($_GET['EventID']);

    $comment = $comment;
    $comment = htmlentities($comment);
    $comment = mysqli_real_escape_string($db, $comment);

    $commentquery = ("INSERT INTO Comments (Text, EventID, UserName)
                  VALUES (?, ?, ?)
                  ");

    $stmt2 = $db->prepare($commentquery);
    $stmt2->bind_param('sis', $comment, $EventID, $myusername);
    $stmt2->execute();

    unset($_POST);
    ?>
      <script>
          window.location.href = "event.php?EventID=<?php echo $EventID?>";
      </script>
      <?php
}

#getting and displaying comments

function getComment(){
  include("config.php");

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

      if ($db->connect_error) {
          echo "could not connect: " . $db->connect_error;
          printf("<br><a href=index.php>Return to home page </a>");
          exit();
      }

      $EventID = trim($_GET['EventID']);

      $getcomment = ("SELECT Comments.Text, Comments.UserName, User.UserID, User.ProfilePicture
                FROM Comments
                JOIN User
                ON Comments.UserName=User.UserName
                WHERE EventID=$EventID
                ");
      $stmt3 = $db->prepare($getcomment);
      $stmt3->bind_result($Text, $Commenter, $UserID, $Profilepic);
      $stmt3->execute();

      while ($stmt3->fetch()) {
          echo "<div class='comment'>";
          echo "<img src='$Profilepic' class='commenterpic'/>";
          echo "<a href='user.php?UserID= " . urlencode($UserID) . " '> $Commenter </a> says";
          echo "<div id='commentBox'>";
          echo "<div class='commentarrow'></div>";
          echo "<div id='commenttext'><p>";
          echo $Text;
          echo "</p></div>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
      }
}




?>