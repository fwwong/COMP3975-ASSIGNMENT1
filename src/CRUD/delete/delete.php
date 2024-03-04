<?php include("../../inc_header.php"); ?>

<h1>Delete Artist</h1>

<?php
if (isset($_GET['id'])) {
    $dbPath = '../../chinook.db';

    // Open or create the SQLite database
    $conn = new SQLite3($dbPath);

    if ($conn) {
        $ArtistId = $_GET['id'];

        // Create a prepared statement to fetch the artist
        $stmt = $conn->prepare("SELECT * FROM artists WHERE ArtistId=:ArtistId");
        $stmt->bindValue(':ArtistId', $ArtistId, SQLITE3_INTEGER);

        // Execute the query
        $result = $stmt->execute();

        // Fetch the row
        $row = $result->fetchArray(SQLITE3_ASSOC);

        if (!$row) {
            echo "<div class='alert alert-danger' role='alert'>Error: Artist ID not found</div>";
            ?>
            <br />
            <a href="../index.php" class="btn btn-small btn-primary">&lt;&lt; BACK</a>
            <?php
            exit();
        }

        // Extract values
        $Name = $row['Name'];

        // Close the statement
        $stmt->close();
    }

    // Close the SQLite connection
    $conn->close();
}
?>

<table>
    <tr>
        <td>Artist ID:</td>
        <td><?php echo $ArtistId ?></td>
    </tr>
    <tr>
        <td>Name:</td>
        <td><?php echo $Name ?></td>
    </tr>
</table>

<br />
<form action="process_delete.php" method="post"> <!-- This should point to your deletion processing script -->
    <input type="hidden" value="<?php echo $ArtistId ?>" name="ArtistId" />
    <a href="../../index.php" class="btn btn-small btn-primary">&lt;&lt; BACK</a> <!-- Adjust based on your directory structure -->
    &nbsp;&nbsp;&nbsp;
    <input type="submit" value="Delete" class="btn btn-danger" />
</form>

<br />

<?php include("../../inc_footer.php"); ?>
