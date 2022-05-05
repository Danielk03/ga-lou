<?php

function getProductId()
{
    $product = filter_input(INPUT_GET, 'productId', FILTER_SANITIZE_STRING);
    if (!$product) {
        redirectHome();
    }
    return $product;
}

function db(): PDO
{
    $host = "192.168.250.74";
    $db = "ga-lou";
    $user = "ga-lou";
    $password = "rödbrunrånarluva";

    $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=UTF8";
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_PERSISTENT => true]);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $pdo->exec('PRAGMA foreign_keys = ON');
    return $pdo;
}

function profilIcon()
{
    ?>
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

function navbarButton()
{
    ?>
    <div class="containerborder">
    <nav id="products" class="navbar navbar-light nav-icon-placement">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <?php
}

function navbar()
{
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

function script()
{
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous">
    </script>
    <?php
}

function head()
{
    ?>
        <html lang="sv">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
                  integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
                  crossorigin="anonymous">
            <link rel="stylesheet" href="../index.css?v=1">
            <title>Produkter</title>
        </head>
        <body>
    <?php
}

function endTags(){
    ?>
        </body>
        </html>
        <?php
}

function redirectHome(): void
{
    header('Location:/');
    exit();
}

function redirectProfile(): void
{
    header('Location:/Profile/');
}

function redirectBack(): void
{
    redirect($_SERVER["HTTP_REFERER"]);
    exit();
}