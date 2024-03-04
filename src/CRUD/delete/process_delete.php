<?php
include("../../Artist.php"); // Adjust the path as necessary

// Create an instance of the Artist class with the correct database path
$artist = new Artist('../../chinook.db'); // Assuming 'chinook.db' is your database, adjust the path as needed

// Check if ArtistId is set in the POST data
if (isset($_POST['ArtistId'])) {
    // Extract the ArtistId from the POST data
    $ArtistId = $_POST['ArtistId'];
    
    // Call the deleteArtist method to delete the artist
    $artist->deleteArtist('../../chinook.db', $ArtistId); // No need to pass dbPath again if it's already set in the constructor
}
?>
