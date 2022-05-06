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
        <?php head();
        navbarButton();
        profilIcon();

        if (!isset($_SESSION["username"]) || $_SESSION["username"] == null) {
            echo "<div class='center m-top'><h1> Du är inte inloggad</h1></div>";
            echo "<br> <div class='center'> <form action='/authe/login'> 
                       <input class='btn btn-login' type='submit' value='Logga in'>
                       </form>
                       </div>";
            echo "<br> <div class='center mb-4'>
                        <form action='/authe/register'> 
                       <input class='btn btn-login' type='submit' value='Registrera dig'>
                       </form>
                       </div>";
            exit();
        } ?>
        <div class='center m-top'>
            <a href="/products/"> Till produkterna </a><br>
            <h1>Välkommen <?php echo $userName; ?> </h1>
        </div>
        <br>

        <div id='container' class='center mb-4'>
            <form action='/products/upload'>
                <label class='form-label'>
                    <input class='btn btn-login' type='submit' value='Lägg till annons '>
                </label>
            </form>
            <form action='/products/user'>
                <label class='form-label'>
                    <input class='btn btn-login' type='submit' value='Dina produkter '>
                </label>
            </form>
            <form action='/authe/edit'>
                <input class='btn btn-login' type='submit' value='Redigera Profil '>
            </form>
        </div>
        <div class='m-top center'><a href='/authe/logout/'>Logga ut</a><br>
            <a href='/authe/delete/'>Radera konto</a>
        </div>
        <?php
        navbar();
        script();
        endTags();
    }

    public function delete()
    {
        \App\Database::isLoggedIn();
        $userName = $_SESSION["username"] ?? null;

        $removeUser = <<< EOD
        delete from users
        where username = '$userName';
        EOD;
        $stmt = db()->prepare($removeUser);
        $stmt->execute();
//        session_destroy();
//        SimpleRouter::response()->redirect("/authe/");
//        exit();
        ?>
        <!--        bekräfta att man verkligen vill radera sitt konto. inget händer när man har tryckt på någon av knapparna. De borde visa
                    en post action och därmed fungera -->

        <!doctype html>
        <?php head();
        navbarButton();
        profilIcon();
        var_dump($_POST);
        ?>
            <div id='container' class='m-top center mb-4'>
                <form method="post" action=" ">
                    <label class='form-label'> Vill du verkligen radera ditt konto?
                        <div class="m-above">
                            <input class='btn btn-login' name="deleteAccount" type='submit' value='Ta bort konto'>
                        </div>
<!--                        <div class="m-above">-->
<!--                            <input class='btn btn-cancell' name="back" type='submit' value='Tillbaka'>-->
<!--                        </div>-->
                    </label>
                </form>
            </div>
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'post') {
            if (isset($_POST['deleteAccount'])) {
                $stmt = db()->prepare($removeUser);
                $stmt->execute();
                echo 'Ditt konto har raderats';
                session_destroy();
                ?>
                <div id='container' class='center mb-4'>
                    <form action='/authe/'>
                        <label class='form-label'>
                            <input class='btn btn-login' type='submit' value='Tillbaka'>
                        </label>
                    </form>
                </div>
                <?php
                endTags();
            } else if (isset($_POST['back'])) {
                SimpleRouter::response()->redirect("/authe/");
            }
        }

    }

    public function login()
    {

        \App\Database::auth();
        ?>
        <!doctype html>
        <?php head();
        navbarButton();
        profilIcon();
        ?>
        <div class="center mb-4 m-top">
            <a href="/"> Tillbaka</a>
            <h1>Logga in</h1>
        </div>
        <form action=" " method="post">
            <div class="mb-4">
                <label for="username" class="form-label">Användarnamn
                    <input type="text" id="username" class="form-control" name="username" placeholder="ex.Jonas123">
                </label>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Löserord
                    <input type="password" id="password" class="form-control" name="password" placeholder="******">
                </label>
            </div>
            <div class="center">
                <input class="btn btn-login" type="submit" name="login" value="Logga In">
            </div>
        </form>
        <form action="/">
            <div class="center">
                <input class="btn btn-cancell" type="submit" value="Avbryt">
            </div>
        </form>
        <div class="center m-above">
            <a href="/authe/register/">Registrera dig</a>
        </div>
        <?php
        navbar();
        script();
        endTags();
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
        <?php
        head();
        navbarButton();
        profilIcon();
        ?>
        <div class="center mb-4 m-top">
            <a href="/"> Tillbaka</a>
            <h1> Registrera dig</h1>
        </div>
        <form action="  " method="post">
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
            </div>
        </form>
        <form action="/">
            <div class="center">
                <input class="btn btn-cancell" type="submit" value="Avbryt">
            </div>
        </form>
        <?php
        navbar();
        script();
        endTags();
    }

    public function editUser()
    {
        \App\Database::isLoggedIn();

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
        <?php head();
        navbarButton();
        profilIcon();
        ?>

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
                           value=" ">
                </label>
            </div>
            <div class="center">
                <input class="btn btn-login" type="submit" name="spara" value="Spara ändringar">
        </form>
        <form action="/">
            <input class="btn btn-cancell" type="submit" name="Avbryt" value="Avbryt">
        </form>
        </div>
        <?php
        navbar();
        script();
        endTags();
    }

    public function update()
    {
        \App\Database::isLoggedIn();
        \App\Database::update();
    }
}