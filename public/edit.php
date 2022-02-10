<?php
require_once "../App/functions.php";


$product = filter_input(INPUT_GET,'productId',FILTER_SANITIZE_STRING);
var_dump($product);
if (!$product){
    redirectHome();
    exit();
}


$errors = $_SESSION["errors"] ?? false;
$fields = $_SESSION["fields"] ?? [];

$productType = <<<EOD
SELECT productTypeId, productTypeName
from productTypes
EOD;

$stmt = db()->prepare($productType);
$stmt->execute();
$productTypes = $stmt->fetchAll(PDO::FETCH_OBJ);


$productDesc = <<<EOD
SELECT productDescription, productTitle, productId
from products
where productId = $product;
EOD;

$stmt = db()->prepare($productDesc);
$stmt->execute();
$productValues = $stmt->fetch(PDO::FETCH_OBJ);
var_dump($productValues);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
</head>
<body>
<?php
if ($errors){
    foreach ($errors as $errorMSG){
        echo "<p> $errorMSG </p>";
    }
}
?>
<form action="update.php?productId=<?php echo $product ?>" method="post">
    <label>
        <input type="text" name="productTitle" value="<?php echo $productValues->productTitle ?> ">
    </label>
    <label>
        <input type="text" name="productDescription" value="<?php echo $productValues->productDescription;?>"
    </label>
    <label>
        <select name="productTypeId" id="">
            <?php foreach ($productTypes as $productType) {
                echo '<option value=' . $productType->productTypeId . '>'. $productType->productTypeName .' </option > ';}
            ?>
        </select>
    </label>
    <input type="submit">
</form>

</body>
</html>