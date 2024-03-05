<?php
include("../../bank.php");

$dbPath = '../../bank.sqlite';

// Instantiate the Artist class with the database path
$artist = new Bank($dbPath);

// Extract POST data
$Name = isset($_POST['Name']) ? $_POST['Name'] : '';

// Check if Name is longer than 60 characters
if (strlen($Name) > 60) {
    // Print an error message
    echo "<p>Name is required and should be a maximum of 60 characters.</p>";
    // Provide a back button
    echo "<a href='http://localhost:7777/crud/create/create.php'>Go Back</a>";
    exit;
}
// Proceed with user creation if validation passes
// Assuming createUser method has been adjusted to not require ArtistId or dbPath as parameters
// $result = $artist->createUser($Name);

// Based on the createUser method, you might want to handle success or further errors here
?>
