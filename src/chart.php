<?php
// Include the database setup file
require_once 'create_db.php';

// Create database if not exists
$db = createDatabase();

// Query to fetch spending per category
$spendingDataPoints = [];
$sqlSpending = "SELECT category, SUM(spending) AS total_spending FROM transactions WHERE spending > 0 GROUP BY category";
$resSpending = $db->query($sqlSpending);

// Initialize the array with column names for the spending chart
$spendingDataPoints = [['Category', 'Total Spending']];
$spendingHTML = "<table border='1' style='margin-top: 20px;'><tr><th>Category</th><th>Spending</th></tr>"; // Initialize table HTML

while ($row = $resSpending->fetchArray(SQLITE3_ASSOC)) {
    $arrayItem = [$row['category'], (float)$row['total_spending']];
    array_push($spendingDataPoints, $arrayItem);
    // Add row to spending table HTML
    $spendingHTML .= "<tr><td>" . htmlspecialchars($row['category']) . "</td><td>" . number_format($row['total_spending'], 2) . "</td></tr>";
}

$spendingHTML .= "</table>";

$db->close();
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="chart_container">
    <div id="spending_chart_div"></div>
    <div>
        <h3>Spending</h3>
        <?php echo $spendingHTML; ?>
    </div>
</div>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawSpendingChart);

function drawSpendingChart() {
  var data = google.visualization.arrayToDataTable(<?php echo json_encode($spendingDataPoints, JSON_NUMERIC_CHECK); ?>);

  var options = {'title':'Spending Breakdown by Category', 'height':400};

  var chart = new google.visualization.PieChart(document.getElementById('spending_chart_div'));
  chart.draw(data, options);
}
</script>
<br>
 <button onclick="window.location.href='/';">Back</button>
