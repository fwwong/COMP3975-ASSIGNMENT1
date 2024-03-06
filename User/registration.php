<?php include("../src/include/_header.php") ?>

<?php

// Start PHP session
session_start();

// If form is submitted, process the form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../src/database_setup.php'; // Include your database setup file
    $db = connect_database(); // Connect to the database

    // Sanitize user inputs
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // You'll hash this, so no need to sanitize

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $stmt = $db->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
    $stmt->bindValue(1, $email, SQLITE3_TEXT);
    $stmt->bindValue(2, $password_hash, SQLITE3_TEXT);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Registration submitted for approval.</div>';
        // Redirect or perform additional actions as needed
    } else {
        echo '<div class="alert alert-danger" role="alert">There was an error submitting your registration.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Register</h2>
                <form action="registration.php" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
                <button class="btn btn-secondary btn-block mt-3" onclick="location.href='../index.php'">Back</button>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php include("../src/include/_footer.php") ?> 