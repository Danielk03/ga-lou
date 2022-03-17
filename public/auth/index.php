<?php

require_once "../../App/functions.php";
require_once "../../App/Database.php";

var_dump($_SESSION);

\App\Database::isLoggedIn();
$userName = $_SESSION["username"];

echo "<h1>Välkommen $userName</h1>";
echo "<a href='logout.php'>Logga ut</a>";