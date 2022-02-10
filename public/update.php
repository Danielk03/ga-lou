<?php
require_once "../App/functions.php";

getProductId();

$rules = [
    'productTitle' => FILTER_SANITIZE_STRING,
    'productDescription' => FILTER_SANITIZE_STRING,
    'productTypeId' => FILTER_VALIDATE_INT,
];
$validatedInput = filter_input_array(INPUT_POST, $rules);

$productId = $product ?? 'No product';
$newProductTitle = $validatedInput['productTitle'] ?? null;
$newProductDescription = $validatedInput['productDescription'] ?? null;
$newProductTypeId = $validatedInput['productTypeId'] ?? null;

$errors = [];

if ($validatedInput['productTitle']){
    $newProductTitle = $validatedInput['productTitle'];
} else{
    $errors[] = 'Felaktigt produktnamn';
}
if ($validatedInput['productDescription']){
    $newProductDescription = $validatedInput['productDescription'];
} else{
    $errors[] = 'Felaktig beskrivning';
}
if ($validatedInput['productTypeId']){
    $newProductTypeId = $validatedInput['productTypeId'];
} else{
    $errors[] = 'felaktig produktkategori';
}
if (count($errors)){
    $_SESSION["errors"] = $errors;
    $_SESSION["feilds"] = $_POST;
    redirectBack();
    exit();
}
var_dump($errors);
var_dump($newProductTitle);
var_dump($newProductTypeId);
var_dump($newProductDescription);

$productUpdate = <<<EOD
UPDATE  products 
set productTitle=?, productDescription=?, productTypeId=?
where productId = ?
EOD;

$stmt = db()->prepare($productUpdate);
$stmt->execute([$newProductTitle, $newProductDescription, $newProductTypeId, $productId]);
redirectHome();