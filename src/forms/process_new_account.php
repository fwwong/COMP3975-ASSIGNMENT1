<?php
require_once "../bank.php"; 

$dbPath = '../bank.sqlite';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    // Create a Bank instance
    $bank = new Bank($dbPath);

    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Validate form data
    if (empty($username) || empty($password) || empty($first_name) || empty($last_name)) {
        echo "All fields are required.";
    } else {
        // Add user using Bank class method
        if ($bank->addUser($username, $password, $first_name, $last_name)) {
            echo "User added successfully.";
        } else {
            echo "Error adding user.";
        }
    }
}
?>
