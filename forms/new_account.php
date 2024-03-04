<!-- REGISTER NEW ACCOUNT  -->
<?php include("../include/_header.php") ?>

<div class="card p-5">
<form>
 <h1>CREATE A NEW ACCOUNT</h1>
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email">
  </div>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username">
        <div>Username must be at least 3 characters long.</div>
    </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-danger center">Submit</button>
</form>
</div>
<?php include("../include/_footer.php") ?>
