<?php include("../../../include/_header.php") ?>
<?php
require_once './update.php';

$id = $_GET['id']; // Get the ID from the URL

$bucket = get_bucket_id($db, $id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Bucket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        form {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        form label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <!-- Adjust the action to point to your bucket update handling script -->
    <form action="./update.php" method="post">
        <!-- Include a hidden input to pass the bucket ID -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <label for="transaction_name">Transaction Name:</label><br>
        <input type="text" id="transaction_name" name="transaction_name" value="<?php echo htmlspecialchars($bucket['transaction_name']); ?>" required><br>

        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($bucket['category']); ?>" required><br>

        <input type="submit" value="Update">
    </form>

    <button onclick="location.href='../../Bucket/Read/read_html.php'">Back</button>
</body>

</html>

<?php include("../../../include/_footer.php") ?>
