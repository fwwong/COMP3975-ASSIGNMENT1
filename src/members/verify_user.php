<?php
if(isset($_GET['id'])) {
    $userId = $_GET['id'];
    require_once "../bank.php";

    $dbPath = '../bank.sqlite';
    $bank = new Bank($dbPath);

    if ($bank->verifyUser($userId)) {
        header("Location: admin.php");
        exit();
    } else {
        header("Location: error.php");
        exit();
    }
} else {
    header("Location: error.php");
    exit();
}
?>
