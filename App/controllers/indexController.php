<?php

namespace App\controllers;

use App\Database;

class indexController
{
    public function startIndex()
    {
        ?>
        <!doctype html>
       <?php
       head();
       ?>
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
        <?php
        endTags();
    }
}