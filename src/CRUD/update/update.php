<?php
session_start(); // Start a session
include("../../inc_header.php");

// Initialize an array to store validation errors
$errors = [];

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']); // Clear error messages from session
}

if (isset($_GET['id'])) {
    $dbPath = '../../chinook.db'; // Adjusted to the correct database path

    // Open or create the SQLite database
    $conn = new SQLite3($dbPath);

    if ($conn) {
        $id = $_GET['id'];

        // Create a prepared statement
        $stmt = $conn->prepare("SELECT * FROM artists WHERE ArtistId=:ArtistId");

        // Bind parameters for markers
        $stmt->bindValue(':ArtistId', $id, SQLITE3_INTEGER);

        // Execute query
        $result = $stmt->execute();

        if ($result) {
            // Bind variables to prepared statement
            $resultArray = $result->fetchArray(SQLITE3_ASSOC);

            if ($resultArray) {
                $ArtistId = $resultArray['ArtistId'];
                $Name = $resultArray['Name'];
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error: Artist ID not found</div>";
?>
                <br />
                <a href="../list" class="btn btn-small btn-primary">&lt;&lt; BACK</a>
<?php
                exit();
            }
        }

        // Close the SQLite statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<style>
.error-message {
    color: #ff0000; /* Red color for error messages */
    font-weight: bold;
    margin-top: 5px;
}
</style>

<h1>Update Artist</h1>

<div class="row">
    <div class="col-md-4">
        <form action="process_update.php" method="post"> <!-- Adjusted action -->

            <div class="form-group">
                <input type="hidden" value="<?php echo $ArtistId ?>" name="ArtistId" />
                <label class="control-label">Artist ID</label>
                <?php echo $ArtistId ?>
            </div>

            <div class="form-group">
                <label for="Name" class="control-label">Artist Name</label>
                <div class="input-error-container">
                    <input type="text" class="form-control" name="Name" id="Name" value="<?php echo $Name; ?>" maxlength="100" />
                    <?php if (in_array('Name', $errors)) { echo '<div class="error-message">Name is required and should be a maximum of 60 characters.</div>'; } ?>
                </div>
            </div>

            <div class="form-group">
                <a href="../../index.php" class="btn btn-small btn-primary">&lt;&lt; BACK</a> <!-- Adjusted link -->
                &nbsp;&nbsp;&nbsp;
                <input type="submit" value="Update" name="update" class="btn btn-warning" />
            </div>
        </form>
    </div>
</div>

<br />

<?php include("../../inc_footer.php"); ?>
