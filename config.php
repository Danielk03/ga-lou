<?php

$host = "192.168.250.74";
$dbname = "ga-lou";
$user = "ga-lou";
$password = "rödbrunrånarluva";

$conn = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>