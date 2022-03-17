<?php

namespace App\controllers;
use App\Database;

class indexController
{
    public function startIndex()
    {
        echo "välkomen till lou <br>";
        echo " <a href='/products/'>Till produkterna</a> <br><br><br>";
        echo " <a href='/authe/login'> Logga in</a><br><br>";
        echo " <a href='/authe/register'> Inget konto? registrera dig!</a> <br><br><br>";
//        echo "index genom routes";
    }
}