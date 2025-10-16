<?php
session_start();
require_once __DIR__ . '/data.php';

function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES); }

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$user = $_SESSION['user'];
$isAdmin = ($user['username'] === 'adminxxx');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
  <div class="cotton-card slide-active">
    <div class="left-side">
      <div class="welcome-user">
        <h1>Halo, <?= e($user['username']) ?>! 🌟</h1>
        <p>Senang melihatmu lagi. Lihat biodatamu di sisi kanan.</p>
      </div>
    </div>

    <div class="right-side">
      <div class="header">
        <h2>Biodata <?= $isAdmin ? 'Admin' : e($user['name']) ?></h2>
        <a href="logout.php" class="logout">Logout</a>
      </div>

      <div class="bio">
        <?php if ($isAdmin): ?>
          <p>Anda login sebagai <strong>Admin</strong>. Berikut daftar pengguna:</p>

          <div class="admin-slider" id="adminSlider">
            <?php foreach ($users as $u): ?>
              <div class="bio-card">
                <p><strong><?= e($u['name']) ?></strong><br>
                Username: <?= e($u['username']) ?><br>
                Fakultas: <?= e($u['faculty'] ?? '-') ?><br>
                Angkatan: <?= e($u['batch'] ?? '-') ?><br>
                Email: <?= e($u['email']) ?><br>
                Gender: <?= e($u['gender'] ?? '-') ?></p>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="scroll-nav">
            <button class="scroll-btn" onclick="scrollSlider(-1)">◀</button>
            <button class="scroll-btn" onclick="scrollSlider(1)">▶</button>
          </div>

        <?php else: ?>
          <table class="bio-table">
            <tr><th>Nama Lengkap</th><td><?= e($user['name']) ?></td></tr>
            <tr><th>Username</th><td><?= e($user['username']) ?></td></tr>
            <tr><th>Email</th><td><?= e($user['email']) ?></td></tr>
            <tr><th>Jenis Kelamin</th><td><?= e($user['gender']) ?></td></tr>
            <tr><th>Fakultas</th><td><?= e($user['faculty']) ?></td></tr>
            <tr><th>Angkatan</th><td><?= e($user['batch']) ?></td></tr>
          </table>
        <?php endif; ?>
      </div>
    </div>

    <div class="glass-cover slide">
      <div class="cover-inner">
        <h2>Halo, <?= e($user['username']) ?>! 🌸</h2>
        <p>Selamat datang kembali di halaman biodata Anda.</p>
      </div>
    </div>
  </div>
</div>

<script>
function scrollSlider(dir) {
  const slider = document.getElementById('adminSlider');
  if (slider) slider.scrollBy({ left: dir * slider.clientWidth, behavior: 'smooth' });
}
</script>

</body>
</html>
