<?php
session_start(); // Start the session at the beginning

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Operations</title>
    <!-- Add any necessary CSS links here -->
</head>
<body>

<h1>Bank Operations</h1>

<div class="container">
    <div class="row">
        <!-- Create New Transaction Form -->
        <div class="col-md-6">
            <h2>Create New Transaction</h2>
            <form action="process_forms.php" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <form action="process_transaction_create.php" method="post"> <!-- Specify the PHP file that will handle transaction creation -->
                            <div class="form-group">
                                <label for="Date">Date</label>
                                <input type="date" name="Date" id="Date" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label for="Vender">Vender</label>
                                <input type="text" name="Vender" id="Vender" class="form-control" maxlength="100" required />
                            </div>
                            <div class="form-group">
                                <label for="Spending">Spending</label>
                                <input type="number" step="0.01" name="Spending" id="Spending" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="Deposit">Deposit</label>
                                <input type="number" step="0.01" name="Deposit" id="Deposit" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="Budget">Budget</label>
                                <input type="number" step="0.01" name="Budget" id="Budget" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="Category">Category</label>
                                <input type="text" name="Category" id="Category" class="form-control" maxlength="100" />
                            </div>
                            <div class="form-group">
                                <a href="../../index.php" class="btn btn-primary">&lt;&lt; Back</a>
                                &nbsp;&nbsp;&nbsp;
                                <input type="submit" value="Create Transaction" name="createTransaction" class="btn btn-success" />
                            </div>
                        </form>
                    </div>
                </div>
                <br />
            </form>
        </div>

        <!-- Manage Bucket Form -->
        <div class="col-md-6">
            <h2>Manage Bucket</h2>
            <form action="process_forms.php" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <form action="process_bucket_create_update.php" method="post"> <!-- Specify the PHP file that will handle bucket creation or update -->
                            <div class="form-group">
                                <label for="Category">Category</label>
                                <input type="text" name="Category" id="Category" class="form-control" maxlength="100" required />
                            </div>
                            <div class="form-group">
                                <label for="Vender">Vender</label>
                                <input type="text" name="Vender" id="Vender" class="form-control" maxlength="100" required />
                            </div>
                            <div class="form-group">
                                <a href="../../index.php" class="btn btn-primary">&lt;&lt; Back</a>
                                &nbsp;&nbsp;&nbsp;
                                <input type="submit" value="Save Bucket" name="saveBucket" class="btn btn-success" />
                            </div>
                        </form>
                    </div>
                </div>
                <br />
            </form>
        </div>
    </div>
</div>

<!-- Include any necessary JavaScript files here -->

</body>
</html>
