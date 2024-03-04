<?php
$db_path = __DIR__ . '/database/database.sqlite';
$db = new SQLite3(__DIR__ . '/bank.sqlite');
if (!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
    }
?>
