<?php
require_once "../bank.php"; 

$dbPath = '../bank.sqlite';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a Bank instance
    $bank = new Bank($dbPath);

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Validate form data
    $errors = [];
    if (empty($username) || empty($password) || empty($confirm_password) || empty($first_name) || empty($last_name)) {
        $errors[] = "All fields are required.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Hash the password
        //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Add user using Bank class method
        if ($bank->addUser($username, $password, $first_name, $last_name)) {
            //redirect to login page
            header("Location: ../index.php");
        } else {
            echo "Error adding user.";
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>
