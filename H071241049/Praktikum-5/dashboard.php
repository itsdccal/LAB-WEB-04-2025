<?php
session_start();
require_once 'data.php'; 
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$loggedInUser = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container dashboard-container">
        
        <?php if ($loggedInUser['username'] === 'adminxxx') : ?>
            <h1>Selamat Datang, Admin!</h1>
            <a href="logout.php" class="logout-link">Logout</a>
            
            <h2>Data Semua Pengguna</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else : ?>
            <h1>Selamat Datang, <?php echo htmlspecialchars($loggedInUser['name']); ?>!</h1>
            <a href="logout.php" class="logout-link">Logout</a>

            <h2>Data Anda</h2>
            <table class="user-data-table">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td><?php echo htmlspecialchars($loggedInUser['name']); ?></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><?php echo htmlspecialchars($loggedInUser['username']); ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?php echo htmlspecialchars($loggedInUser['email']); ?></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><?php echo htmlspecialchars($loggedInUser['gender']); ?></td>
                    </tr>
                    <tr>
                        <td>Fakultas</td>
                        <td><?php echo htmlspecialchars($loggedInUser['faculty']); ?></td>
                    </tr>
                    <tr>
                        <td>Angkatan</td>
                        <td><?php echo htmlspecialchars($loggedInUser['batch']); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
</body>
</html>