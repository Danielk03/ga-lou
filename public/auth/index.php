<?php
session_start();
var_dump($_SESSION);
require_once "../../App/Database.php";


\App\Database::isLoggedIn();
$userName = $_SESSION["username"];

echo "<h1>Välkommen $userName</h1>";
echo "<a href='logout.php'>Logga ut</a>";