<?php
require_once "../bank.php"; 

$first_name = $last_name = $username = $password = $confirm_password = "";
$first_name_err = $last_name_err = $username_err = $password_err = $confirm_password_err = "";

$dbPath = '../bank.sqlite';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank = new Bank($dbPath);

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $errors = [];
    if (empty($username) || empty($password) || empty($confirm_password) || empty($first_name) || empty($last_name)) {
        $errors[] = "<div class='alert alert-danger'>All fields are required.</div>";
    }
    if ($password !== $confirm_password) {
        $errors[] = "<div class='alert alert-danger'>Passwords do not match.</div>";
    }

    // username must contain @ . somewhere
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "<div class='alert alert-danger'>Invalid email address.</div>";
    }

    // password must contains at least 1 capital letter, 1 number, and 1 special character min 4 characters long
    if (strlen($password) < 4) {
        $errors[] = "<div class='alert alert-danger'>Password must be at least 4 characters long.</div>";
    }
    if (!preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[^a-zA-Z0-9]/", $password)) {
        $errors[] = "<div class='alert alert-danger'>Password must contain at least 1 capital letter, 1 number, and 1 special character.</div>";
    }


    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if ($bank->checkUsernameExists($username)) {
            $errors[] = "<div class='alert alert-danger'>Username already exists.</div>";
        } else {
            if ($bank->addUser($username, $hashed_password, $first_name, $last_name)) {
                header("Location: ../index.php");
                exit();
            } else {
                $errors[] = "<div class='alert alert-danger'>Failed to register user.</div>";
            }
        }
    }

    // Output errors
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}
?>
