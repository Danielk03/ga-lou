<?php
require_once "../App/functions.php";

$productTypes = <<<EOD
select * 
from productTypes 
EOD;

$stmt = db()->prepare($productTypes);
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

<form action="store.php" method="post">
    <label for=""></label><select name="productTypeId" id="">
        <?php foreach ($productTypes as $productType){

            echo '<option value="'. $productType->productTypeId.'">'. $productType->productTypeName.'</option>';
        }?>
    </select>
    <input type="submit">
    <input type="text" name="productTitle" placeholder="Skriv din artikels titel">
    <input type="text" name="productDescription" placeholder="Skriv artikelns beskrivning här " >
<!--Lägg till så användaren kan skicka in en bild!-->
</form>
</body>
</html>