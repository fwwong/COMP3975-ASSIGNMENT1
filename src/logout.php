<?php
session_start(); // Start the session

$logout = true;

if ($logout) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();
    
    // Redirect to the home page
    header("Location: index.php");
    exit;
}
?>