<?php
class Bank{
    private $dbPath;
    
    public function __construct($dbPath) {
        $this->dbPath = $dbPath;
    }
    
    // Add a user to the database
    public function addUser($username, $password, $first_name, $last_name) {
        $conn = new SQLite3($this->dbPath);
        
        $sql = "INSERT INTO users (username, password, first_name, last_name, account_type) VALUES (?, ?, ?, ?, 'user', 0, CURRENT_TIMESTAMP)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindValue(1, $username, SQLITE3_TEXT);
        $stmt->bindValue(2, $password, SQLITE3_TEXT);
        $stmt->bindValue(3, $first_name, SQLITE3_TEXT);
        $stmt->bindValue(4, $last_name, SQLITE3_TEXT);

        if ($username == "" || $password == "" || $first_name == "" || $last_name == "") {
            return false;
        }
        
        if (!$stmt->execute()) {
            error_log('SQLite execute() failed: ' . $conn->lastErrorMsg());
            return false;
        }
        
        $conn->close();
        return true;
    }

    // Add a transaction
    public function addTransaction($date, $vender, $spending, $deposit, $budget, $category) {
        $conn = new SQLite3($this->dbPath);
        
        $sql = "INSERT INTO transactions (date, vender, spending, deposit, budget, category) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindValue(1, $date, SQLITE3_TEXT);
        $stmt->bindValue(2, $vender, SQLITE3_TEXT);
        $stmt->bindValue(3, $spending, SQLITE3_TEXT); // Consider using SQLITE3_FLOAT for numerical values
        $stmt->bindValue(4, $deposit, SQLITE3_TEXT); // Consider using SQLITE3_FLOAT for numerical values
        $stmt->bindValue(5, $budget, SQLITE3_TEXT); // Consider using SQLITE3_FLOAT for numerical values
        $stmt->bindValue(6, $category, SQLITE3_TEXT);
        
        if (!$stmt->execute()) {
            error_log('SQLite execute() failed: ' . $conn->lastErrorMsg());
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
}
?>
