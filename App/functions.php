<?php
//echo dirname(__DIR__);
require_once "../vendor/autoload.php";
session_start();

function getProductId(){
    $product = filter_input(INPUT_GET,'productId',FILTER_SANITIZE_STRING);
    if (!$product){
        redirectHome();
    }
    return $product;
}

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

//function redirect(string $where):void{
//    header('Location: $where');
//    exit();
//}

function redirectHome():void{
    header('Location:/');
    exit();
}
function redirectProfile():void{
    header('Location:/Profile/');
}

function redirectBack ():void {
    redirect($_SERVER["HTTP_REFERER"]);
    exit();
}