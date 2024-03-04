<!-- Main page to direct user to create a new account or login into an existing account -->
<?php include("include/_database.php") ?> 
<?php include("include/_header.php") ?>


<div class="container row">
    <div class="card col-8 p-5">
    <?php include("forms/login_form.php") ?>
    </div>
    <div class="card col-4 p-5">
        <div class="card-title"><h1>SIGN UP</h1></div>
        <div class="card-body">
            <p>Don't have an account? Create one today!</p>
            <a href="../forms/new_account.php" class="btn btn-primary">Create Account</a>
    </div>
</div>
<?php include("include/_footer.php") ?> 
