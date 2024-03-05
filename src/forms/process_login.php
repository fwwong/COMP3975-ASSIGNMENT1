<?php
session_start(); 

// If user is already logged in, redirect them to the home page
if(isset($_SESSION['username']) && $_SESSION['loggedin'] === true){
    header("Location: ../members/welcome.php");
    exit;
}
require_once "bank.php"; 

$dbPath = 'bank.sqlite';

$username = $password = "";
$username_err = $password_err = $login_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $bank = new Bank($dbPath);

        $result = $bank->authenticateUser($username, $password);

        if ($result === true) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;

            // check for permissions- verified user
            if ($bank->$verifyUser($username)) {
                $_SESSION["verified"] = true;
                // Redirect user to welcome page
                header("Location: ../members/welcome.php");
                exit;
            } else {
                $_SESSION["verified"] = false;
                // Redirect user to home page
                header("Location: index.php");
            }
        } else {
            $login_err = $result;
        }
    }
}
?>
