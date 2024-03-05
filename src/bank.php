<?php
class Bank{
    private $dbPath;
    
    public function __construct($dbPath) {
        $this->dbPath = $dbPath;
    }
    // add user to the database
    public function addUser($username, $password, $first_name, $last_name) {
        $conn = new SQLite3($this->dbPath);
    
        $sql = "INSERT INTO users (username, password, first_name, last_name, account_type, verified, created_at) VALUES (?, ?, ?, ?, 'user', 0, CURRENT_TIMESTAMP)";
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            error_log('SQLite prepare() failed: ' . $conn->lastErrorMsg());
            return false;
        }
        
        // if username exist return false
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $checkStmt->bindValue(1, $username, SQLITE3_TEXT);
        $result = $checkStmt->execute();
        if ($result->fetchArray()) {
            return false;
        }
        else{
            $checkStmt->close();
        }
        $stmt->bindValue(1, $username, SQLITE3_TEXT);
        $stmt->bindValue(2, $password, SQLITE3_TEXT);
        $stmt->bindValue(3, $first_name, SQLITE3_TEXT);
        $stmt->bindValue(4, $last_name, SQLITE3_TEXT);
    
        // Execute the statement
        $result = $stmt->execute();
        if (!$result) {
            error_log('SQLite execute() failed: ' . $conn->lastErrorMsg());
            return false;
        }
        $conn->close();
        return true;
    }
    
    //authenticate user
    public function authenticateUser($username, $password) {
        $conn = new SQLite3($this->dbPath);
    
        $sql = "SELECT id, username, password, verified FROM users WHERE username = ? AND verified = '1'";
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            return "Oops! Failed to prepare SQL statement.";
        }
    
        $stmt->bindValue(1, $username, SQLITE3_TEXT);
        $result = $stmt->execute();
    
        if (!$result) {
            return "Oops! Failed to execute SQL statement.";
        }
    
        $row = $result->fetchArray(SQLITE3_ASSOC);
    
        if ($row) {
            // Verify hashed password
            if (password_verify($password, $row['password'])) {
                // Check if the 'verified' column exists in the result
                if (array_key_exists('verified', $row)) {
                    // Check if the user is verified
                    if ($row['verified'] == 1) {
                        return true;
                    } else {
                        return "Your account is not verified.";
                    }
                } else {
                    return "Verification status not available.";
                }
            } else {
                return "Invalid username or password.";
            }
        } else {
            return "Invalid username or password.";
        }
    
        $stmt->close();
        $conn->close();
    }
    

    // Add a transaction
    public function addTransaction($date, $vender, $spending, $deposit, $budget, $category) {
        $conn = new SQLite3($this->dbPath);
        $category = $this->getCategoryFromBuckets($vender);

        // Convert spending and deposit to float for arithmetic operations
        $spending = (empty($spending) || !is_numeric($spending)) ? NULL : floatval($spending);
        $deposit = (empty($deposit) || !is_numeric($deposit)) ? NULL : floatval($deposit);
        // Step 1: Retrieve the most recent budget value for the category
        $latestBudgetSql = "SELECT budget FROM transactions ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($latestBudgetSql);
        $result = $stmt->execute();
        $latestBudgetRow = $result->fetchArray(SQLITE3_ASSOC);
        $latestBudget = $latestBudgetRow ? floatval($latestBudgetRow['budget']) : 0; // Default to 0 if no transactions found

        // Step 2: Update the budget based on the current transaction
        $newBudget = $latestBudget + $deposit - $spending;

        // Step 3: Insert the new transaction with the updated budget
        $insertSql = "INSERT INTO transactions (date, vender, spending, deposit, budget, category) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bindValue(1, $date, SQLITE3_TEXT);
        $insertStmt->bindValue(2, $vender, SQLITE3_TEXT);
        $insertStmt->bindValue(3, $spending, SQLITE3_FLOAT);
        $insertStmt->bindValue(4, $deposit, SQLITE3_FLOAT);
        $insertStmt->bindValue(5, $newBudget, SQLITE3_FLOAT);
        $insertStmt->bindValue(6, $category, SQLITE3_TEXT);

        if (!$insertStmt->execute()) {
            error_log('SQLite execute() failed: ' . $conn->lastErrorMsg());
            $conn->close();
            return false;
        }

        $conn->close();
        return true;
    }
    
    
    // Delete a transaction
    public function deleteTransaction($transactionId) {
        $conn = new SQLite3($this->dbPath);
        
        $stmt = $conn->prepare("DELETE FROM transactions WHERE id = ?");
        $stmt->bindValue(1, $transactionId, SQLITE3_INTEGER);
        
        if (!$stmt->execute()) {
            error_log('SQLite execute() failed: ' . $conn->lastErrorMsg());
            return false;
        }
        
        $conn->close();
        return true;
    }

    public function updateTransaction($transactionId, $date, $vender, $spending, $deposit) {
        $conn = new SQLite3($this->dbPath);

        // First, retrieve the current details of the transaction to be updated
        $currentDetailsStmt = $conn->prepare("SELECT spending, deposit, budget FROM transactions WHERE id = ?");
        $currentDetailsStmt->bindValue(1, $transactionId, SQLITE3_INTEGER);
        $currentResult = $currentDetailsStmt->execute();
        $currentDetails = $currentResult->fetchArray(SQLITE3_ASSOC);

        if (!$currentDetails) {
            $conn->close();
            return false; // Transaction not found
        }

        // Calculate the difference in spending and deposit to adjust the budget
        $spendingDiff = $spending - $currentDetails['spending'];
        $depositDiff = $deposit - $currentDetails['deposit'];

        // Calculate the new budget
        $newBudget = $currentDetails['budget'] - $spendingDiff + $depositDiff;

        // Prepare the SQL statement to update a transaction with new budget
        $sql = "UPDATE transactions SET date = ?, vender = ?, spending = ?, deposit = ?, budget = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // Bind values to the prepared statement parameters
        $stmt->bindValue(1, $date, SQLITE3_TEXT);
        $stmt->bindValue(2, $vender, SQLITE3_TEXT);
        $stmt->bindValue(3, $spending, SQLITE3_FLOAT);
        $stmt->bindValue(4, $deposit, SQLITE3_FLOAT);
        $stmt->bindValue(5, $newBudget, SQLITE3_FLOAT); // Updated budget
        $stmt->bindValue(6, $transactionId, SQLITE3_INTEGER);

        // Execute the statement and check for errors
        if (!$stmt->execute()) {
            error_log('SQLite execute() failed: ' . $conn->lastErrorMsg());
            $conn->close();
            return false; // Return false if update operation failed
        }

        $conn->close();
        return true; // Return true if update operation was successful
    }
    public function getBucketDetails($bucketId) {
        $conn = new SQLite3($this->dbPath);
        $stmt = $conn->prepare("SELECT * FROM buckets WHERE id = :id");
        $stmt->bindValue(':id', $bucketId, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $bucketDetails = $result->fetchArray(SQLITE3_ASSOC);
        $conn->close();
        return $bucketDetails ? $bucketDetails : null;
    }

    // Add or update a bucket category
    public function upsertBucket($category, $vender) {
        $conn = new SQLite3($this->dbPath);
        
        // Check if the bucket already exists
        $checkStmt = $conn->prepare("SELECT id FROM buckets WHERE category = ? AND vender = ?");
        $checkStmt->bindValue(1, $category, SQLITE3_TEXT);
        $checkStmt->bindValue(2, $vender, SQLITE3_TEXT);
        $result = $checkStmt->execute();
        
        if ($result->fetchArray()) {
            // Update if exists
            $sql = "UPDATE buckets SET category = ?, vender = ? WHERE category = ? AND vender = ?";
        } else {
            // Insert if does not exist
            $sql = "INSERT INTO buckets (category, vender) VALUES (?, ?)";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $category, SQLITE3_TEXT);
        $stmt->bindValue(2, $vender, SQLITE3_TEXT);
        if (isset($sql) && strpos($sql, "UPDATE") !== false) {
            $stmt->bindValue(3, $category, SQLITE3_TEXT);
            $stmt->bindValue(4, $vender, SQLITE3_TEXT);
        }
        
        if (!$stmt->execute()) {
            error_log('SQLite execute() failed: ' . $conn->lastErrorMsg());
            return false;
        }
        
        $conn->close();
        return true;
    }

    // Delete a bucket
    public function deleteBuckets($bucketsId) {
        $conn = new SQLite3($this->dbPath);
        
        $stmt = $conn->prepare("DELETE FROM buckets WHERE id = ?");
        $stmt->bindValue(1, $bucketsId, SQLITE3_INTEGER);
        
        if (!$stmt->execute()) {
            error_log('SQLite execute() failed: ' . $conn->lastErrorMsg());
            return false;
        }
        
        $conn->close();
        return true;
    }

    public function getTransactionDetails($transactionId) {
        $conn = new SQLite3($this->dbPath);
        // Prepare a SQL statement to get the details of the transaction by its ID
        $stmt = $conn->prepare("SELECT * FROM transactions WHERE id = :id");
        // Bind the transaction ID to the prepared statement
        $stmt->bindValue(':id', $transactionId, SQLITE3_INTEGER);
        // Execute the query
        $result = $stmt->execute();
        // Fetch the transaction details
        $transactionDetails = $result->fetchArray(SQLITE3_ASSOC);
        $conn->close();
        // Return the transaction details, or null if not found
        return $transactionDetails ? $transactionDetails : null;
    }

    public function getCategoryFromBuckets($vender) {
        $conn = new SQLite3($this->dbPath);
        // Normalize vendor name for case-insensitive comparison
        $venderNormalized = strtolower(trim($vender));
        $stmt = $conn->prepare("SELECT category FROM buckets WHERE LOWER(vender) = :vender LIMIT 1");
        $stmt->bindValue(':vender', $venderNormalized, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $conn->close();
        return $row ? $row['category'] : "Other";
    }

    public function updateBucket($bucketId, $category, $vender) {
        $conn = new SQLite3($this->dbPath);
        $stmt = $conn->prepare("UPDATE buckets SET category = ?, vender = ? WHERE id = ?");
        $stmt->bindValue(1, $category, SQLITE3_TEXT);
        $stmt->bindValue(2, $vender, SQLITE3_TEXT);
        $stmt->bindValue(3, $bucketId, SQLITE3_INTEGER);
        
        if (!$stmt->execute()) {
            $conn->close();
            return "Error updating bucket: " . $conn->lastErrorMsg();
        }

        $conn->close();
        return true;
    }
}

?>
