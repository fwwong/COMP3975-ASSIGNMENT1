<?php
include("../../bank.php"); // Update the include path to where your BankDatabase class is defined

$dbPath = __DIR__ . '/members/bank.sqlite'; // Assuming the database path is correct
$bankDatabase = new Bank($dbPath);

// Extract POST data for transaction creation
$date = isset($_POST['Date']) ? $_POST['Date'] : '';
$vender = isset($_POST['Vender']) ? $_POST['Vender'] : '';
$spending = isset($_POST['Spending']) ? $_POST['Spending'] : null; // Assuming 0 as default
$deposit = isset($_POST['Deposit']) ? $_POST['Deposit'] : null; // Assuming 0 as default
$budget = isset($_POST['Budget']) ? $_POST['Budget'] : 0; // Assuming 0 as default
echo $vender;

// Simple validation
if (empty($date) || empty($vender)) {
    echo "<p>Date and Vender fields are required.</p>";
    echo "<a href='create.php'>Go Back</a>"; // Adjust the href as per your directory structure
    exit;
}
// Proceed with transaction creation if validation passes
$result = $bankDatabase->addTransaction($date, $vender, $spending, $deposit);

if ($result) {
    echo "<p>Transaction successfully added.</p>";
    echo "<a href='../../members/user_screen.php'>View Transactions</a>"; // Adjust as per your directory structure
} else {
    echo "<p>Failed to add the transaction. Please check the log for details.</p>";
    echo "<a href='../../members/user_screen.php'>Try Again</a>"; // Adjust the href as per your directory structure
}

?>
