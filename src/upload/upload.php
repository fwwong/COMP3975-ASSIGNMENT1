<?php
session_start(); // Start the session at the beginning of the file
require '../database_setup.php';

// Initialize an array to hold messages and a flag for overall success
$_SESSION['messages'] = [];
$allFilesSuccess = true; // Assume success until proven otherwise

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['transactionFiles'])) {
    $uploadDir = '../imported/'; // Specify the directory where files should be uploaded
    
    // Loop through each file in the uploaded array
    foreach ($_FILES['transactionFiles']['name'] as $key => $name) {
        if ($_FILES['transactionFiles']['error'][$key] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['transactionFiles']['tmp_name'][$key];
            $uploadFile = $uploadDir . basename($name);
            $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            if ($fileType !== 'csv') {
                $_SESSION['messages'][] = "Error: Only CSV files are allowed for file $name.";
                $allFilesSuccess = false;
                continue; // Skip this file and go to the next one
            }

            if (move_uploaded_file($tmp_name, $uploadFile)) {
                // Call your function to process and import CSV data into the database
                $db = connect_database();
                $importResult = importCSVToSQLite($uploadFile, $db); // Assume this function returns true on success
     
                if (!$importResult) {
                    $_SESSION['messages'][] = "Failed to import the file $name.";
                    $allFilesSuccess = false;
                } else {
                    $_SESSION['messages'][] = "The file $name has been successfully uploaded and imported.";
                }
                
            } else {
                $_SESSION['messages'][] = "There was an error uploading your file $name.";
                $allFilesSuccess = false;
            }
        } else {
            $_SESSION['messages'][] = "Error uploading file $name.";
            $allFilesSuccess = false;
        }
    }

    // If all files were successfully processed, set a general success message
    if ($allFilesSuccess) {
        $_SESSION['messages'] = ["All data has been successfully uploaded and imported."];
    }
    
} else {
    $_SESSION['messages'][] = "No file uploaded or wrong method used.";
}

header("Location: ../index.php");
exit;
?>


