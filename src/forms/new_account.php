<!-- REGISTER NEW ACCOUNT  -->
<?php include("../include/_header.php") ?>

<?php
$dbPath = '../../bank.sqlite';

// Establish SQLite database connection
$link = new SQLite3($dbPath);

$username = $password = $email = $firstName = $lastName = $bankAccountType = "";
$usernameErr = $passwordErr = $emailErr = $firstNameErr = $lastNameErr = $bankAccountTypeErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $usernameErr = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $usernameErr = "Username can only contain letters, numbers, and underscores.";
    } else {
        // Your username validation logic here
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $passwordErr = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $passwordErr = "Password must have at least 6 characters.";
    } else {
        // Your password validation logic here
    }

    // Check input errors before inserting in database
    if (empty($usernameErr) && empty($passwordErr)) {
        // Your insertion logic here
    }
}

// Close SQLite database connection
if (isset($link)) {
    $link->close();
}
?>


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
        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
        <span class="invalid-feedback"><?php echo $username_err; ?></span>
        <div>Username must be at least 3 characters long.</div>
    </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
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
