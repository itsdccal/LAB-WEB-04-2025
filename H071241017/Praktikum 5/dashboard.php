<?php
session_start();
require 'data.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial; background: #eef2f3; }
        .container { width: 80%; margin: 50px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 5px #ccc; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000000ff; padding: 8px; text-align: left; text-color: #000000ff }
        th { background: #7b7f83ff; color: white; }
        .logout { float: right; background: #dc3545; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; }
        .anu{
            background-color: #c5c7c9ff;
            border: 1px solid #000000ff;
        }
    </style>
</head>
<body>
<div class="container">
    <a class="logout" href="logout.php">Logout</a>
    <?php 
    if ($user['username'] === 'adminxxx'): 
    ?>
        <h2>Selamat Datang, Admin!</h2>
        <table>
            <tr>
                <th>Email</th>
                <th>Username</th>
                <th>Nama</th>
            </tr>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['email'] ?></td>
                <td><?= $u['username'] ?></td>
                <td><?= $u['name'] ?></td>

            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <h1>Selamat Datang, <?= htmlspecialchars($user['name']) ?>!</h1>
       <hr>
        <h2>Data Anda</h2>
        <table border="1">
            <td class="anu"><b>Nama</b></td>
            <td><?= $user['name']?></td>
            <tr></tr>
            <td class="anu"><b>Username</b></td>
            <td><?= $user['username']?></td>
            <tr></tr>
            <td class="anu"><b>Email</td>
            <td><?= $user['email']?></td>
            <tr></tr>
            <td class="anu"><b>Gender</td>
            <td><?= $user['gender'] ?></td>
            <tr></tr>
            <td class="anu"><b>Fakultas</td>
            <td><?= $user['faculty'] ?></td>
            <tr></tr>
            <td class="anu"><b>Angkatan</td>
            <td><?= $user['batch'] ?></td>

        </table>

    <?php endif; ?>
</div>
</body>
</html>
