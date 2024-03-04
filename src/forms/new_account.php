<!-- REGISTER NEW ACCOUNT  -->
<?php include("../include/_header.php") ?>
<?php include("../forms/process_new_account.php") ?>

<div class="card p-5">
<h1>CREATE A NEW ACCOUNT</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
  <div class="mb-3 row">
    <div class="col">
      <label for="first_name" class="form-label">First Name</label>
      <input type="text" class="form-control">
    </div>
    <div class="col">
      <label for="last_Name" class="form-label">Last Name</label>
      <input type="text" class="form-control">
    </div>
  </div>
    <div class="mb-3">
        <label for="username" class="form-label">Email Address</label>
        <input type="text" name="username" class="form-control ">
    </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control ">
            
  </div>
  <div class="form-group">
    <label>Confirm Password</label>
    <input type="password" name="confirm_password" class="form-control">
    </div>

  <input type="submit" class="btn btn-primary" value="Submit">
  <input type="reset" class="btn btn-secondary ml-2" value="Reset">
</form>
</div>
<?php include("../include/_footer.php") ?>
