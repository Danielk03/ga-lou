<?php

namespace App\controllers;

use App\Database;
use PDO;
use Pecee\SimpleRouter\SimpleRouter;

class productsController
{
    public function productIndex()
    {
        ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
                  integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
                  crossorigin="anonymous">
            <link rel="stylesheet" href="../index.css?v=1">
            <title>Document</title>
        </head>
        <body>
        <div class="containerborder">
            <div class="profile-icon-placement">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
            </div>
            <nav class="navbar navbar-light nav-icon-placement">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
            <br>
            <br><br><br>
            <div class="row row-cols-2 row-cols-md-2 g-4">
                <div class="col">
                    <div class="card h-100">
                        <img src="/uploadsoctane_3_4x.png" class="card-img-top" alt="KO" style="height: 45%">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100">
                        <img src="/uploadsgolden-gate.jpg" class="card-img-top" alt="..." style="height: 45%">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse" id="navbarToggleExternalContent">
                <div class="container-nav" id="container">
                    <button class="navbar-toggler nav-icon-close" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation"> CLOSE</button>
                    <br>
                    <p class="nav-font">Hitta produkter</p>
                    <p class="nav-font">Dina produkter</p>
                    <p></p>
                </div>
            </div>
            <!-- fixa så att knappen tar den till sin profil eller log in -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        </body>
        </html>

        <?php
        \App\Database::isLoggedIn();
        $userName = $_SESSION["username"];
        echo "Hej $userName";
        echo '<ol><a href="/authe/"> Auth // Logga in <a/></ol> <br>';
        echo '<ol><a href="/products/user"> Till dina produkter<a/></ol> <br>';

        $productType = <<<EOD
        select *
        from productTypes;
        EOD;

        $stmt = db()->prepare($productType);
        $stmt->execute();
        $productTypes = $stmt->fetchAll();
//        var_dump($productTypes);

        $userInfo = <<<EOD
        select * from users;
        EOD;

        $stmt = db()->prepare($userInfo);
        $stmt->execute();
        $userInfo = $stmt->fetchAll(PDO::FETCH_OBJ);
//        var_dump($userInfo);

        $products = <<<EOD
        select * from products;
        EOD;

        $stmt = db()->prepare($products);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);

        echo "<h3>Produkter</h3> <br>";
        ?>
         <!doctype html>
        <html lang="en">
        <body>
         <form action=" " method="post">
            <label>
                <p> Kategori</p>
                <select name="productTypeId" id="">
                    <?php foreach ($productTypes as $productType) {
                        echo '<option value="'. $productType->productTypeId . '">' . $productType->productTypeName . '</option>';
                    } ?>
                </select>
            </label>
        </body>

        <div class="row row-cols-2 row-cols-md-2 g-4">
         <?php
        foreach ($products as $product) {
            echo
                '<div class="col">
        <div class="card h-100">
            <img src="/upload/1.jpg" class="card-img-top" alt="KO" style="height: 45%">
            <div class="card-body">
                <h5 class="card-title">'. $product->productTitle.'</h5>
                <p class="card-text"> '.$product->productDescription.'</p>
                <p class="card-text"><small class="text-muted">'.$product->uploadDate.'</small></p>
            </div>
            </div>
        </div>
        
       ';
        }
        ?>
        </div>
    <?php
        }

    public function userProduct()
    {
        \App\Database::isLoggedIn();
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
        select * from users;
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
            echo '<h4>' . $product->productTitle . '</h4>';
            echo '<ol><a href="/products/details/' . $product->productId . '"> Redigera  ' . $product->productTitle, '<a/></ol> ';
            echo '<ol><a href="/products/delete/' . $product->productId . '"> Tabort <a/></ol> <br>';
        }

    }

    public function delete(string $ProductId)
    {

        $productId = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);
        $product = ltrim($productId, "/products/delete/");
        if (!$product || !$productId) {
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
        $username = $_SESSION['username'];
        $productId = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);
//        var_dump($productId);
        $product = ltrim($productId, "/products/details/");
//        var_dump($product);
        if (!$product || !$productId) {
//            redirectHome();
            echo "inget p ID";
        }
        $productTitle = <<<EOD
            SELECT *
            from products 
            where productId = ?
            EOD;

        $stmt = db()->prepare($productTitle);
        $stmt->execute([$product]);
        $products = $stmt->fetch(PDO::FETCH_OBJ);

        var_dump($products);

        $userInfo = <<<EOD
            SELECT *
            from users 
            where username = '$username'
            EOD;

        $stmt = db()->prepare($userInfo);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_OBJ);

        var_dump($userInfo);

        echo "<h1> $products->productTitle</h1>";
        echo "<p> $products->productDescription<p>";
        if ($_SESSION['username'] == $products->username) {
            echo '<h3><a href="/products/edit/' . $products->productId . '"> redigera produkten <a/></h3> ';
        }
        echo " Pris : $products->price kronor i månaden<br> ";
        echo " Datum : $products->uploadDate <br> ";

        echo "<h3> Kontakta $products->username</h3><br>";
        echo " <b> Tele:  $userInfo->userTeleNumber<br> Mail : $userInfo->userMail </b><br>";

    }

    public function editProduct(string $ProductId)
    {

        if (!$ProductId) {
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
        SELECT productDescription, productTitle, productId, price
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
        if ($errors) {
            foreach ($errors as $errorMSG) {
                echo "<p> $errorMSG </p>";
            }
        }
        ?>
        <form action="/products/update/<?php echo $ProductId ?>" method="post">
            <label>
                <input type="text" name="productTitle" value="<?php echo $productValues->productTitle ?>">
            </label>
            <label>
                <input type="text" name="productDescription" value="<?php echo $productValues->productDescription ?>">
            </label>
            <label for=""></label><select name="productTypeId" id="">
                <?php foreach ($productTypes as $productType) {
                    echo '<option value="' . $productType->productTypeId . '">' . $productType->productTypeName . '</option>';
                } ?>
            </select>

            <label>
                <input type="number" name="price" value="<?php echo $productValues->price ?>">
                <input type="submit">
            </label>
        </form>
        </body>
        </html>
        <?php
//        echo 'id ' . $ProductId;
    }

    public function storeProduct()
    {
        $productId = random_int(0, 100000);
        $productTitle = $_POST["productTitle"] ?? "Namn saknas";
        $productDescription = $_POST["productDescription"] ?? "Beskrivning saknas";
        $productTypeId = $_POST["productTypeId"] ?? "Fel id";
        $productPrice = $_POST['price'];
        $userName = $_SESSION['username'];

        var_dump($productId);
        var_dump($productTitle);
        var_dump($productDescription);
        var_dump($productTypeId);
        var_dump($productPrice);
        var_dump($userName);

        $sql = <<<EOD
        insert into products (productId, productTitle, productDescription, productTypeId, username,price) 
        VALUES(?,?,?,?,?,?) 
        EOD;

        $stmt = db()->prepare($sql);
        $stmt->execute([$productId, $productTitle, $productDescription, $productTypeId, $userName, $productPrice]);

        SimpleRouter::response()->redirect("/products");

    }

    public function uploadImage()
    {
        $host = "192.168.250.74";
        $db = "ga-lou";
        $user = "ga-lou";
        $password = "rödbrunrånarluva";

        $dsn = "mysql:host=$host;port=3306;dbname=$db";
        $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_PERSISTENT => true]);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn = mysqli_connect($host, $user, $password, $db);
        include("../config.php");
        $username = $_SESSION["username"];
        echo $username;
        if (isset($_POST['but_upload'])) {

            $name = $_FILES['file']['name'];
            $target_dir = "upload/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);

            // Select file type
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("jpg", "jpeg", "png", "gif");

            // Check extension
            if (in_array($imageFileType, $extensions_arr)) {
                // Upload file
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name)) {
                    // Convert to base64
                    $image_base64 = base64_encode(file_get_contents('upload/' . $name));
                    $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;
                    // Insert record
                    $query = "insert into image(image,username) values('$image','$username')";
                    //$query = "insert into images(image, username) values('.$image.','.$username.')";
                    mysqli_query($conn, $query);
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
        <form method="post" action="/products/image" enctype='multipart/form-data'>
            <input type='file' name='file'/>
            <input type='text' name='name'>
            <input type='submit' value='Använd Bild' name='but_upload'>
        </form>
        </body>
        </html>
        <?php

        $sql = "select image from image order by id desc limit 1";
        var_dump($conn, $sql);
        $result = mysqli_query($conn, $sql);
        var_dump($result);
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
        if (!$ProductId || !filter_var($ProductId, FILTER_VALIDATE_INT)) {
            redirectHome();
            exit();
        }

        $username = $_SESSION['username'];

        $userInfo = <<<EOD
        select * 
        from users
        where username = '$username'
        EOD;

        $stmt = db()->prepare($userInfo);
        $stmt->execute();
        $userInfo = $stmt->fetchAll();
        var_dump($userInfo);

        $rules = array(
            'productId' => [
                'filter' => FILTER_VALIDATE_INT
            ],
            'price' => FILTER_VALIDATE_INT,
            'productTitle' => FILTER_SANITIZE_STRING,
            'productDescription' => FILTER_SANITIZE_STRING,
            'productTypeId' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 0, 'max_range' => 3]

            ]
        );
        $validateInput = filter_input_array(INPUT_POST, $rules);

        $errors = [];
        if ($validateInput["productTitle"]) {
            $title = $validateInput["productTitle"];
        } else {
            $errors[] = 'Det blev ett internt fel.';
        }
        if ($validateInput["price"]) {
            $price = $validateInput["price"];
        } else {
            $errors[] = 'Det blev ett internt fel.';
        }
        if ($validateInput["productDescription"]) {
            $description = $validateInput["productDescription"];
        } else {
            $errors[] = 'Det blev ett internt fel.';
        }
        if ($validateInput["productTypeId"]) {
            $typeId = $validateInput["productTypeId"];
        } else {
            $errors[] = 'Det blev ett internt fel.';
        }
        var_dump($ProductId);
        var_dump($typeId);
        var_dump($title);
        var_dump($description);
        var_dump($username);
        var_dump($price);

        if (count($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["fields"] = $_POST;
            echo "fel!!";
            exit();
        }

        $updateProduct = <<<EOD
            UPDATE products
            SET productTitle = ?,
                productDescription = ?,
                productTypeId = ?,
                username = ?,
                price = ?
            WHERE productId = ? 
            EOD;

        $stmt = db()->prepare($updateProduct);
        $stmt->execute([$title, $description, $typeId, $username, $price, $ProductId]);
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
        <a href="products/user"> Tillbaka</a>
        <h1> Lägg till annons</h1>
        <form action="/products/store" method="post">
            <label>
                <p> Kategori</p>
                <select name="productTypeId" id="">
                    <?php foreach ($productTypes as $productType) {
                        echo '<option value="' . $productType->productTypeId . '">' . $productType->productTypeName . '</option>';
                    } ?>
                </select>
            </label>
            <label>
                <p> Pris</p>
                <input type="number" name="price" placeholder="Pris i kronor">
            </label>
            <label>
                <p> Titel</p>
                <input type="text" name="productTitle" placeholder="Skriv din artikels titel">
            </label>
            <label>
                <p> Beskrivning</p>
                <input type="text" name="productDescription" placeholder="Skriv artikelns beskrivning här ">
            </label>
            <label>
                <p> Lägg till bild</p>
                <a href="/products/image">
<!--                    <img src="upload/imageRutor.png">-->
                "BILD IGENTLIGEN ;) "
                </a>
            </label>
            <label>
                <br><br><input type="submit" value="Annonsera">
            </label>
        </form>
        </body>
        </html>
        <?php
    }
}