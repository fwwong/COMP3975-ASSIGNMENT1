<?php
include("../../bank.php"); 

// Create an instance of the BankDatabase class with the correct database path
$bankDatabase = new Bank('../../bank.sqlite'); // Adjust the path as needed

// Check if the transaction ID is set in the POST data
if (isset($_GET['id'])) {
    // Extract the TransactionId from the POST data
    $TransactionId = $_GET['id'];
    
    // Call the deleteTransaction method to delete the specified transaction
    $result = $bankDatabase->deleteBuckets($TransactionId);
    
    if ($result) {
        echo "Transaction successfully deleted.";
          // Provide a back button
        echo "<br>";
        echo "<a href='../../members/user_screen.php'>Go Back</a>"; 
    } else {
        echo "Failed to delete the transaction.";
    }
} else {
    echo "Transaction ID not specified.";
    // Handle the error, such as displaying a message or redirecting
}
?>
