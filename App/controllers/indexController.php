<?php

namespace App\controllers;

use App\Database;

class indexController
{
    public function startIndex()
    {
        ?>
        <!doctype html>
        <html lang="sv">
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
            <div class="center m-above">
                <h1> Välkommen till LoU</h1>
                <p> Sveriges bästa lån och utlåningssida</p>
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