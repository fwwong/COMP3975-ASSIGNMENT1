<!-- Create a session -->
<?php 
session_start(); 
//if user already log in send them to the home page
if(isset($_SESSION['username'])){
    header("Location: ../member/welcome.php");
    exit;
}
require_once "include/_config.php";

?>  
<!-- LOGIN FORM -->
<form>
 <h1>Login</h1>
  <div class="mb-3">
    <label for="email" class="form-label">Email address / Username</label>
    <input type="login" class="form-control" id="login">
    <div id="newAccount" class="form-text"><a href="../forms/new_account.php">No account? Create one today!</a></div>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="saveUsername">
    <label class="form-check-label" for="saveUsername">Save username</label>
  </div>
  <button type="submit" class="btn btn-danger center">Submit</button>
  <div id="recover" class="form-text"><a href="#">Forgot Password/Username?</a></div>
</form>