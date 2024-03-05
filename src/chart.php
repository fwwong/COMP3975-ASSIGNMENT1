<?php
// Include the database setup file
require_once 'create_db.php';

// Create database if not exists
$db = createDatabase();

// Query to fetch spending per category
$spendingDataPoints = [['Category', 'Total Spending']];
$spendingHTML = "<table border='1'><tr><th>Category</th><th>Total Spending</th></tr>";

$sqlSpending = "SELECT category, SUM(spending) AS total_spending FROM transactions WHERE spending > 0 GROUP BY category";
$result = $db->query($sqlSpending);
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $spendingDataPoints[] = [$row['category'], (float)$row['total_spending']];
    $spendingHTML .= "<tr><td>" . htmlspecialchars($row['category']) . "</td><td>" . number_format($row['total_spending'], 2) . "</td></tr>";
}
$spendingHTML .= "</table>";
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spending Chart and Table</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawSpendingChart);

    function drawSpendingChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($spendingDataPoints, JSON_NUMERIC_CHECK); ?>);
        var options = {'title':'Spending Breakdown by Category', 'width':550, 'height':400};
        var chart = new google.visualization.PieChart(document.getElementById('spending_chart_div'));
        chart.draw(data, options);
    }
    </script>
</head>
<body>
    <div id="chart_container">
        <div id="spending_chart_div"></div>
        <div>
            <h3>Spending Details</h3>
            <?php echo $spendingHTML; ?>
        </div>
    </div>
</body>
</html>
