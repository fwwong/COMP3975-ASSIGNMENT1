<!-- Main page for user that are logged in  -->
<?php include("../include/_header.php") ?>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
} ?>

<p>Welcome! you are now in the system</p>
<!-- log out button -->
<div class="container">
    <a href="../index.php" class="btn btn-danger">Sign Out of Your Account</a>
    <!-- end session  --> 
    <?php
    // Unset all of the session variables
    $_SESSION = array();
    // Destroy the session.
    session_destroy();
    ?>
</div>
<?php include("../include/_footer.php") ?>