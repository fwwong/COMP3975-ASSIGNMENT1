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

        // Check if username exists in the database
        if (!$bank->checkUsernameExists($username)) {
            $login_err = "User does not exist. Please create an account.";
        } else {
            // Authenticate the user
            $result = $bank->authenticateUser($username, $password); 
            
            if ($result) {
                // Check if the user account is verified by the admin
                $user = $bank->getUser($username);
                if ($user["verified"] == 0) {
                    $login_err = "User is not verified. Please wait for admin to verify your account.";
                } else {
                    // Start session and set session variables
                    session_start();
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["first_name"] = $result["first_name"];
                    $_SESSION["last_name"] = $result["last_name"];
                    $_SESSION["account_type"] = $result["account_type"];
                    header("Location: ../members/home.php");
                    exit();
                }
            } else {
                $login_err = "Incorrect password.";
            }
        }
    }
}
?>
