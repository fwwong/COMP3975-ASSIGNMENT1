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
        $errors[] = "All fields are required.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if ($bank->addUser($username, $hashed_password, $first_name, $last_name)) {
            header("Location: ../index.php");
        } else {
            echo "Error adding user.";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>
