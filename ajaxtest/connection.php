<?php
$dbname = 'EventApp';
$dbuser = 'root';
$dbpass = '';
$dbserver = 'localhost';

@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

            if ($db->connect_error) {
                echo "could not connect: " . $db->connect_error;
                printf("<br><a href=index.php>Return to home page </a>");
                exit();
            }


 ?>
