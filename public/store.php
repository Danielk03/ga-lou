<?php
require_once "../App/functions.php";

var_dump($_POST);
$productTitle = $_POST["productTitle"] ?? "Namn saknas";
$productDescription = $_POST["productDescription"] ?? "Beskrivning saknas";
$productTypeId = $_POST["productTypeId"] ?? "Fel id";
$userId = 10;
$productId = random_int(0, 100000);

$sql = <<<EOD
insert into products (productTitle, productDescription, productTypeId, userId, productId) 
VALUES(?,?,?,?,?) 
EOD;

$stmt = db()->prepare($sql);
$stmt->execute([$productTitle, $productDescription, $productTypeId, $userId, $productId]);
var_dump($sql);