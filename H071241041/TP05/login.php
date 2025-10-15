<?php
session_start();
require_once __DIR__ . '/data.php';

function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES); }

$isLogged = isset($_SESSION['user']);
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

if ($isLogged) {
  header('Location: dashboard.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
  <div class="cotton-card">
    <div class="left-side">
      <h1>Selamat Datang</h1>
      <p>Masuk untuk melihat biodata personalmu</p>

      <?php if ($error): ?>
        <div class="alert"><?= e($error) ?></div>
      <?php endif; ?>

      <form method="post" action="proses_login.php" class="login-form">
        <label>Username</label>
        <input type="text" name="username" required placeholder="Masukkan username">

        <label>Password</label>
        <div class="pw-box">
          <div>

            <input type="password" name="password" id="passwordField" required placeholder="Masukkan password">
          </div>
          <div class="pw-box-right">

            <button type="button" id="togglePw" class="togglePw">👁️</button>
          </div>
        </div>

        <button type="submit" class="btn">Login</button>
      </form>
    </div>

    <div class="right-side">
      <div class="locked">
        <h2>🔒 Biodata Terkunci</h2>
        <p>Silakan login untuk membuka biodata Anda.</p>
      </div>
    </div>

    <div class="glass-cover">
      <div class="cover-inner">
        <h2>Hello, Friend!</h2>
        <p>Masuk dan lihat biodata indahmu 🌸</p>
      </div>
    </div>
  </div>
</div>

<script>
const togglePw = document.getElementById('togglePw');
const pw = document.getElementById('passwordField');
togglePw?.addEventListener('click', () => {
  const type = pw.type === 'password' ? 'text' : 'password';
  pw.type = type;
  togglePw.textContent = type === 'text' ? '🙈' : '👁️';
});
</script>

</body>
</html>
