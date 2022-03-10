<?php
require_once "../../App/functions.php";
require_once "../../App/Database.php";

var_dump($_SESSION);

\App\Database::register();

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
    <p><input type="text" name="username" id="username" placeholder="username" value=""></p>
    <p><input type="password" name="password" id="password" placeholder="password" value=""></p>
    <p><input type="submit" name="action" value="Registera"></p>

</form>
</body>
</html>
