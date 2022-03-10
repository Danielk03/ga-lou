<?php
require_once "../App/functions.php";
require_once "../App/Database.php";
require_once "../vendor/pecee/simple-router/helpers.php";
require_once "../vendor/autoload.php";

session_start();

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;

define('ROOT',dirname(__DIR__));

require_once ROOT.'/routes/routes.php';

SimpleRouter::setDefaultNamespace('\App\Controllers');

SimpleRouter::error(function (Request $request,\Exception $exception) {
    switch ($exception->getCode()) {
        case 404;
            echo '404';
//            SimpleRouter::response()->redirect('/');
            break;
        default;
//            response()->redirect('/');
    }
});

SimpleRouter::start();

