<?php
// Include the Bank class
include("../../Bank.php");
$bank = new Bank('../../bank.sqlite');

// Retrieve transaction details (mock-up, replace with actual retrieval code)
$transactionId = isset($_GET['id']) ? $_GET['id'] : null;
$transactionDetails = $bank->getTransactionDetails($transactionId); // Implement this method

// Check if transaction details are successfully retrieved
if (!$transactionDetails) {
    // Handle error, transaction not found
    echo "Transaction not found.";
    exit;
}

// Start the session for error handling
session_start();
?>

<h1>Update Transaction</h1>

<?php
// Display any errors
if (!empty($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<div style='color: red;'>{$error}</div>";
    }
    // Clear errors after displaying
    unset($_SESSION['errors']);
}
?>

<form action="/CRUD/update/process_buckets_update.php" method="post">
    <input type="hidden" name="TransactionId" value="<?php echo htmlspecialchars($transactionId); ?>">

    <!-- Form fields for transaction details -->
    <label for="Date">Date:</label>
    <input type="date" name="Date" id="Date" value="<?php echo htmlspecialchars($transactionDetails['date']); ?>">

    <label for="Vender">Vender:</label>
    <input type="text" name="Vender" id="Vender" value="<?php echo htmlspecialchars($transactionDetails['vender']); ?>">

    <label for="Spending">Spending:</label>
    <input type="number" name="Spending" id="Spending" value="<?php echo htmlspecialchars($transactionDetails['spending']); ?>">

    <label for="Deposit">Deposit:</label>
    <input type="number" name="Deposit" id="Deposit" value="<?php echo htmlspecialchars($transactionDetails['deposit']); ?>">

    <button type="submit" name="update">Update Transaction</button>
</form>
