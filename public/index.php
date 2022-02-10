<?php
require_once "../vendor/autoload.php";
require_once "../vendor/pecee/simple-router/helpers.php";

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::setDefaultNamespace('\App\controllers');

require_once "../App/route.php";
echo "this is index.php";

SimpleRouter::error(function (Request $request, Exception $exception) {
    switch ($exception->getCode()) {
        case 404;
            echo '404';
//            SimpleRouter::response()->redirect('/');
            break;
        default;
            response()->redirect('/');
    }
});

SimpleRouter::start();

////TWIGG
//$loader = new \Twig\Loader\FilesystemLoader('public');
//$twig = new \Twig\Environment($loader,[]);
//
//$template = $twig->load('index.twig');


function db():PDO
{
    $host = "192.168.250.56";
    $db = "ga-lou";
    $user = "ga-lou";
    $password = "rödbrunrånarluva";

    $dsn = "mysql:host=$host;port=3306;dbname=$db";
    $pdo = new PDO($dsn, $user, $password);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $pdo->exec('PRAGMA foreign_keys = ON');
    return $pdo;
}



echo '<ol><a href="auth/index.php"> Auth<a/></ol> <br>';

$productType = <<<EOD
select *
from productTypes;
EOD;

$stmt = db()->prepare($productType);
$stmt->execute();
$productTypes = $stmt->fetchAll();
var_dump($productTypes);

$query = <<<EOD
select * from userInfo;
EOD;

$stmt = db()->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll();
var_dump($results);

$products = <<<EOD
select * from products;
EOD;

$stmt = db()->prepare($products);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_OBJ);
var_dump($products);


//Fixa så att koden kan registera vem användaren är och vad dens userId är så att vi kan implementera de.
$userId = 10;
echo '<a href="/upload.php?user=', $userId, '"> Lägg till din egna annons <a/> <br>';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h3> Add your own product</h3>

<?php
foreach ($products as $product) {
    echo '<ol><a href="details.php?productId=', $product->productId, '"> läs mer om ', $product->productTitle, '<a/></ol> <br>';
    echo '<ol><a href="delete.php?productId=',$product->productId,'"> Tabort produkten <a/></ol> <br>';
}
?>
</body>
</html>
