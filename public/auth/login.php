<?php
require_once "../../App/functions.php";
require_once "../../App/Database.php";

var_dump($_POST);

\App\Database::auth();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <p><label for="username"></label><input type="text" name="username" id="username" placeholder="username" value="emil"></p>
    <p><label for="password"></label><input type="text" name="password" id="password" placeholder="password" value="EmiBin123"></p>
    <p><input type="submit" name="action" value="login"></p>
</form>
<a href="register.php">Lägg till Användaren</a>
</body>
</html>