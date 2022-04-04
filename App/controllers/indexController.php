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
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
                  integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
                  crossorigin="anonymous">
            <link rel="stylesheet" href="index.css?v=1">
            <title>Document</title>
        </head>
        <body>
        <div class="containerborder">
            <nav class="navbar navbar-light nav-icon-placement">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
            <br>
            <div class="collapse" id="navbarToggleExternalContent">
                <div class="container container-nav" id="container">
                    <button class="navbar-toggler nav-icon-close" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                            aria-expanded="false" aria-label="Toggle navigation"> CLOSE
                    </button>
                    <br>
                    <p class="nav-font"><a href="/products/">produkter</a></p>
                    <p class="nav-font">Dina produkter</p>
                </div>
            </div>
            <?php profilIcon(); ?>
            <i class="bi bi-person-circle"></i>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                    crossorigin="anonymous">
            </script>
        </div>
        <div class="containerborder">
            <div class="center m-above">
                <h1> Välkommen till LoU</h1>
                <p> ****Beskrivning av sidan****</p>
            </div>
            <div class="center m-above">
                <form action="/authe/login">
                    <label for="login" class="form-label">
                        <input class="btn btn-login" type="submit" value="Logga in">
                    </label>
                </form>
                <form action="/authe/register">
                    <label for="register" class="form-label">
                        <input class="btn btn-login" type="submit" value="Registrera dig">
                    </label>
                </form>
            </div>
        </div>
        </body>
        </html>
      <?php
    }
}