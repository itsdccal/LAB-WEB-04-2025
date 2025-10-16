<?php
session_start();
require_once 'data.php'; //user array

$username = $_POST['username'];
$password = $_POST['password'];

$userFound = false;

foreach ($users as $user) {
    if ($user['username'] === $username) {
        $userFound = true;
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit;
        }
    }
}

if (!$userFound) {
    $_SESSION['error'] = true;
    header("Location: login.php");
    exit;
}
?>
