<?php

namespace App\controllers;
use App\Database;
use PDO;
//require_once "../../App/functions.php";

class productsController
{

    public function index()
    {
        return " visa alla posts";

    }

    public function showOne(string $ProductId)
    {
        return " visa en posts med id $ProductId";

    }

    public function edit(string $ProductId)
    {
        // hämta data från en post
        //fyll i formulär
        //skicka till /posts/$id/update med POST
        return " redigera en posts med id $ProductId";
    }

    public function update(string $ProductId)
    {
        // läsa in data
        //validera data
        //spara mot db
        // redirect yillbaka till /posts/{id} med get
        return " spara ändringar med en posts med id $ProductId";
    }

    public function upload()
    {
        //fyll i formulär
        //skicka til /posts/ med post

        $host = "192.168.250.74";
        $db = "ga-lou";
        $user = "ga-lou";
        $password = "rödbrunrånarluva";

        $dsn = "mysql:host=$host;port=3306;dbname=$db";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        $productTypes = <<<EOD
select *
from productTypes
EOD;

        $stmt = Database::getInstance()->getPDO()->prepare($productTypes);
        $stmt->execute();
        $productTypes = $stmt->fetchAll();
        var_dump($productTypes)

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

        <form action="store" method="post">
            <select name="productTypeId" id="">
                <?php foreach ($productTypes as $productType) {

                    echo '<option value="' . $productType->productTypeId . '">' . $productType->productTypeName . '</option>';
                } ?>
            </select>
            <input type="submit">
            <input type="text" name="productTitle" placeholder="Skriv din artikels titel">
            <input type="text" name="productDescription" placeholder="Skriv artikelns beskrivning här ">
            <!--Lägg till så användaren kan skicka in en bild!-->
        </form>
        </body>
        </html>
        <?php
        return " skapa en ny post i formulär";

    }

    public function store()
    {
        // läsa in data
        //validera data
        //spara mot db
        // redirect yillbaka till /posts med get
        var_dump($_POST);
        $host = "192.168.250.74";
        $db = "ga-lou";
        $user = "ga-lou";
        $password = "rödbrunrånarluva";

        $dsn = "mysql:host=$host;port=3306;dbname=$db";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        var_dump($_POST);
        $productTitle = $_POST["productTitle"] ?? "Namn saknas";
        $productDescription = $_POST["productDescription"] ?? "Beskrivning saknas";
        $productTypeId = $_POST["productTypeId"] ?? "Fel id";

        $productId = 10;
        $userId = 1;
        $sql = <<<EOD
insert into products (productTitle, productDescription, productTypeId, userId, productId) 
VALUES(?,?,?,?,?) 
EOD;

        $sql2 = <<<EOD
select * 
        from userId
EOD;


//        $stmt = db()->prepare($sql);
        $stmt = Database::getInstance()->getPDO()->prepare($sql);
        $stmt->execute([$productTitle, $productDescription, $productTypeId, $userId, $productId]);
        var_dump($sql);

        $stmt = Database::getInstance()->getPDO()->prepare($sql2);
        $stmt->execute($sql2);
        var_dump($sql2);
//        $pdo = null;
        return "lägg till ny utifrån formulär";
    }


    public function delete(string $ProductId)
    {

        // läsa in datafrån url
        //validera data
        //spara mot db
        // redirect yillbaka till /posts/{id} med get
        return " ta bort 1 ";
    }
}