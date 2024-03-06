<?php include("../../../include/_header.php") ?>
<?php require './read.php'; // Make sure this path is correct for your project structure

session_start();
$db = connect_database(); // Initialize your database connection
$buckets = get_buckets($db); // Fetch all buckets
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Buckets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php
        if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            echo '<button onclick="location.href=\'../Create/create_html.php\'">Create Bucket</button>';
        }
    ?>

    <table>
        <thead>
            <tr>
                <th>Bucket ID</th>
                <th>Transaction Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($buckets as $bucket) : ?>
                <tr>
                    <td><?= htmlspecialchars($bucket['bucket_id']) ?></td>
                    <td><?= htmlspecialchars($bucket['transaction_name']) ?></td>
                    <td><?= htmlspecialchars($bucket['category']) ?></td>
                  <?php
                        if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                            echo "<td>";
                            echo "<button onclick=\"location.href='../Update/update_html.php?id=" . htmlspecialchars($bucket['bucket_id']) . "'\">Update</button>";
                            echo "<button onclick=\"location.href='../Delete/delete.php?id=" . htmlspecialchars($bucket['bucket_id']) . "'\">Delete</button>";
                            echo "</td>";
                        }
                    ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button onclick="location.href='../../../index.php'">Back</button>
</body>

</html>

<?php include("../../../include/_footer.php") ?>
