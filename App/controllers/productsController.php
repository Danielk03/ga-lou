<?php

namespace App\controllers;

use App\Database;
use PDO;
use Pecee\SimpleRouter\SimpleRouter;

class productsController
{
    public function productIndex()
    {

        \App\Database::isLoggedIn();

        $userName = $_SESSION["username"];

        $products = <<<EOD
        select * from products;
        EOD;
        $stmt = db()->prepare($products);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);

        $productTypes = <<<EOD
        select *
        from productTypes;
        EOD;
        $stmt = db()->prepare($productTypes);
        $stmt->execute();
        $productTypes = $stmt->fetchAll();


        $lowPrice = $_GET['lowPrice'] ?? 0;
        $highPrice = $_GET['highPrice'] ?? 10000;
        $productType = $_GET['productTypeId'] ?? null;

        // utan price filter
        $products = <<<EOD
        select * from products;
        EOD;
        $stmt = db()->prepare($products);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);

        $productsFilter = <<<EOD
        select * from products
        where price >= '$lowPrice' and price <= '$highPrice' and  productTypeId = '$productType';
        EOD;
        $stmt = db()->prepare($productsFilter);
        $stmt->execute();
        $productsFilter = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Försöka få rätt type id när man valt ett till
//        $productTypeValues = <<<EOD
//        select *
//        from productTypes
//        where productTypeId = '$productType';
//        EOD;
//        $stmt = db()->prepare($productTypeValues);
//        $stmt->execute();
//        $productTypeValues = $stmt->fetchAll();
//
//        var_dump($productTypeValues);
//
//        if (isset($_GET['productTypeId'])) {
//            foreach ($productTypeValues as $productTypeValue) {
//                echo '<option value="' . $productTypeValue->productTypeId . $productType->productTypeId . '">' . $productTypeValue->productTypeName . '</option>';
//            }
//        } else {
//            foreach ($productTypes as $productType) {
//                echo '<option value="' . $productType->productTypeId . '">' . $productType->productTypeName . '</option>';
//            }
//        }
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
        <?php profilIcon() ?>

        <nav id="products" class="navbar navbar-light nav-icon-placement">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <br>
        <br>
        <div class="containerborder">
            <label for="productTypeId" class="form-label" id="typeId"> Kategori<br>
                <select name="productTypeId" id="productTypeId">
                    <?php
                    foreach ($productTypes as $productType) {
                        echo '<option value="' . $productType->productTypeId . '">' . $productType->productTypeName . '</option>';
                    }
                    ?>
                </select>
            </label>
        </div>
        <form action=" " method="get">
            <div class="container center">
                <div class="row">
                    <div class="col">
                        <label for="price" class="form-label"> Min. pris<br>
                            <input id="priceSize" placeholder="Ange minsta värde" name="lowPrice" type="number"
                                   value="<?php echo $lowPrice ?>">
                        </label>
                    </div>
                    <div class="col">
                        <label for="price" class="form-label"> Max. pris<br>
                            <input id="priceSize" placeholder="Ange max värde" name="highPrice" type="number"
                                   value="<?php echo $highPrice ?>">
                        </label>
                    </div>
                </div>
            </div>
            <div class="container center">
                <div class="row">
                    <div class="col">
                        <input class="btn btn-filter" type="submit" value="Filtrera">
                    </div>
        </form>
        <div class="col">
            <form action="/products/">
                <input class="btn-removeFilter btn" type="submit" value="Ta bort filter">
            </form>
        </div>
        </div>
        </div>

        <h1 id="productTitle">Produkter</h1>
        <div class="row row-cols-2 row-cols-md-2 g-4">
            <?php
            if (isset($_GET['productTypeId'])) {
                foreach ($productsFilter as $productFilter) {
                    echo
                        '<div class="col">
        <div class="card h-100">
            <img  src="' . $productFilter->image . '" alt="KO" style="max-height: 15vh ; object-fit: cover">
            <div class="card-body">
                <p class="title-text">' . $productFilter->productTitle . '</p>
                <p class="description-text"> ' . $productFilter->productDescription . '</p>
                <p class="price-text">' . $productFilter->price . ' kr/dag</p>
                <p class="date-text">' . $productFilter->uploadDate . '</p>
        </div>
        </div>
        </div>
        </div>
       ';

                }
            } else {
                foreach ($products as $product) {
                    echo '
        <div class="col">
        <a href="/products/details/' . $product->productId . ' ">
        <div class="card h-100"  style="width: 100%"> 
            <img src="' . $product->image . '" alt="KO" style="max-height: 15vh ; object-fit: cover">
            <div class="card-body">
                <p class="title-text">' . $product->productTitle . '</p>
                <p class="username-text">' . $product->username . '</p>
                <p class="description-text" style="max-height: 64px"> ' . $product->productDescription . '</p>
                <br>
                <p class="price-text">' . $product->price . ' kr/dag</p>
                <p class="date-text">' . $product->uploadDate . '</p>
        </div>
        </div>
        </a>
        </div>
        ';
                }
            }
            ?>
        </div>
        </div>
        <?php navbar(); ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                crossorigin="anonymous"></script>
        </body>
        </html>
        <?php
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
        $product = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);
//        var_dump($productId);
        $productId = ltrim($product, "/products/details/");
//        var_dump($product);
        if (!$product || !$productId) {
//            redirectHome();
            echo "inget p ID";
        }
        $prod = <<<EOD
        select * from products
        where productId like ?
        EOD;
        $stmt = db()->prepare($prod);
        $stmt->execute([$productId]);
        $products = $stmt->fetch(PDO::FETCH_OBJ);


        $products2 = <<<EOD
        select * from products
        EOD;
        $stmt = db()->prepare($products2);
        $stmt->execute();
        $products2 = $stmt->fetch(PDO::FETCH_OBJ);


        $userInfo = <<<EOD
            SELECT *
            from users 
            where username = '$username'
            EOD;

        $stmt = db()->prepare($userInfo);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_OBJ);

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
            <link rel="stylesheet" href="../../index.css?v=1">
            <title>Details</title>
        </head>
        <body>
        <div class="containerborder">
            <div class="profile-icon-placement">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-circle"
                     viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd"
                          d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
            </div>
            <nav class="navbar navbar-light nav-icon-placement">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
            <br>
            <br>
            <br>
            <?php
            echo '
        <div class="col">
        <div class="card h-100" >
            <img src="' . $products->image . '" alt="KO" style="max-height: 200vh ; object-fit: cover">
            <div class="card-body" style="height: 40vh">
                <p class="title-text">' . $products->productTitle . '</p>
                <p class="username-text">' . $products->username . '</p>
                <p class="description-text"> ' . $products->productDescription . '</p>
                <p class="price-text">' . $products->price . ' kr/dag</p>
                <p class="date-text">' . $products->uploadDate . '</p>
                <h3><a href="/products/edit/' . $products2->productId . '"> Redigera produkten <a/></h3>
        </div>
        </div>
        </div>
        ';

            ?>
            <?php navbar(); ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                    crossorigin="anonymous"></script>
        </body>
        </html>
        <?php
    }

    public function editProduct(string $ProductId)
    {

        if (!$ProductId) {
//                redirectHome();
            echo "inget id";
            exit();
        }

        $errors = $_SESSION["errors"] ?? false;
        $fields = $_SESSION["fields"] ?? [];

        $host = "192.168.250.74";
        $db = "ga-lou";
        $user = "ga-lou";
        $password = "rödbrunrånarluva";
        $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=UTF8";
        $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_PERSISTENT => true]);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
//        var_dump($productValues);
        if ($errors) {
            foreach ($errors as $errorMSG) {
                echo "<p> $errorMSG </p>";
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
        <?php profilIcon(); ?>
        <nav class="navbar navbar-light nav-icon-placement">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <br>
        <br>
        <div class="containerborder">
            <div class="center mb-4 m-top">
                <a href="/products/user"> Tillbaka</a>
                <h1> Redigera Annons</h1>
            </div>
            <form method="post" action="/products/update/<?php echo $ProductId ?> " enctype='multipart/form-data'>
                <div class="mb-4">
                    <label for="productTitle" class="form-label">Titel
                        <input type="text" class="form-control" name="productTitle"
                               value="<?php echo $productValues->productTitle ?>">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="productDescription" class="form-label">Beskrivning
                        <input class="form-control" name="productDescription"
                               value="<?php echo $productValues->productDescription ?>">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="productTypeId" class="form-label">Kategori<br>
                        <select id="textboxid" name="productTypeId" class="form-control">
                            <?php foreach ($productTypes as $productType) {
                                echo '<option value="' . $productType->productTypeId . '">' . $productType->productTypeName . '</option>';
                            } ?>
                        </select>
                    </label>
                </div>
                <div class="mb-4">
                    <label for="price" class="form-label"> Pris kr/dag
                        <input type="number" class="form-control" name="price"
                               value="<?php echo $productValues->price ?>">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="file" class="form-label"> Välj Annons Bild
                        <input type='file' name='file'/>
                    </label>
                </div>
                <div class="center">
                    <input type='submit' class="btn btn-login" value='Lägg Till Annons' name='but_upload'>
                </div>
            </form>
        </div>
        <?php navbar(); ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                crossorigin="anonymous"></script>
        </body>
        </html>
        <?php
//        echo 'id ' . $ProductId;
    }

    public function storeProduct()
    {
        $host = "192.168.250.74";
        $db = "ga-lou";
        $user = "ga-lou";
        $password = "rödbrunrånarluva";

        $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=UTF8";
        $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_PERSISTENT => true]);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

                    $productId = random_int(0, 100000);
                    $productTitle = $_POST["productTitle"] ?? "Namn saknas";
                    $productDescription = $_POST["productDescription"] ?? "Beskrivning saknas";
                    $productTypeId = $_POST["productTypeId"] ?? "Fel id";
                    $productPrice = $_POST['price'] ?? "Fel pris";
                    $userName = $_SESSION['username'];

                    $query = <<<EOD
                    insert into products(productId, productTitle, productDescription, productTypeId, username, price, image) values('$productId','$productTitle','$productDescription','$productTypeId','$username','$productPrice','$image')
                    EOD;

                    $stmt = db()->prepare($query);
                    $stmt->execute();
                    $query = $stmt->fetchAll();
                }

            }

        }
        $sql = "select image from image order by id desc limit 1";

        SimpleRouter::response()->redirect("/products");
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
//        var_dump($ProductId);
//        var_dump($typeId);
//        var_dump($title);
//        var_dump($description);
//        var_dump($username);
//        var_dump($price);

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
        $host = "192.168.250.74";
        $db = "ga-lou";
        $user = "ga-lou";
        $password = "rödbrunrånarluva";
        $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=UTF8";
        $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_PERSISTENT => true]);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn = mysqli_connect($host, $user, $password, $db);
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
        <?php profilIcon(); ?>
        <div class="containerborder">
            <div class="center mb-4 m-top">
                <a href="/products/user"> Tillbaka</a>
                <h1> Lägg till annons</h1>
            </div>
            <form method="post" action="/products/store " enctype='multipart/form-data'>
                <div class="mb-4">
                    <label for="productTitle" class="form-label">Titel
                        <input type="text" class="form-control" name="productTitle" placeholder="Produktens Namn">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="productDescription" class="form-label">Beskrivning
                        <input class="form-control" name="productDescription" placeholder="Produkt Beskrivning">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="productTypeId" class="form-label">Kategori<br>
                        <select id="textboxid" name="productTypeId" class="form-control">
                            <?php foreach ($productTypes as $productType) {
                                echo '<option value="' . $productType->productTypeId . '">' . $productType->productTypeName . '</option>';
                            } ?>
                        </select>
                    </label>
                </div>
                <div class="mb-4">
                    <label for="price" class="form-label"> Pris kr/dag
                        <input type="number" class="form-control" name="price" placeholder="Pris i kronor">
                    </label>
                </div>
                <div class="mb-4">
                    <label for="file" class="form-label">
                        <input type='file' name='file'/>
                    </label>
                </div>
                <div class="center">
                    <input type='submit' class="btn btn-login" value='Lägg Till Annons' name='but_upload'>
                </div>
            </form>
        </div>
        <?php navbar(); ?>

        </body>
        </html>
        <?php
    }

    public function userProduct()
    {
        \App\Database::isLoggedIn();
        $userName = $_SESSION["username"];


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
        $username = $_SESSION['username'];
        $productId = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);
        //        var_dump($productId);
        $product = ltrim($productId, "/products/details/");

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
            <title>Userproducts</title>
        </head>
        <body>
        <?php profilIcon() ?>
        <nav class="navbar navbar-light nav-icon-placement">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="center mb-4" id="editMargin">
            <a href="/products/"> Tillbaka</a>
            <h1> Dina produkter</h1>
        </div>

        <div class="row row-cols-2 row-cols-md-2 g-4" id="editCardMargin">
            <?php
            foreach ($products as $product) {
                echo '
                <div class="col m-above" xmlns="http://www.w3.org/1999/html">
                     <div class="card h-100" style="width: 100%;">
                          <img src="' . $product->image . '" alt="productBild" style="max-height: 15vh ; object-fit: cover">
                          <div class="card-body">
                                <p class="title-text" style="margin-bottom: 5px">' . $product->productTitle . '</p>
                                <p class="description-text" style="max-height: 64px"> ' . $product->productDescription . '</p>
                                <br>
                                <p class="price-text"> ' . $product->price . ' kr/dag</p>
                                <p class="date-text">' . $product->uploadDate . '</p>
                          </div>
                     </div>
                </div>   
                <div class="col m-above" xmlns="http://www.w3.org/1999/html">
                     <form  action="/products/edit/' . $product->productId . '">
                           <input class="btn-edit btn-login btn " id="editButtons" type="submit" value="Redigera ">
                     </form>
                     <form action="/products/delete/' . $product->productId . '">
                           <input class=" btn-edit btn-cancell btn " id="editButtons" type="submit" value="Ta bort ">
                     </form>
                </div>';
            }
            ?>

        </div>
        <?php navbar(); ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                crossorigin="anonymous"></script>
        </body>
        </html>
        <?php


    }
}