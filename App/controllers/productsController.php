<?php

namespace App\controllers;
use App\Database;
use PDO;
use Pecee\SimpleRouter\SimpleRouter;

class productsController
{
    public function productIndex()
    {
        \App\Database::auth();

        $userName = $_SESSION["username"];
        echo "hej $userName";
        echo '<ol><a href="/authe/"> Auth // Logga in <a/></ol> <br>';

        $productType = <<<EOD
        select *
        from productTypes;
        EOD;

        $stmt = db()->prepare($productType);
        $stmt->execute();
        $productTypes = $stmt->fetchAll();
//        var_dump($productTypes);

        $query = <<<EOD
        select * from userInfo;
        EOD;

        $stmt = db()->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();
//        var_dump($results);

        $products = <<<EOD
        select * from products
        where username = ?;
        EOD;

        $stmt = db()->prepare($products);
        $stmt->execute([$userName]);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
//        var_dump($products);

        echo "<h3> Lägg till din egna annons</h3>";
//        echo '<a href="/upload.php?user=', $userName, '"> Här<a/> <br>';
//        echo '<a href="/products/upload/?='. $userName. '"> Här<a/> <br>';
        echo '<a href="/products/upload/"> Lägg till annons<a/> <br>';
        echo "dina produkter";
        foreach ($products as $product) {
            echo '<ol><a href="/products/details/'. $product->productId. '"> läs mer om '. $product->productTitle, '<a/></ol> ';
            echo '<ol><a href="/products/delete/'. $product->productId. '"> Tabort produkten <a/></ol> <br>';
        }
    }

    public function delete(string $ProductId)
    {

        $productId = filter_input(INPUT_GET,'url',FILTER_SANITIZE_STRING);
        $product = ltrim($productId, "/products/delete/");
        if (!$product || !$productId){
//            redirectHome();
            echo "inget p ID";
        }
        $productDelete = <<<EOD
            DELETE 
            FROM products
            WHERE productId = '$product'
           EOD;

        $stmt = db()->prepare($productDelete);
        $stmt->execute();
//        $productDelete = $stmt->fetchAll(PDO::FETCH_OBJ);
        redirectBack();
    }

    public function details()
    {
        $productId = filter_input(INPUT_GET,'url',FILTER_SANITIZE_STRING);
        $product = ltrim($productId, "/products/details/");
        if (!$product || !$productId){
//            redirectHome();
            echo "inget p ID";
        }
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

//    echo "<ol><a href='/edit/'. $products->productId .'"> Edit  <a/></ol> <br>';
//   echo '<a href="/edit/" . echo $products->productId </a>';
    echo '<ol><a href="/edit/'. $products->productId. '"> redigera produkten <a/></ol> ';

    ?>

    <body></body>
    </html>
    <?php
    }


    public function editIndex()
    {
        // hämta data från en post
        //fyll i formulär
        //skicka till /posts/$id/update med POST
        echo " redigera en post";
    }

    public function editProduct(string $ProductId)
    {
        // hämta data från en post
        //fyll i formulär
        //skicka till /posts/$id/update med POST
        echo " redigera en posts med id $ProductId";
    }

    public function storeProduct()
    {
        $productTitle = $_POST["productTitle"] ?? "Namn saknas";
        $productDescription = $_POST["productDescription"] ?? "Beskrivning saknas";
        $productTypeId = $_POST["productTypeId"] ?? "Fel id";
        $productId = random_int(0, 100000);
        $userName = $_SESSION['username'];


        $sql = <<<EOD
        insert into products (productTitle, productDescription, productTypeId, productId, username) 
        VALUES(?,?,?,?,?) 
        EOD;

        $stmt = db()->prepare($sql);
        $stmt->execute([$productTitle, $productDescription, $productTypeId, $productId, $userName]);

        SimpleRouter::response()->redirect("/products");

    }

    public function uploadImage()
    {
        $host = "192.168.250.74";
        $db = "ga-lou";
        $user = "ga-lou";
        $password = "rödbrunrånarluva";

        $dsn = "mysql:host=$host;port=3306;dbname=$db";
        $pdo = new PDO($dsn, $user, $password,[PDO::ATTR_PERSISTENT => true]);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn = mysqli_connect($host, $user, $password,$db);


        include("../config.php");
        $username = $_SESSION["username"];
        echo $username;
        if(isset($_POST['but_upload'])){

            $name = $_FILES['file']['name'];
            $target_dir = "upload/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);

            // Select file type
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("jpg","jpeg","png","gif");

            // Check extension
            if( in_array($imageFileType,$extensions_arr) ){
                // Upload file
                if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){
                    // Convert to base64
                    $image_base64 = base64_encode(file_get_contents('upload/'.$name) );
                    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
                    // Insert record
                    $query = "insert into images(image,username) values('$image','$username')";
                    //$query = "insert into images(image, username) values('.$image.','.$username.')";
                    mysqli_query($conn,$query);
                }
            }
        }
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
        <form method="post" action="" enctype='multipart/form-data'>
            <input type='file' name='file' />
            <input type='text' name='name'>
            <input type='submit' value='Save name' name='but_upload'>
        </form>
        </body>
        </html>
        <?php

        $sql = "select image from images order by id desc limit 1";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);

        $image_src = $row['image'];

        ?>
        <html>
        <body>
        <img src='<?php echo $image_src; ?>'
        </body>
        </html>
<?php
    }

    public function update(string $ProductId)
    {
        // läsa in data
        //validera data
        //spara mot db
        // redirect yillbaka till /posts/{id} med get
        echo " spara ändringar med en posts med id $ProductId";
    }

    public function upload()
    {
$productTypes = <<<EOD
select productTypeId,productTypeName
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

<form action="/products/store" method="post">
    <label for=""></label><select name="productTypeId" id="">
        <?php foreach ($productTypes as $productType){
            echo '<option value="'. $productType->productTypeId.'">'. $productType->productTypeName.'</option>';
        }?>
    </select>
    <label>
        <input type="text" name="productTitle" placeholder="Skriv din artikels titel">
    </label>
    <label>
        <input type="text" name="productDescription" placeholder="Skriv artikelns beskrivning här " >
        <input type="submit">
    </label>
</form>
</body>
</html>
<?php
    }
}