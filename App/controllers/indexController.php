<?php

namespace App\controllers;
use App\Database;

class indexController
{
    public function startIndex()
    {
       ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
            <link rel="stylesheet" href="index.css?v=1">
            <title>Document</title>
        </head>
        <body>
        <div class="containerborder">
            <nav class="navbar navbar-light nav-icon-placement">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
            <br>
            <div class="collapse" id="navbarToggleExternalContent">
                <div class="container container-nav" id="container">
                    <button class="navbar-toggler nav-icon-close" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation"> CLOSE</button>
                    <br>
                    <p class="nav-font"><a href="/products/">produkter</a></p>
                    <p class="nav-font">Dina produkter</p>
                    <p></p>
                </div>
            </div>
            <!-- fixa så att knappen tar den till sin profil eller log in -->
            <div class="profile-icon-placement">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
            </div>
            <i class="bi bi-person-circle">Person</i>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        </div>
        </body>
        </html>
<?php
        echo "välkomen till lou <br>";
        echo " <a href='/products/'>Till produkterna</a> <br><br><br>";
        echo " <a href='/authe/login'> Logga in</a><br><br>";
        echo " <a href='/authe/register'> Inget konto? registrera dig!</a> <br><br><br>";

    }
}