<?php
include("../../utils.php");
include("../../Artist.php");

// Create an instance of the Artist class with the database path
$artist = new Artist('../../chinook.db');

// Check if the 'update' form was submitted
if (isset($_POST['update'])) {
    // Extract POST data
    extract($_POST);

    // Call the updateArtist method to update the artist record
    $updateResult = $artist->updateArtist($ArtistId, $Name);

    // Check the result of the update operation
    if ($updateResult === true) {
        // If update is successful, redirect to the homepage or artist list page
        header('Location: ../../index.php'); // Adjust the redirection path as necessary
        exit;
    } elseif (is_array($updateResult)) {
        // If there are validation errors, store them in the session and redirect back to the form
        session_start();
        $_SESSION['errors'] = $updateResult;
        header('Location: edit_artist.php?ArtistId=' . $ArtistId); // Adjust the redirection path as necessary
        exit;
    } else {
        // If there's a database connection error, display it
        echo '<div class="error-message">Database connection failed</div>';
    }
}
?>
