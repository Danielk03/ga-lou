<?php
require_once "../App/functions.php";

var_dump($_POST);
$productTitle = $_POST["productTitle"] ?? "Namn saknas";
$productDescription = $_POST["productDescription"] ?? "Beskrivning saknas";
$productTypeId = $_POST["productTypeId"] ?? "Fel id";
$productId = random_int(0, 100000);

$sql = <<<EOD
insert into products (productTitle, productDescription, productTypeId, productId) 
VALUES(?,?,?,?) 
EOD;

$stmt = db()->prepare($sql);
$stmt->execute([$productTitle, $productDescription, $productTypeId, $productId]);
var_dump($sql);
header("location: /");