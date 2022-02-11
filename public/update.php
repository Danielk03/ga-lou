<?php
require_once "../App/functions.php";

$rules = array(
    'productId'   => [
        'filter' => FILTER_VALIDATE_INT
    ],
    'productTitle'   => FILTER_SANITIZE_STRING,
    'productDescription'   => FILTER_SANITIZE_STRING,
    'productTypeId'   => [
        'filter' => FILTER_VALIDATE_INT,
        'options' => ['min_range'=>0, 'max_range'=>3]

    ]
);
$validateInput = filter_input_array(INPUT_POST, $rules);

$id = filter_input(INPUT_GET,'productId',FILTER_SANITIZE_STRING);
if (!$id){
    redirectHome();
}

$errors = [];
if($validateInput["productTitle"]){
    $title = $validateInput["productTitle"];
} else {
    $errors[] = 'Det blev ett internt fel.';
}
if($validateInput["productDescription"]){
    $description = $validateInput["productDescription"];
} else {
    $errors[] = 'Det blev ett internt fel.';
}
if($validateInput["productTypeId"]){
    $typeId = $validateInput["productTypeId"];
} else {
    $errors[] = 'Det blev ett internt fel.';
}
var_dump($id);
var_dump($typeId);
var_dump($title);
var_dump($description);

if(count($errors)){
    $_SESSION["errors"] = $errors;
    $_SESSION["fields"] = $_POST;
    echo  "fel!!";
    exit();
}

$updateProduct = <<<EOD
UPDATE products
SET productTitle = ?,
    productDescription = ?,
    productTypeId = ? 
WHERE productId = ? 
EOD;

$stmt = db()->prepare($updateProduct);
$stmt->execute([$title, $description, $typeId, $id]);
header("location:/");