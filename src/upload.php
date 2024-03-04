<?php
// Include the database setup file
require_once 'create_db.php';

$db = createDatabase();

// Create 'transactions' table if not exists
$sqlTransactions = "CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    date TEXT NOT NULL,
    vender TEXT NOT NULL,
    spending TEXT,
    deposit TEXT,
    budget TEXT,
    category TEXT
)";
$db->exec($sqlTransactions);

// Create 'buckets' table if not exists
$sqlBuckets = "CREATE TABLE IF NOT EXISTS buckets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    category TEXT NOT NULL,
    vender TEXT NOT NULL
)";
$db->exec($sqlBuckets);

// Ensure the 'imported' directory exists
$importedDir = 'imported';
if (!is_dir($importedDir)) {
    mkdir($importedDir, 0755, true);
}


function categorizeTransaction($vender, $deposit = null) {
    if (!empty($deposit) && $deposit > 0) {
        return "Deposits";
    }

    $categories = [
        'Restaurants' => ['RESTAURAT', 'RESTAUR', 'MCDONALDS', 'Subway', 'WHITE SPOT'],
        'Groceries' => ['SAFEWAY', 'REAL CDN SUPERS', 'COSTCO'],
        'Utilities' => ['FORTISBC', 'SHAW CABLE'],
        'Payments' => ['ICBC', 'ROGERS'],
        'Charity' => ['RED CROSS', 'World Vision'],
        // Add more categories and keywords as needed
    ];

    foreach ($categories as $category => $keywords) {
        foreach ($keywords as $keyword) {
            if (strpos($vender, $keyword) !== false) {
                return $category;
            }
        }
    }

    return "Other"; // Default category if no match is found
}

function insertOrUpdateBucket($db, $category, $vender) {
    // Prepare the statement to check if the combination of category and vender already exists
    $stmt = $db->prepare("SELECT id FROM buckets WHERE category = ? AND vender = ?");
    $stmt->bindValue(1, $category, SQLITE3_TEXT); // Bind the category
    $stmt->bindValue(2, $vender, SQLITE3_TEXT); // Bind the vender
    $result = $stmt->execute(); // Execute without parameters

    // Fetch the result to see if it exists
    $exists = $result->fetchArray();
    
    if (!$exists) {
        // Prepare the statement to insert new category and vender into buckets
        $insertStmt = $db->prepare("INSERT INTO buckets (category, vender) VALUES (?, ?)");
        $insertStmt->bindValue(1, $category, SQLITE3_TEXT); // Bind the category
        $insertStmt->bindValue(2, $vender, SQLITE3_TEXT); // Bind the vender
        $insertStmt->execute(); // Execute without parameters
    }
}

if(isset($_POST["submit"])) {
    $totalFiles = count($_FILES['fileToUpload']['name']);
    for($i = 0; $i < $totalFiles; $i++) {
        if($_FILES["fileToUpload"]["error"][$i] == 0) {
            $file = $_FILES["fileToUpload"]["tmp_name"][$i];
            $originalName = $_FILES["fileToUpload"]["name"][$i];
            $handle = fopen($file, "r");

            if ($handle !== FALSE) {
                fgetcsv($handle); // Skip header row
                
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $category = categorizeTransaction($data[1], isset($data[3]) ? $data[3] : null);

                    // Prepare the statement for inserting into transactions table
                    $stmt = $db->prepare("INSERT INTO transactions (date, vender, spending, deposit, budget, category) VALUES (?, ?, ?, ?, ?, ?)");

                    // Bind values to the statement
                    $stmt->bindValue(1, $data[0], SQLITE3_TEXT);
                    $stmt->bindValue(2, $data[1], SQLITE3_TEXT);
                    $stmt->bindValue(3, $data[2], SQLITE3_TEXT);
                    $stmt->bindValue(4, $data[3], SQLITE3_TEXT);
                    $stmt->bindValue(5, $data[4], SQLITE3_TEXT);
                    $stmt->bindValue(6, $category, SQLITE3_TEXT);

                    // Execute the statement
                    $stmt->execute();

                    // Update buckets table with the new transaction category and vender
                    insertOrUpdateBucket($db, $category, $data[1]);
                }

                fclose($handle);

                // Move the processed file to the 'imported' folder with a .imported extension
                $importedFolderPath = 'imported/';
                if (!is_dir($importedFolderPath)) {
                    mkdir($importedFolderPath, 0777, true); // Create the folder if it doesn't exist
                }

                $newFileName = pathinfo($originalName, PATHINFO_FILENAME) . '.imported';
                $destination = $importedFolderPath . $newFileName;

                if (move_uploaded_file($file, $destination)) {
                    echo "CSV data from file " . htmlspecialchars($originalName) . " has been successfully processed and saved as " . htmlspecialchars($newFileName) . ".<br>";
                } else {
                    echo "Failed to save the processed file " . htmlspecialchars($originalName) . ".<br>";
                }

            } else {
                echo "Failed to open uploaded file " . htmlspecialchars($originalName) . ".<br>";
            }
        } else {
            echo "Error uploading file " . htmlspecialchars($_FILES["fileToUpload"]["name"][$i]) . ".<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV File Upload</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        Select CSV file to upload:
        <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
        <input type="submit" value="Upload CSV" name="submit">
    </form>
</body>
</html>