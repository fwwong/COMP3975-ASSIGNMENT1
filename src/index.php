<!-- Main page to direct user to create a new account or login into an existing account -->
<?php include("include/_database.php") ?> 
<?php include("include/_header.php") ?>
<?php include("include/_navbar.php") ?>

<!-- if session still exists this is the home page for the user -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-5">
                <?php include("forms/login_form.php") ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-5">
                <div class="card-title"><h1>SIGN UP</h1></div>
                <div class="card-body">
                    <p>Don't have an account? Create one today!</p>
                    <a href="../forms/new_account.php" class="btn btn-primary">Create Account</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("include/_footer.php") ?> 
