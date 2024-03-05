<?php include("/include/_database.php")?>

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