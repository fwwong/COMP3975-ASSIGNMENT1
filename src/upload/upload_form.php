<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV File</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Optional custom styles */
        body {
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Upload Transaction CSV</h2>
                <form action="../src/upload/upload.php" method="post" enctype="multipart/form-data">
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="transactionFile" name="transactionFiles[]" required multiple>
                        <label class="custom-file-label" for="transactionFile">Choose CSV file</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Upload File</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
