<?php include ('create_db.php');?>

<?php

// Create database if not exists
$db = createDatabase();

// Initialize results to null
$transactionsResult = null;
$bucketsResult = null;

// Check if the transactions table exists
$transactionsTableExists = $db->querySingle("SELECT count(*) FROM sqlite_master WHERE type='table' AND name='transactions'");

// If the transactions table exists, fetch all records from it
if ($transactionsTableExists) {
    $transactionsResult = $db->query("SELECT id, date, vender, spending, deposit, budget, category FROM transactions");
}

// Check if the buckets table exists
$bucketsTableExists = $db->querySingle("SELECT count(*) FROM sqlite_master WHERE type='table' AND name='buckets'");

// If the buckets table exists, fetch all records from it
if ($bucketsTableExists) {
    $bucketsResult = $db->query("SELECT id, category, vender FROM buckets");
} 

// Add Report button/link here
echo "<div style='text-align: center; margin-top: 20px;'>";
echo "<a href='../chart.php' class='button'>View Report</a>";

// Display the layout
echo "<div style='display: flex; justify-content: space-between; flex-wrap: wrap;'>"; // Use flex-wrap for responsiveness

// Transaction table
echo "<div style='width: 48%;'>"; // Adjust the width as needed
echo "<h2>Transaction Table</h2>";
echo "<table border='1' style='width: 100%;'>";
echo "<tr><th>Date</th><th>Vender</th><th>Spending</th><th>Deposit</th><th>Budget</th><th>Category</th></tr>";

// Loop through the transactions result and display each row in the table
if ($transactionsResult) {
    while ($row = $transactionsResult->fetchArray(SQLITE3_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['date'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['vender'] ?? '') . "</td>";
        // Check if spending is numeric and not null before formatting
        echo "<td>" . (is_numeric($row['spending']) ? htmlspecialchars(number_format((float)$row['spending'], 2)) : '') . "</td>";
        // Check if deposit is numeric and not null before formatting
        echo "<td>" . (is_numeric($row['deposit']) ? htmlspecialchars(number_format((float)$row['deposit'], 2)) : '') . "</td>";
        echo "<td>" . htmlspecialchars($row['budget'] ?? '') . "</td>";
        echo "<td>" . htmlspecialchars($row['category'] ?? '') . "</td>";
        echo "<td><a href='/CRUD/update/update.php?id=" . htmlspecialchars($row['id']) . "'>Edit</a></td>";
        echo "<td><a href='/CRUD/delete/process_transaction_delete.php?id=" . htmlspecialchars($row['id']) . "' onclick=\"return confirm('Are you sure?')\">Delete</a></td>";
        echo "</tr>";
    }
}


echo "</table>";
echo "</div>"; // Close container for the transaction table

// Buckets table
echo "<div style='width: 48%; margin-top: 20px;'>"; // Ensure it aligns or stacks properly based on flex-wrap
echo "<h2>Buckets Table</h2>";
echo "<table border='1' style='width: 100%;'>";
echo "<tr><th>Category</th><th>Vender</th></tr>";

// Loop through the buckets result and display each row in the table
if ($bucketsTableExists) {
    while ($row = $bucketsResult->fetchArray(SQLITE3_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['category']) . "</td>";
        echo "<td>" . htmlspecialchars($row['vender']) . "</td>";
        echo "<td><a href='/CRUD/update/updateBucket.php?id=" . htmlspecialchars($row['id']) . "'>Edit</a></td>";
        echo "<td><a href='/CRUD/delete/process_buckets_delete.php?id=" . htmlspecialchars($row['id']) . "' onclick=\"return confirm('Are you sure?')\">Delete</a></td>";
        echo "</tr>";
    }
}
echo "</table>";
echo "</div>"; // Close container for the buckets table

echo "</div>"; // Close flex container
?>
