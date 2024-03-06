<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" >COMP3975 Assignment</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../src/CRUD/Transaction/Read/read_html.php">View Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../src/Chart/chart_html.php">View Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../src/CRUD/Bucket/Read/read_html.php">Bucket</a>
                </li>
                <?php
                if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
                    // Display the admin buttons
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="../User/admin.php">Admin Panel</a>';
                    echo '</li>';
                    // echo '<li class="nav-item">';
                    // echo '<a class="nav-link" href="../src/CRUD/Bucket/Read/read_html.php">Bucket</a>';
                    // echo '</li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="../User/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


