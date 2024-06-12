<?php
session_start();
require_once 'includes/config.php';

$_SESSION['token'] = '';

$sql = "UPDATE users SET token=:token WHERE user_id=:id";

$conn = getDbConnection();
$query = $conn->prepare($sql);
$query->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
$query->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
$query->execute();
if ($query->rowCount() > 0) {
    $result_msg = 'Token expired successfully.';
} else {
    $result_msg = 'An error has occurred. The token could not expire.';
}

echo "<script>console.log('Updation: " . $result_msg . "' );</script>";

session_unset();
session_destroy();
header("Location: index.php");
exit;