<?php
session_start();
require_once __DIR__ . '/data.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['error'] = 'Username dan password wajib diisi.';
    header('Location: dashboard.php');
    exit;
}

$found = null;
foreach ($users as $u) {
    if ($u['username'] === $username) {
        $found = $u;
        break;
    }
}

if (!$found || !password_verify($password, $found['password'])) {
    $_SESSION['error'] = 'Username atau password salah!';
    header('Location: dashboard.php');
    exit;
}

unset($found['password']);
$_SESSION['user'] = $found;

header('Location: dashboard.php');
exit;
