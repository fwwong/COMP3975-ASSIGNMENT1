<!-- CREATE A DATABASE IF THERE IS NO DATABASE -->
<?php
    include("../include/_config.php");
    //$db = new SQLite3($db_path);
    $SQL_create_table = "CREATE TABLE IF NOT EXISTS Users (
        Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        FirstName VARCHAR(80),
        LastName VARCHAR(80),
        Email VARCHAR(80),
        Username VARCHAR(80),
        Password VARCHAR(80),
        BankAccountType VARCHAR(80),
        AccountType VARCHAR(80),
        Permission VARCHAR(80),
        CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";
    $db -> exec($SQL_create_table);

    // insert sample data
    $sampleData = [
        ["admin", "admin", "aa@aa.aa", "admin", "P@$$w0rd", "admin", "admin"],
        ["test", "dummy", "user@123.ca", "test", "Abc@abc0", "Saving Account", "user"]
    ];
?>