<?php

$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "BE21_CR5_animal_adoption_frankAmo";

// create connection
$connect = mysqli_connect($localhost, $username, $password, $dbname);

// check connection
if (!$connect) {
   die("Connection failed");
}