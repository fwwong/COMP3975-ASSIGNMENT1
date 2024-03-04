<?php
// Include the database setup file
require_once 'create_db.php';

// Create database if not exists
$db = createDatabase();

// Query to fetch all records from the transactions table
$transactionsResult = $db->query("SELECT date, vender, spending, deposit, budget, category FROM transactions");

// Query to fetch all records from the buckets table
$bucketsResult = $db->query("SELECT category, vender FROM buckets");

// Add Report button/link here
echo "<div style='text-align: center; margin-top: 20px;'>";
echo "<a href='chart.php' class='button'>View Report</a>";
// Display the layout
echo "<div style='display: flex; justify-content: space-between; flex-wrap: wrap;'>"; // Use flex-wrap for responsiveness

// Transaction table
echo "<div style='width: 48%;'>"; // Adjust the width as needed
echo "<h2>Transaction Table</h2>";
echo "<table border='1' style='width: 100%;'>";
echo "<tr><th>Date</th><th>Vender</th><th>Spending</th><th>Deposit</th><th>Budget</th><th>Category</th></tr>";

// Loop through the transactions result and display each row in the table
while ($row = $transactionsResult->fetchArray(SQLITE3_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
    echo "<td>" . htmlspecialchars($row['vender']) . "</td>";
    echo "<td>" . htmlspecialchars($row['spending']) . "</td>";
    echo "<td>" . htmlspecialchars($row['deposit']) . "</td>";
    echo "<td>" . htmlspecialchars($row['budget']) . "</td>";
    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
    echo "<td><a>Edit</a></td>";
    echo "<td><a>Delete</a></td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>"; // Close container for the transaction table

// Buckets table
echo "<div style='width: 48%; margin-top: 20px;'>"; // Ensure it aligns or stacks properly based on flex-wrap
echo "<h2>Buckets Table</h2>";
echo "<table border='1' style='width: 100%;'>";
echo "<tr><th>Category</th><th>Vender</th></tr>";

// Loop through the buckets result and display each row in the table
while ($row = $bucketsResult->fetchArray(SQLITE3_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
    echo "<td>" . htmlspecialchars($row['vender']) . "</td>";
    echo "<td><a>Edit</a></td>";
    echo "<td><a>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>"; // Close container for the buckets table

echo "</div>"; // Close flex container
?>
