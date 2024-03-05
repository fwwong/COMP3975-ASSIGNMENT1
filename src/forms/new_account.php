<!-- REGISTER NEW ACCOUNT  -->
<?php include("../include/_header.php") ?>
<?php include("../forms/process_new_account.php") ?>

<div class="card p-5">
<h1>CREATE A NEW ACCOUNT</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
  <div class="mb-3 row">
    <div class="col">
      <label for="first_name">First Name</label>
      <input type="text" name="first_name" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
      <span class="invalid-feedback"><?php echo $first_name_err; ?></span>
    </div>
    <div class="col">
      <label for="last_Name">Last Name</label>
      <input type="text" name="last_name" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
      <span class="invalid-feedback"><?php echo $last_name_err; ?></span>
    </div>
  </div>
    <div class="mb-3">
        <label for="username">Email Address</label>
        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
        <span class="invalid-feedback"><?php echo $username_err; ?></span>
    </div>
  <div class="mb-3">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
    <span class="invalid-feedback"><?php echo $password_err; ?></span>       
  </div>
  <div class="form-group">
    <label>Confirm Password</label>
    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>  
  </div>

  <input type="submit" class="btn btn-primary" value="Submit">
  <input type="reset" class="btn btn-secondary ml-2" value="Reset">
</form>
</div>
<?php include("../include/_footer.php") ?>
