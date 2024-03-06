<?php

require_once '../../../database_setup.php'; // Adjust the path as necessary to ensure correct inclusion

$db = connect_database(); // Make sure this function correctly initializes your SQLite3 database connection

// PHP to handle deletion from the buckets table
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL DELETE statement to target the buckets table
    $stmt = $db->prepare("DELETE FROM buckets WHERE bucket_id = ?");
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);

    // Execute the statement
    $result = $stmt->execute();

    // Check for successful deletion
    if ($result) {
        // Success - redirect to a confirmation page or the buckets listing
        header("Location: ../Read/read_html.php"); // Adjust the redirection path to your actual listing page for buckets
        exit;
    } else {
        // Failure - handle the error, e.g., log it, display an error message, etc.
        echo "Error deleting bucket. Please try again.";
        // Optionally, redirect back or to an error page
    }
} else {
    // No ID provided, handle the error or redirect
    echo "No bucket ID provided.";
    // Optionally, redirect to a safe page
}
