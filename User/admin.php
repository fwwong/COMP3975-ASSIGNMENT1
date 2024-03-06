<?php include("../src/include/_header.php") ?>
<?php include("../src/include/_navbar.php") ?>

<?php


// Include database connection setup
require_once '../src/database_setup.php'; // Include your database setup file
$db = connect_database(); // Connect to the database

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Unauthorized access.");
}

// Check if there's a POST request to approve a user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_user_id'])) {
    $user_id_to_approve = $_POST['approve_user_id'];
    $stmt = $db->prepare("UPDATE users SET is_approved = 1 WHERE user_id = ?");
    $stmt->bindValue(1, $user_id_to_approve, SQLITE3_INTEGER);
    $stmt->execute();
}

// Fetch unapproved users
$unapproved_users = $db->query("SELECT user_id, email FROM users WHERE is_approved = 0");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approval</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        .container {
            padding-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .action-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Admin User Approval</h2>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>User ID</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $unapproved_users->fetchArray(SQLITE3_ASSOC)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <form method="post" action="admin.php">
                                <input type="hidden" name="approve_user_id" value="<?php echo $user['user_id']; ?>">
                                <button type="submit" class="action-btn">Approve</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button class="btn btn-secondary" onclick="location.href='../src/index.php'">Back</button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php include("../src/include/_footer.php") ?>
