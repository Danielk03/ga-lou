<?php

namespace App\controllers;
use App\Database;
use Pecee\SimpleRouter\SimpleRouter;

class authController
{
    public function authIndex ()
    {
//        \App\Database::auth();
        // ger inputen / $_GET från url
//        echo input('fisk');
        $userName = $_SESSION["username"]?? null;
        echo "<h1>Välkommen $userName</h1>";
        if (!isset($_SESSION["username"]) || $_SESSION["username"] == null){
            echo "Du är inte inloggad";
            echo "<br><a href='/authe/login/'>Logga in</a><br>";
            echo "<br><a href='/authe/register/'>Registrera Dig!</a><br><br>";
        }
        echo "<a href='/products/'> Till produkterna </a><br>";
        if ($userName){
            echo "<a href='/authe/edit/'> Byt lösenord </a><br>";
            echo "<a href='/authe/logout/'>Logga ut</a>";
        }
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
        <p><input type="text" name="userMail" id="userMail" placeholder="mail" value=""></p>
        <p><input type="number" name="userPhoneNumber" id="userPhoneNumber" placeholder="phone number" value=""></p>
        <p><input type="submit" name="action" value="Registera"></p>

    </form>
    </body>
    </html>
    <?php
    }

    public function editUser()
    {

    \App\Database::auth();


        if(empty($_SESSION['username']) || $_SESSION['username']== null){

            echo "Du måste logga in <br>";
            echo '<a href="/authe/login"> Klicka här för att Logga in <a/></ol> <br>';
            exit();
        }

        var_dump($_SESSION);
        $username=$_SESSION['username'];

        $userInfo = <<<EOD
        select *
        from users
        where username = '$username';
        EOD;

        $stmt = db()->prepare($userInfo);
        $stmt->execute();
        $userInfo = $stmt->fetch();
        var_dump($userInfo);


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
    <form action="/authe/update/" method="post">
        <p><input type="text" name="username" id="username" value=" <?php echo $userInfo->username ?>"></p>
        <p><input type="text" name="password" id="password" value=" <?php echo $userInfo->password?>"</p>
        <p><input type="submit" name="action" value="Spara ändringar"></p>

    </form>
    </body>
    </html>
    <?php
    }

    public function update()
    {
        \App\Database::update();
        echo $_SESSION['username'];

    }
}