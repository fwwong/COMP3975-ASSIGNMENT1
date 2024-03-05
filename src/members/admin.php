<?php
// Initialize the session
session_start();
?>
<?php include("../include/_header.php") ?>
<a href="home.php" class="btn btn-primary">Back</a>
<div class="container text-center">
    <h1>Adminstration: Vertification User Dashboard</h1>
    <p>Manage Users verification: How to use:</p>
    <p> 1. Click on the verify button to verify the user: <b>0</b> is not vertified; <b>1</b> is verified <br>
     2. Once the user is verified, the user can log in and access the system.</p>
    <!-- display all user in the database  -->
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Account Type</th>
                        <th scope="col">Verified</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once "../bank.php";
                    $dbPath = '../bank.sqlite';
                    $bank = new Bank($dbPath);
                    $users = $bank->getUsers();
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . $user['id'] . "</td>";
                        echo "<td>" . $user['first_name'] . "</td>";
                        echo "<td>" . $user['last_name'] . "</td>";
                        echo "<td>" . $user['username'] . "</td>";
                        echo "<td>" . $user['account_type'] . "</td>";
                        echo "<td>" . $user['verified'] . "</td>";
                        echo "<td>" . "<a href='verify_user.php?id=" . $user['id'] . "' class='btn btn-info btn-sm'>Verify</a>" . "</td>";
                        echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
            <div>
                <p>Number of users: <?php echo count($users); ?> </p>
            </div>
        </div>
    </div>
</div>

<?php include("../include/_footer.php") ?>

