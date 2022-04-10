<?php

function getProductId(){
    $product = filter_input(INPUT_GET,'productId',FILTER_SANITIZE_STRING);
    if (!$product){
        redirectHome();
    }
    return $product;
}

function db():PDO
{
    $host = "192.168.250.74";
    $db = "ga-lou";
    $user = "ga-lou";
    $password = "rödbrunrånarluva";

    $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=UTF8";
    $pdo = new PDO($dsn, $user, $password,[PDO::ATTR_PERSISTENT => true]);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $pdo->exec('PRAGMA foreign_keys = ON');
    return $pdo;
}

function profilIcon() {
    ?>
    <div class="containerborder">
        <div class="profile-icon-placement">
            <a href="/authe/">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-circle"
                 viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd"
                      d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
            </a>
        </div>
        <?php
}
function navbar(){
    ?>
    <div class="collapse" id="navbarToggleExternalContent">
            <div class="container-nav" id="container">
                <button class="navbar-toggler nav-icon-close" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                        aria-expanded="false" aria-label="Toggle navigation"> CLOSE
                </button>
                <br>
                <p class="nav-font"><a id="a-navbar" href="/products">Hitta produkter</a></p>
                <p class="nav-font"><a id="a-navbar" href="/products/user">Dina produkter</a></p>
                <p class="nav-font"><a id="a-navbar" href="/products/upload">Skapa annons</></p>
            </div>
        </div>
        <?php
}

function redirectHome():void{
    header('Location:/');
    exit();
}
function redirectProfile():void{
    header('Location:/Profile/');
}

function redirectBack ():void {
    redirect($_SERVER["HTTP_REFERER"]);
    exit();
}