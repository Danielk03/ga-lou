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
        $this->pdo = new PDO($dsn, $user, $password,[PDO::ATTR_PERSISTENT => true]);
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
        $validatedInput = filter_input_array(INPUT_POST, $rules);
        $newUserName = $validatedInput['username'] ?? null;
        $newPassword = $validatedInput['password'] ?? null;

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
        $stmt = Database::getInstance()->getPDO()->prepare($query);
        $stmt->execute([$newUserName, $newPassword]);
        $user = $stmt->fetch();
//            if ($newUserName == 'emil' && $newPassword == 'EmiBin123') {
//                $_SESSION['username'] = $newUserName;
////                header("Location: index.php");
//                SimpleRouter::response()->redirect("/auth/");

                if ($user) {
            $_SESSION["username"] = $user->username;
//            header("Location: index.php");
            SimpleRouter::response()->redirect("/authe");
        } else {
            echo "Något gick fel";
        }

        return false;
    }

    public static function register()
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
        $validatedInput = filter_input_array(INPUT_POST, $rules);
        $newUserName = $validatedInput['username'] ?? null;
        $newPassword = $validatedInput['password'] ?? null;

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
        $stmt = Database::getInstance()->getPDO()->prepare($query);
        $stmt->execute([$newUserName, $newPassword]);
        $user = $stmt->fetch();
//
//            if ($username == 'emil' && $password == 'EmiBin123') {
//                $_SESSION['username'] = $username;
//                header("Location: index.php");
        if ($user) {
            $_SESSION["username"] = $user->username;
//            header("Location: index.php");
            SimpleRouter::response()->redirect("/auth/");
        } else {
            var_dump($user);
            echo "Något gick fel";
        }
        return false;
    }


//    public static function validateUser()
//    {
//        $newUserName = $_POST["username"] ?? null;
////        $newPassword = $_POST["password"] ?? null;
////        $query = "select username from users where username = ? and password = ?;";
////        $rules = [
////            'username' => FILTER_SANITIZE_STRING,
////            'password' => FILTER_SANITIZE_STRING,
////        ];
////        $validatedInput = filter_input_array(INPUT_POST, $rules);
////        $newUserName = $validatedInput['username'] ?? null;
////        $newPassword = $validatedInput['password'] ?? null;
////
////        $errors = [];
////
////        if ($validatedInput['username']) {
////            $newUserName = $validatedInput['username'];
////        } else {
////            $errors[] = 'Felaktigt username';
////        }
////        if ($validatedInput['password']) {
////            $newPassword = $validatedInput['password'];
////        } else {
////            $errors[] = 'Felaktig beskrivning';
////        }
////        if (count($errors)) {
////            $_SESSION["errors"] = $errors;
////            $_SESSION["fields"] = $_POST;
////            redirect($_SERVER["HTTP_REFERER"]);
////            exit();
////        }
////        $stmt = Database::getInstance()->getPDO()->prepare($query);
////        $stmt->execute([$newUserName, $newPassword]);
////        $user = $stmt->fetch();
////        //lyckad inloggning
//////            if ($username == 'emil' && $password == 'EmiBin123') {
//////                $_SESSION['username'] = $username;
//////                header("Location: index.php");
////        if ($user) {
////            $_SESSION["username"] = $user->username;
//////            header("Location: index.php");
////            SimpleRouter::response()->redirect("/auth/");
////        } else {
////            echo "Något gick fel";
////        }
////    }
}