<?php

namespace App;

use App\controllers\authController;
use \PDO;
use Pecee\SimpleRouter\SimpleRouter;

class Database
{
    private static $instance = null;
    private $pdo;

    protected function __construct()
    {

        $host = "192.168.250.74";
        $db = "ga-lou";
        $user = "ga-lou";
        $password = "rödbrunrånarluva";

        $dsn = "mysql:host=$host;port=3306;dbname=$db";
//        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo = new PDO($dsn, $user, $password, [PDO::ATTR_PERSISTENT => true]);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public static function isLoggedIn()
    {
        if (!isset($_SESSION["username"]) || $_SESSION["username"] == null) {
            SimpleRouter::response()->redirect("/authe/login");
            exit();
        }
    }

    public static function auth()
    {
        if (!isset($_POST["username"]) || empty($_POST["username"])) {
            return false;
        }
//        self::validateUser();
        $UserName = $_POST["username"] ?? null;
        $Password = $_POST["password"] ?? null;

        $query = "select username, password from users where username = ?";
        $rules = [
            'username' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING,
        ];
        $UserName = $validatedInput['username'] ?? null;
        $Password = $validatedInput['password'] ?? null;

        $validatedInput = filter_input_array(INPUT_POST, $rules);

        $errors = [];

        if ($validatedInput['username']) {
            $UserName = $validatedInput['username'];
        } else {
            $errors[] = 'Felaktigt username';
        }
        if ($validatedInput['password']) {
            $Password = $validatedInput['password'];
        } else {
            $errors[] = 'Felaktig beskrivning';
        }

        if (count($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["fields"] = $_POST;
            redirect($_SERVER["HTTP_REFERER"]);
            exit();
        }

        $stmt = Database::getInstance()->getPDO()->prepare($query);
        $stmt->execute([$UserName]);
        $user = $stmt->fetch();
        if(password_verify($_POST['password'], $user->password)) {
            $_SESSION["username"] = $user->username;
            SimpleRouter::response()->redirect("/authe");
        } else{
            echo "Användarnamn existerar inte eller är lösenordet fel";
        }
        return false;
    }

    public static function update()
    {
        var_dump($_POST);
        $oldUsername = $_SESSION['username'];
        $oldPassword = $_POST['password'];
        var_dump($oldUsername);
        $userId = <<<EOD
        select userId 
        from users
        WHERE username = '$oldUsername'
    EOD;
        $stmt = db()->prepare($userId);
        $stmt->execute();
        $userId = $stmt->fetch(PDO::FETCH_COLUMN);
        var_dump($userId);

        $rules = array(
            'username'=>  FILTER_SANITIZE_STRING,
            'password'   => FILTER_SANITIZE_STRING
        );

        $oldPassword = $validatedInput['password'] ?? null;
        $newPassword = $_POST['password'] ?? null;
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $newUsername = $validatedInput['username'] ?? null;

        $validateInput = filter_input_array(INPUT_POST, $rules);

        $errors = [];
        if($validateInput["username"]){
            $validatedUsername = $validateInput["username"];
        } else {
            $errors[] = 'Det blev ett username fel.';
        }
        if($validateInput["password"]){
            $validatedPassword = $validateInput["password"];
        } else {
            $errors[] = 'Det blev ett password fel.';
        }


        var_dump($_SESSION);
        if(count($errors)){
            $_SESSION["errors"] = $errors;
            $_SESSION["fields"] = $_POST;
            echo  "fel!!";
            exit();
        }
        var_dump($validatedUsername);

        $updateUser = <<<EOD
        UPDATE users
        SET  password = '$newPassword', username = '$validatedUsername'
        WHERE  userId = '$userId' 
    EOD;
        var_dump($updateUser);

        $stmt = db()->prepare($updateUser);
        $stmt->execute();
        SimpleRouter::response()->redirect("/authe/");

    }

    public static function register()
    {
        if (!isset($_POST["username"]) || empty($_POST["username"])) {
            return false;
        }
//        self::validateUser();
        $newUserName = $_POST["username"] ?? null;
        $newPassword = $_POST["password"] ?? null;
        $userId = random_int(0, 100000);
        $newMail = $_POST["userMail"] ?? null;
        $newPhoneNumber = $_POST["userPhoneNumber"] ?? null;

        var_dump($newUserName);
        var_dump($newPassword);
        var_dump($userId);
        var_dump($newPhoneNumber);
        var_dump($newMail);



        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $insertUser =  <<< EOD
        insert into users(username, password,userId, userMail,userTeleNumber)
        VALUES ('$newUserName','$newPassword','$userId','$newMail','$newPhoneNumber');
        EOD;



        $stmt = Database::getInstance()->getPDO()->prepare($insertUser);
        var_dump($insertUser);
        $success = $stmt->execute();
        var_dump($success);
        if ($success) {
            $_SESSION["username"] = $newUserName;
            SimpleRouter::response()->redirect("/authe/");
        } else {
            echo "Något gick fel";
        }
        return false;
    }
}