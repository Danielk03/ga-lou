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
        }
    }

    public static function auth()
    {
        if (!isset($_POST["username"]) || empty($_POST["username"])) {
            return false;
        }
//        self::validateUser();
        $newUserName = $_POST["username"] ?? null;
        $newPassword = $_POST["password"] ?? null;
        $query = "select username from users where username = ? and password = ?;";
        $rules = [
            'username' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING,
        ];
        $newUserName = $validatedInput['username'] ?? null;
        $newPassword = $validatedInput['password'] ?? null;

        $validatedInput = filter_input_array(INPUT_POST, $rules);

        $errors = [];

        if ($validatedInput['username']) {
            $newUserName = $validatedInput['username'];
        } else {
            $errors[] = 'Felaktigt username';
        }
        if ($validatedInput['password']) {
            $newPassword = $validatedInput['password'];
        } else {
            $errors[] = 'Felaktig beskrivning';
        }
        if (count($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["fields"] = $_POST;
            redirect($_SERVER["HTTP_REFERER"]);
            exit();
        }
        var_dump($_SESSION);
        $stmt = Database::getInstance()->getPDO()->prepare($query);
        $stmt->execute([$newUserName, $newPassword]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION["username"] = $user->username;
//            header("Location: index.php");
            SimpleRouter::response()->redirect("/authe");
        } else {
            echo "Något gick fel";
        }
        return false;
    }

    public static function update()
    {
        $username = $_SESSION['username'];
        var_dump($_POST);
        $oldUsername=$_POST['username'];
        $oldPassword = $_POST['password'];

        $rules = array(
            'username'=>  FILTER_SANITIZE_STRING,
            'password'   => FILTER_SANITIZE_STRING
        );

        $oldUsername = $validatedInput['username'] ?? null;
        $oldPassword = $validatedInput['password'] ?? null;

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
        $updateUser = <<<EOD
            UPDATE users
            SET  password =?
            WHERE  username = '$username'; 
        EOD;

        $stmt = db()->prepare($updateUser);
        $stmt->execute([$validatedPassword]);
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
        $newMail = $_POST["userMail"] ?? null;
        $newPhoneNumber = $_POST["userPhoneNumber"] ?? null;

        var_dump($newUserName);
        var_dump($newPassword);
        var_dump($newPhoneNumber);
        var_dump($newMail);

        $query = "select username 
                from users 
                where username = ? 
                and password = ?;
                 ";

        $rules = [
            'username' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING,
            'userPhoneNumber' => FILTER_VALIDATE_INT,
            'userMail' => FILTER_SANITIZE_STRING,
        ];
        $validatedInput = filter_input_array(INPUT_POST, $rules);
        $newUserName = $validatedInput['username'] ?? null;
        $newPassword = $validatedInput['password'] ?? null;
        $newPhoneNumber = $validatedInput['userPhoneNumber'] ?? null;
        $newMail = $validatedInput['userMail'] ?? null;

        var_dump($newUserName);
        var_dump($newPassword);
        var_dump($newPhoneNumber);
        var_dump($newMail);

        $errors = [];

        if ($validatedInput['username']) {
            $newUserName = $validatedInput['username'];
        } else {
            $errors[] = 'Felaktigt användarnamn';
        }
        if ($validatedInput['password']) {
            $newPassword = $validatedInput['password'];
        } else {
            $errors[] = 'Felaktigt lösenord';
        }
        if ($validatedInput['userPhoneNumber']) {
            $newPhoneNumber = $validatedInput['userPhoneNumber'];
        } else {
            $errors[] = 'Felaktigt tele num';
        }
        if ($validatedInput['userMail']) {
            $newMail = $validatedInput['userMail'];
        } else {
            $errors[] = 'Felaktigt mail';
        }


        if (count($errors)) {
            $_SESSION["errors"] = $errors;
            $_SESSION["fields"] = $_POST;
            redirect($_SERVER["HTTP_REFERER"]);
            exit();
        }

        $insertUser =  <<< EOD
        insert into users(username, password,userMail,userTeleNumber)
        VALUES (?,?,?,?);
        EOD;

        $stmt = db()->prepare($insertUser);
        $stmt->execute([$newUserName,$newPassword,$newMail,$newPhoneNumber]);
        $userINFO = $stmt->fetch(PDO::FETCH_OBJ);
        var_dump($userINFO);


        $stmt = Database::getInstance()->getPDO()->prepare($query);
        var_dump($query);
        $success = $stmt->execute([$newUserName, $newPassword]);
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