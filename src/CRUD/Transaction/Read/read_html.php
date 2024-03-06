<?php include("../../../include/_header.php") ?>
<?php

require './read.php'; // Assuming this path is correct and `read.php` is in the same directory

$db = connect_database(); // Ensure the database connection is set up

echo "<div class='container'>";
echo "<button class='btn btn-primary mb-3' onclick=\"location.href='../../Transaction/Create/create_html.php?'\">Create Transaction</button>";

echo "<table class='table table-bordered'>";
echo "<thead class='thead-light'>";
echo "<tr>
        <th>ID</th>
        <th>Date</th>
        <th>Vender</th>
        <th>Expense</th>
        <th>Deposit</th>
        <th>Budget</th>
        <th>Category</th>
        <th></th>
      </tr>";
echo "</thead>";
echo "<tbody>";

$transactions = get_transactions($db);

foreach ($transactions as $transaction) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($transaction['transaction_id']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['transaction_date']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['name']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['expense']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['income']) . "</td>";
    echo "<td>" . htmlspecialchars($transaction['overall_balance']) . "</td>";
    $category = empty($transaction['category']) ? 'Other' : htmlspecialchars($transaction['category']);
    echo "<td>" . $category . "</td>"; // Display the category
    echo "<td>";
    echo "<button class='btn btn-sm btn-info mr-1' onclick=\"location.href='../../Transaction/Update/update_html.php?id=" . $transaction['transaction_id'] . "'\">Update</button>";
    echo "<button class='btn btn-sm btn-danger' onclick=\"location.href='../../Transaction/Delete/delete.php?id=" . $transaction['transaction_id'] . "'\">Delete</button>";
    echo "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-3">
        <button class="btn btn-secondary" onclick="location.href='../../../index.php'">Back</button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php include("../../../include/_footer.php") ?>
