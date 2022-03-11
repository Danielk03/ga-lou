<?php

namespace App\controllers;
use App\Database;
use Pecee\SimpleRouter\SimpleRouter;

class authController
{
    public function authIndex ()
    {
        \App\Database::isLoggedIn();
        $userName = $_SESSION["username"]?? null;
        var_dump($userName);
        // ger inputen / $_GET från url
        echo input('fisk');
        echo "<h1>Välkommen $userName</h1>";
        echo "<a href='/products/'> Till produkterna </a>";
        echo "<a href='/authe/logout/'>Logga ut</a>";
    }

    public function login()
    {

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
    <a href="/authe/register/">Lägg till Användaren</a>
    </body>
    </html>
    <?php

    }

    public function logout ()
    {
//        echo "session destroyed";
        session_destroy();
        SimpleRouter::response()->redirect("/authe/");
    }

    public function registerUser()
    {

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
    <?php
    }

    public function editUser()
    {

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
    <form action=" " method="post">
        <p><input type="text" name="username" id="username" placeholder="username" value=""></p>
        <p><input type="password" name="password" id="password" placeholder="password" value=""></p>
        <p><input type="submit" name="action" value="Registera"></p>

    </form>
    </body>
    </html>
    <?php
    }

}