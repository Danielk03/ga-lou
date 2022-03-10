<?php
//require_once "../App/functions.php";
//
////antagligen fel
//$productId = getProductId();
//
//$productDelete = <<<EOD
//DELETE
//FROM products
//WHERE productId = '$productId'
//EOD;
//
//$stmt = db()->prepare($productDelete);
//$stmt->execute();
//// behövs nedan ? vi behöver inte fetcha nått bara executa igentligen?
//$productDelete = $stmt->fetchAll(PDO::FETCH_OBJ);
//
//redirectHome();