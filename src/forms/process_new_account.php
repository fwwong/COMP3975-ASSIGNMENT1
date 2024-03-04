<?php

$dbPath = '../../bank.sqlite';

if (isset($_POST['create'])) {

    include "../../create_db.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . '../../bank.php';

    if (isset($_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];

        $bank = new Bank($dbPath);
        
        $bank->addUser($username, $password, $first_name, $last_name);
    } else {
        echo "All fields are required.";
    }
}
?>
