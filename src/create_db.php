<?php
// Function to create SQLite database if it doesn't exist
function createDatabase() {
    $dbPath = __DIR__ . '/members/bank.sqlite';

    // Open or create the SQLite database
    $conn = new SQLite3($dbPath);
    
    // Check if the SQLite database file exists
    if (file_exists($dbPath)) {
        // Database already exists
    } else {
        // Attempt to create the SQLite database
        $conn = new SQLite3($dbPath);
        
        if (!$conn) {
            die("Failed to open database");
        }
    }
    
    return $conn;
}
?>
