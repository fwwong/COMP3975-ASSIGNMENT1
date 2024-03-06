<?php include("../include/_header.php") ?>

<?php
// Assuming $db is your database connection
require_once '../database_setup.php';
$db = connect_database(); // Make sure you adjust this line according to how you set up and access your database connection

// Include your functions file if they are defined in a separate file
require_once './chart.php'; // Adjust the path accordingly

// Set the default year to 2023 or get the year from user input
$year = $_POST['year'] ?? 2023;

$availableYears = getAvailableYears($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Summary</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            padding: 20px;
        }

        .container {
            max-width: 800px;
        }

        form {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-3">Expense Report</h2>

        <!-- Form to select year -->
        <form action="chart_html.php" method="post" class="mb-3">
            <div class="form-group">
                <label for="year">Select Year:</label>
                <select name="year" id="year" class="form-control">
                    <?php
                    foreach ($availableYears as $availableYear) {
                        echo "<option value=\"$availableYear\" ";
                        if ($availableYear == $year) {
                            echo "selected";
                        }
                        echo ">$availableYear</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php
        if (in_array($year, $availableYears)) {
            echo '<div class="row">';
            echo '<div class="col-md-6">';
            generateExpenseSummaryTable($db, $year);
            echo '</div>';
            echo '<div class="col-md-6">';
            generateExpensePieChart($db, $year);
            echo '</div>';
            echo '</div>';
        } else {
            echo "<p class='text-danger'>The selected year is not available. Please select one of the following years: ";
            echo implode(", ", $availableYears) . "</p>";
        }
        ?>

        <!-- Optionally, include a back button or other navigation elements as needed -->
        <button onclick="location.href='../index.php'" class="btn btn-secondary mt-3">Back</button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php include("../include/_footer.php") ?>
