<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once 'data.php'; // Menyertakan data.php agar bisa mengakses array $users
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* General Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    color: #333;
    line-height: 1.6;
}

.dashboard-container {
    width: 80%;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h3 {
    color: #333;
    font-size: 1.25rem;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f4f7fc;
    color: #333;
}

td {
    background-color: #fff;
}

.logout-button:hover {
    background-color: #c0392b;
}

    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Selamat Datang, <?php echo $user['name']; ?>!</h2>
        <a href="logout.php" class="logout-button">Logout</a>
        <hr>
        <?php if ($user['username'] == 'adminxxx'): ?>
            <h3>Data Pengguna</h3>
            <table>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <h3>Data Anda:</h3>
<table>
    <tr>
        <th>Nama</th>
        <td><?php echo $user['name']; ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $user['email']; ?></td>
    </tr>
    <tr>
        <th>Username</th>
        <td><?php echo $user['username']; ?></td>
    </tr>
    <tr>
        <th>Gender</th>
        <td><?php echo $user['gender'] ?? '-'; ?></td>
    </tr>
    <tr>
        <th>Fakultas</th>
        <td><?php echo $user['fakultas'] ?? '-'; ?></td>
    </tr>
    <tr>
        <th>Angkatan</th>
        <td><?php echo $user['angkatan'] ?? '-'; ?></td>
    </tr>
</table>
        <?php endif; ?>
    </div>
</body>
</html>
