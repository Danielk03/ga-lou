<?php
require_once "../App/functions.php";
require_once "../App/Database.php";
require_once "../vendor/pecee/simple-router/helpers.php";
require_once "../vendor/autoload.php";
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
    <link rel="stylesheet" href="/index.css?v=1">
    <title> </title>
</head>
<body>

</body>
</html>
<?php
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
            SimpleRouter::response()->redirect('/');

            break;
        default;
            response()->redirect('/');
    }
});

SimpleRouter::start();

