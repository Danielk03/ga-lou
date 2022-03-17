
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
<form method="post">
    <label> Search</label>
    <input type="text" name="search">
    <input type="submit" name="submit">

</form>

</body>
</html>
<?php
$host = "192.168.250.74";
$db = "ga-lou";
$user = "ga-lou";
$password = "rödbrunrånarluva";

$dsn = "mysql:host=$host;port=3306;dbname=$db";
//        $this->pdo = new PDO($dsn, $user, $password);
$this->pdo = new PDO($dsn, $user, $password, [PDO::ATTR_PERSISTENT => true]);
$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['submit'])) {
    $search = $_POST['search'];

    $searchProduct = <<< EOD
            SELECT * 
            FROM products 
            WHERE productTitle = $search
            EOD;

    $stmt = db()->prepare($searchProduct);
    $stmt->execute();
    $searchProduct = $stmt->fetch(PDO::FETCH_OBJ);

    var_dump($searchProduct);

    if ($searchProduct) {
        ?>
        <br><br><br>
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
            </tr>
            <tr>
                <td><?php echo $searchProduct->productTitle; ?> </td>
                <td><?php echo $searchProduct->productDescription; ?> </td>
            </tr>
        </table>
        <?php
    }
    else {
        echo "name does not exist";
    }
}