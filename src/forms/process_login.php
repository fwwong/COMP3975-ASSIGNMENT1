<?php
require_once "bank.php";

$dbPath = 'bank.sqlite';

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username)) {
        $username_err = "Please enter username.";
    }

    if (empty($password)) {
        $password_err = "Please enter your password.";
    }

    if (empty($username_err) && empty($password_err)) {
        $bank = new Bank($dbPath);

        $result = $bank->authenticateUser($username, $password); // returns a list of users details
        var_dump($result);

        if ($result) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["first_name"] = $result["first_name"];
            $_SESSION["last_name"] = $result["last_name"];
            $_SESSION["account_type"] = $result["account_type"];
            header("Location: ../members/home.php");
            exit();
        } else {
            $login_err = "Invalid username or password.";
        }
    }
}
?>
