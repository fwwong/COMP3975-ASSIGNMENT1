<?php include("./include/_header.php") ?>
<?php include("./include/_navbar.php") ?>



<?php

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    // Use an absolute URL to avoid header injection risks
    header('Location: http://localhost:8888');
    exit; // Prevent further execution of the script
}
// Check if a CSV file is uploaded
if (isset($_FILES['transactionFile']) && $_FILES['transactionFile']['error'] === UPLOAD_ERR_OK) {
    // Process the uploaded file here
    // You can parse the CSV file and insert its data into the database, for example
    // Once the transaction part is processed, you can display a success message or redirect the user to another page
}
if (isset($_SESSION['messages']) && is_array($_SESSION['messages'])) {
    echo '<div class="alert alert-success" role="alert">';
    foreach ($_SESSION['messages'] as $message) {
        echo htmlspecialchars($message) . '<br>'; // Use htmlspecialchars for security
    }
    echo '</div>';
    unset($_SESSION['messages']);
}

include 'database_setup.php';
include './upload/upload_form.php';

$db = connect_database();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMP3975</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Add your transaction display section here -->
        <?php
        if (isset($_FILES['transactionFile']) && $_FILES['transactionFile']['error'] === UPLOAD_ERR_OK) {
            echo '<div class="mt-4 alert alert-info">Transaction CSV file uploaded successfully!</div>';
            // Display the transaction details here
            // You can fetch and display the transaction data from the database, for example
        }
        ?>
        
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php include("./include/_footer.php") ?>
