<!-- Main page for users who are logged in -->
<?php
// Initialize the session
session_start();
?>

<?php include("../include/_header.php") ?>
<?php include("../include/_navbar.php") ?>

<div class="container">
    <!-- welcome to the user by their first name -->
    <div class="alert alert-success">
        <strong>Welcome <?php echo $_SESSION["first_name"]; ?>!</strong> You have successfully logged in.
    </div>
    <p>What would you like to do today?</p>
    <div class="row">
        <!-- First card - Always display -->
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Transactions</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Upload CSV file and Create</h6>
                    <a href="/user_screen.php" class="btn btn-primary">Transactions</a>
                </div>
            </div>
        </div>
        <!-- Second card - Display only for admins -->
        <?php if ($_SESSION['account_type'] == 'admin'): ?>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Administration</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Manage Users verification</h6>
                    <a href="admin.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <!-- Log Out button -->
    <a href="../logout.php" class="btn btn-primary">Log Out</a>
</div>

<?php include("../include/_footer.php") ?>
