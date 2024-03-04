<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV File Upload</title>
</head>
<body>
    <section>
        <h2>Upload a CSV file</h2>
        <?php include 'upload.php'; ?>
    </section>

    <section>
        <h2>Display data</h2>
          <div style="margin-top: 20px;">
             <a href="/CRUD/create/create.php">Create New Entry</a>
         </div>
        <?php include 'display.php'; ?>
    </section>
</body>
</html>