<?php include("../../../include/_header.php") ?>

<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../Read/Read.php'; // Include the file that sets up your database connection
require './update.php';

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info" role="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}

$id = $_GET['id'];
$transaction = get_transaction_id($db, $id); // You need to implement this function

// Convert the transaction date from the database to 'YYYY-MM-DD' format for the date input field
$transaction_date = date('Y-m-d', strtotime($transaction['transaction_date']));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Transaction</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            padding: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="date"],
        form input[type="text"],
        form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mt-5 mb-4">Update Transaction</h2>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($transaction_date); ?>">
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($transaction['name']); ?>">
            </div>
            <div class="form-group">
                <label for="expense">Expense:</label>
                <input type="number" id="expense" name="expense" step="any" class="form-control" value="<?php echo htmlspecialchars(number_format($transaction['expense'], 2, '.', '')); ?>">
            </div>
            <div class="form-group">
                <label for="income">Income:</label>
                <input type="number" id="income" name="income" step="any" class="form-control" value="<?php echo htmlspecialchars(number_format($transaction['income'], 2, '.', '')); ?>">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update</button>
             <button onclick="window.location.href = '../Read/read_html.php';" class="btn btn-secondary btn-block mt-3">Back</button>
        </form>

       
    </div>
    <?php
    // Unset the form data after displaying it
    if (isset($_SESSION['form_data'])) {
        unset($_SESSION['form_data']);
    }
    ?>
</body>

</html>

<?php include("../../../include/_footer.php") ?>
