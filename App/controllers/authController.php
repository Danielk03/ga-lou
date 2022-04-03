<?php

namespace App\controllers;

use App\Database;
use Pecee\SimpleRouter\SimpleRouter;

class authController
{
    public function authIndex()
    {
        $userName = $_SESSION["username"] ?? null;
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
        <div class="containerborder">

            <?php
            if (!isset($_SESSION["username"]) || $_SESSION["username"] == null) {
                echo "<div class='center m-top'><h1> Du är inte inloggad</h1></div>";
                echo "<br> <div class='center'> <form action='/authe/login'> 
                       <input class='btn btn-login' type='submit' value='Logga in'>
                       </form>
                       </div>";
                echo "<br> <div class='center mb-4' <form action='/authe/register'> 
                       <input class='btn btn-login' type='submit' value='Registrera dig'>
                       </form>
                       </div>";
            }
            echo "<div class='center m-top'><a href='/products/'</div> Till produkterna </a><br>";
            if ($userName) {
                echo "<div class='center mb-4'><h1>Välkommen ";
                echo $userName . '</h1></div>';
                echo "<br> <div id='container' class='center mb-4'>
                        <form action='/products/user'> 
                        <label class='form-label'>
                       <input class='btn btn-login' type='submit' value='Dina produkter '>
                       </label>
                       </form>
                        <form action='/authe/edit'> 
                       <input class='btn btn-login' type='submit' value='Redigera Profil '>
                       </form>
                       </div>";
                echo "<div class='m-top'><a href='/authe/logout/'>Logga ut</a><br>";
                echo "<a href='/authe/delete/'>Radera konto</a></div>";
            }
            ?>
        </div>
        </body>
        </html>
        <?php

    }

    public function delete()
    {
        $userName = $_SESSION["username"] ?? null;

        $removeUser = <<< EOD
        delete from users
        where username = '$userName';
        EOD;

        $stmt = db()->prepare($removeUser);
        $stmt->execute();

        session_destroy();
        SimpleRouter::response()->redirect('/authe/');
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
        <div class="containerborder">
            <div class="center mb-4 m-top">
                <a href="/"> Tillbaka</a>
                <h1>Logga in</h1>
            </div>
            <form action="" method="post">
                <div class="mb-4">
                    <label for="username" class="form-label">Användarnamn
                        <input type="text" class="form-control" name="username" placeholder="ex.Jonas123">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Löserord
                        <input type="password" class="form-control" name="password" placeholder="******">
                    </label>
                </div>
                <div class="center">
                    <input class="btn btn-login" type="submit" name="login" value="Logga In">
            </form>
            <form action="/">
                <input class="btn btn-cancell" type="submit" value="Avbryt">
            </form>
            <a href="/authe/register/">Registrera dig</a>
        </div>
        </body>
        </html>
        <?php

    }

    public function logout()
    {
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
        <div class="containerborder">
            <div class="center mb-4 m-top">
                <a href="/"> Tillbaka</a>
                <h1> Registrera dig</h1>
            </div>
            <form action="" method="post">
                <div class="mb-4">
                    <label for="username" class="form-label">Användarnamn
                        <input type="text" class="form-control" name="username" id="username" placeholder="ex. Jonas123"
                               value="">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Löserord
                        <input type="password" class="form-control" name="password" id="password" placeholder="*******"
                               value="">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="userMail"> Mail
                        <input type="text" class="form-control" name="userMail" id="userMail"
                               placeholder="ex. jonas@mail.com" value="">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="userPhoneNumber"> Telefonnummer
                        <input type="number" class="form-control" name="userPhoneNumber" id="userPhoneNumber"
                               placeholder="ex. 070123456" value="">
                    </label>
                </div>
                <div class="center">
                    <input class="btn btn-login" type="submit" name="action" value="Registera">
            </form>
            <form action="/">
                <input class="btn btn-cancell" type="submit" value="Avbryt">
            </form>
        </div>
        </body>
        </html>
        <?php
    }

    public function editUser()
    {
        $username = $_SESSION['username'];

        if (empty($username)) {
            echo "Du måste logga in <br>";
            echo '<a href="/authe/login"> Klicka här för att Logga in <a/></ol> <br>';
            exit();
        }

        \App\Database::auth();

        $userInfo = <<<EOD
        select *
        from users
        where username = '$username';
        EOD;

        $stmt = db()->prepare($userInfo);
        $stmt->execute();
        $userInfo = $stmt->fetch();
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
        <div class="containerborder">
            <div class="center mb-4 m-top">
                <a href="/"> Tillbaka</a>
                <h1> Redigera Din Profil</h1>
            </div>
            <form action="/authe/update/" method="post">
                <div class="mb-4">
                    <label for="username" class="form-label">Användarnamn
                        <input type="text" class="form-control" name="username"
                               value="<?php echo $userInfo->username ?>">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Löserord
                        <input type="text" class="form-control" name="password"
                               value="<?php echo $userInfo->password ?>">
                    </label>
                </div>
                <div class="center">
                    <input class="btn btn-login" type="submit" name="spara" value="Spara ändringar">
            </form>
            <form action="/">
                <input class="btn btn-cancell" type="submit" name="Avbryt" value="Avbryt">
            </form>
        </div>
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