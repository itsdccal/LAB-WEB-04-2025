<?php
session_start();
require_once 'data.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userFound = null;

    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $userFound = $user;
            break;
        }
    }

    if ($userFound && password_verify($password, $userFound['password'])) {
        $_SESSION['user'] = $userFound;
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Username atau password salah!";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>