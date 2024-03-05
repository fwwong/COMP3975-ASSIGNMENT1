<?php
include("../../Bank.php");
$bank = new Bank('../../bank.sqlite');
session_start();

if (isset($_POST['updateBucket'])) {
    $BucketId = filter_input(INPUT_POST, 'BucketId', FILTER_SANITIZE_NUMBER_INT);
    $Category = filter_input(INPUT_POST, 'Category', FILTER_SANITIZE_STRING);
    $Vender = filter_input(INPUT_POST, 'Vender', FILTER_SANITIZE_STRING);

    if (!$BucketId) {
        $_SESSION['errors'] = ['Invalid bucket ID.'];
        header("Location: /CRUD/update/updateBucket.php?id=$BucketId");
        exit;
    }

    $updateResult = $bank->updateBucket($BucketId, $Category, $Vender);

    if ($updateResult === true) {
        header('Location: ../../index.php'); // Adjust the redirect location as needed
        exit;
    } else {
        $_SESSION['errors'] = ['Update failed: ' . $updateResult];
        header("Location: /CRUD/update/updateBucket.php?id=$BucketId");
        exit;
    }
}
?>
