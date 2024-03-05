<?php include("process_login.php") ?>

<!-- LOGIN FORM -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
 <h1>Login</h1>
 <p>Please fill in your credentials to login.</p>

 <?php 
  if(!empty($login_err)){
      echo '<div class="alert alert-danger">' . $login_err . '</div>';
  }        
  ?>

  <div class="mb-3">
    <label for="username" class="form-label">Email Address</label>
    <input type="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" name="username">
    <span class="invalid-feedback"><?php echo $username_err; ?></span>
    <div class="form-text"><a href="../forms/new_account.php">No account? Create one today!</a></div>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control  <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"  name="password">
    <span class="invalid-feedback"><?php echo $password_err; ?></span>
  </div>
  <button type="submit" class="btn btn-danger center" value="Login">Submit</button>
</form>



