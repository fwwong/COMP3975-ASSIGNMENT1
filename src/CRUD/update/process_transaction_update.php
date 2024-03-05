<?php
include("../../Bank.php");
$bank = new Bank('../../members/user_screen.php');
session_start();

if (isset($_POST['update'])) {
    $TransactionId = filter_input(INPUT_POST, 'TransactionId', FILTER_SANITIZE_NUMBER_INT);
    $Date = filter_input(INPUT_POST, 'Date');
    $Vender = filter_input(INPUT_POST, 'Vender');
    $Spending = filter_input(INPUT_POST, 'Spending', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $Deposit = filter_input(INPUT_POST, 'Deposit', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if (!$TransactionId) {
        $_SESSION['errors'] = ['Invalid transaction ID.'];
        header("Location: /CRUD/update/update.php?id=$TransactionId");
        exit;
    }

    $updateResult = $bank->updateTransaction($TransactionId, $Date, $Vender, $Spending, $Deposit);

    if ($updateResult === true) {
        header('Location: ../../members/user_screen.php');
        exit;
    } else {
        $_SESSION['errors'] = ['Update failed: ' . $updateResult];
        header("Location: /CRUD/update/update.php?id=$TransactionId");
        exit;
    }
}
?>
