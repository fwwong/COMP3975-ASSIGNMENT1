<?php
include("../../bank.php"); // Ensure this path correctly points to your Bank class definition

$dbPath = '../../bank.sqlite'; // Confirm the database path is correct

// Instantiate the Bank class with the database path
$bankDatabase = new Bank($dbPath);

// Extract POST data for bucket management
$category = isset($_POST['Category']) ? $_POST['Category'] : '';
$vender = isset($_POST['Vender']) ? $_POST['Vender'] : '';

// Simple validation
if (empty($category) || empty($vender)) {
    // Print an error message if mandatory fields are missing
    echo "<p>Both Category and Vender fields are required.</p>";
    // Provide a back button for user correction
    echo "<a href='manage_buckets.php'>Go Back</a>"; // Adjust the href to your directory structure
    exit;
}

// Proceed with adding or updating the bucket if validation passes
$result = $bankDatabase->upsertBucket($category, $vender);

if ($result) {
    echo "<p>Bucket successfully managed.</p>";
    echo "<a href='/'>View Buckets</a>"; // Adjust this URL to where you list or manage buckets
} else {
    echo "<p>Failed to manage the bucket. Please check the log for details.</p>";
    echo "<a href='/'>Try Again</a>"; // Adjust this URL to your retry logic or bucket management page
}
?>
