<?php
require_once "../App/functions.php";
require_once "../vendor/autoload.php";


var_dump($_GET);
$productId = $_GET["productId"] ?? "Namn saknas";
var_dump($productId);

$productTitle = <<<EOD
SELECT productId, productTitle
from products 
where productId = ?
EOD;

$stmt = db()->prepare($productTitle);
$stmt->execute([$productId]);
$products = $stmt->fetch(PDO::FETCH_OBJ);

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
<?php

echo '<ol><a href="edit.php?productId=',$products->productId,'"> Edit  <a/></ol> <br>';
?>

<body></body>
</html>
