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
        echo "Hej $userName";
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

//        echo "<h2> Lägg till din egna annons</h2>";
        echo '<a href="/products/upload/"> Lägg till annons<a/> <br>';

        echo "<h3> Dina produkter</h3>";
        foreach ($products as $product) {
            echo '<h4>'. $product->productTitle .'</h4>';
            echo '<ol><a href="/products/details/'. $product->productId. '"> läs mer om '. $product->productTitle, '<a/></ol> ';
            echo '<ol><a href="/products/delete/'. $product->productId. '"> Tabort <a/></ol> <br>';
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
        redirectBack();
    }

    public function details()
    {
        $productId = filter_input(INPUT_GET,'url',FILTER_SANITIZE_STRING);
//        var_dump($productId);
        $product = ltrim($productId, "/products/details/");
//        var_dump($product);
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
    $stmt->execute([$product]);
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
    echo '<ol><a href="/products/edit/'. $products->productId. '"> redigera produkten <a/></ol> ';

    ?>

    <body></body>
    </html>
    <?php
    }

    public function editProduct(string $ProductId)
    {

        if (!$ProductId){
        //    redirectHome();
            echo "inget id";
            exit();
        }

        $errors = $_SESSION["errors"] ?? false;
        var_dump($errors);
        $fields = $_SESSION["fields"] ?? [];
        var_dump($_SESSION);

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
        where productId = $ProductId;
        EOD;

        $stmt = db()->prepare($productDesc);
        $stmt->execute();
        $productValues = $stmt->fetch(PDO::FETCH_OBJ);
        var_dump($productValues);
        ?>

        <body>
        <?php
        if ($errors){
            foreach ($errors as $errorMSG){
                echo "<p> $errorMSG </p>";
            }
        }
        ?>
        <form action="/products/update/<?php echo $ProductId ?>" method="post">
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
        <?php
        echo  'id ' . $ProductId ;
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

        <body>
        <form method="post" action="" enctype='multipart/form-data'>
            <input type='file' name='file' />
            <input type='text' name='name'>
            <input type='submit' value='Save name' name='but_upload'>
        </form>
        </body>
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
        if (!$ProductId || !filter_var($ProductId, FILTER_VALIDATE_INT)){
            redirectHome();
        }

        $username = $_SESSION['username'];

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
//        var_dump($ProductId);
//        var_dump($typeId);
//        var_dump($title);
//        var_dump($description);
//        var_dump($username);

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
                productTypeId = ?,
                username = ?
            WHERE productId = ? 
            EOD;

        $stmt = db()->prepare($updateProduct);
        $stmt->execute([$title, $description, $typeId, $username , $ProductId]);
        SimpleRouter::response()->redirect('/products/');

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
//        var_dump($productTypes)

        ?>
        <!doctype html>
        <html lang="sv">
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