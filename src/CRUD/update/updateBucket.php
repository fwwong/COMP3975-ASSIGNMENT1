<?php
// Include the Bank class
include("../../Bank.php");
$bank = new Bank('../../bank.sqlite');

// Retrieve bucket details
$bucketId = isset($_GET['id']) ? $_GET['id'] : null;
$bucketDetails = $bank->getBucketDetails($bucketId); // Assume this method exists

// Check if bucket details are successfully retrieved
if (!$bucketDetails) {
    echo "Bucket not found.";
    exit;
}

session_start();
?>

<h1>Update Bucket</h1>

<?php
if (!empty($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<div style='color: red;'>{$error}</div>";
    }
    unset($_SESSION['errors']);
}
?>

<form action="/CRUD/update/process_buckets_update.php" method="post">
    <input type="hidden" name="BucketId" value="<?php echo htmlspecialchars($bucketId); ?>">

    <label for="Category">Category:</label>
    <input type="text" name="Category" id="Category" value="<?php echo htmlspecialchars($bucketDetails['category']); ?>">

    <label for="Vender">Vender:</label>
    <input type="text" name="Vender" id="Vender" value="<?php echo htmlspecialchars($bucketDetails['vender']); ?>">

    <button type="submit" name="updateBucket">Update Bucket</button>
</form>