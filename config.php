<?php

#Takes the URL
$url = $_SERVER['REQUEST_URI'];
#Creates an array of strings devided by backslash
$strings = explode('/', $url);
#Takes end string and checks current page
$current_page = end($strings);

#Information to connect to DATABASE
$dbname = 'EventApp';
$dbuser = 'root';
$dbpass = '';
$dbserver = 'localhost';

?>
