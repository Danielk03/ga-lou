<?php

namespace App\controllers;
use App\Database;

class indexController
{
    public function startIndex()
    {
        echo " <a href='/products/'>Till produkterna</a> <br><br><br>";
        echo " <a href='/authe/'>Till authe</a> <br><br><br>";
        echo "index genom routes";

    }
}