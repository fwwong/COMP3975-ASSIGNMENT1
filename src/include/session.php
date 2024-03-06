<?php
session_start(); // Start the session.

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, you can proceed with displaying content or performing actions
    echo 'Welcome, ' . $_SESSION['username'];
} else {
    // User is not logged in, redirect them to the login page or display a message
    header("Location: /User/login.php");
    exit();
}
?>