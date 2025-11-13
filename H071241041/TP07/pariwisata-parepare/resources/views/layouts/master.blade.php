<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eksplor Parepare</title>
  
  <style>
    body {
      margin: 0;
      font-family: "Orbitron", sans-serif;
      background: radial-gradient(circle at top, #1a001f, #000);
      color: #fff;
      overflow-x: hidden;
    }

    header {
      background: linear-gradient(90deg, #ff004c, #1a001f);
      padding: 15px 0;
      text-align: center;
      box-shadow: 0 3px 10px rgba(255,0,76,0.3);
    }

    header h1 {
      margin: 0;
      font-size: 28px;
      color: #fff;
      text-shadow: 0 0 10px #ff004c;
      letter-spacing: 2px;
    }

    nav {
      margin-top: 10px;
    }

    nav a {
      text-decoration: none;
      color: #ff99b9;
      margin: 0 20px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    nav a:hover {
      color: #fff;
      text-shadow: 0 0 8px #ff004c;
    }

    footer {
      text-align: center;
      background: linear-gradient(90deg, #1a001f, #ff004c);
      padding: 10px;
      color: #fff;
      font-size: 14px;
      text-shadow: 0 0 8px #ff004c;
    }

    .btn {
      background: none;
      color: #ff004c;
      border: 2px solid #ff004c;
      padding: 10px 22px;
      margin: 8px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 6px;
      transition: all 0.3s ease;
      text-transform: uppercase;
      box-shadow: 0 0 10px #ff004c inset;
    }

    .btn:hover {
      background: #ff004c;
      color: #000;
      box-shadow: 0 0 15px #ff004c, 0 0 30px #ff004c;
      transform: translateY(-3px);
    }

    h2 {
      text-align: center;
      text-shadow: 0 0 10px #ff004c;
    }

    .grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .card {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,0,76,0.4);
      border-radius: 12px;
      width: 300px;
      overflow: hidden;
      text-align: center;
      box-shadow: 0 0 15px rgba(255,0,76,0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0 25px rgba(255,0,76,0.4);
    }

    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .card-content {
      padding: 15px;
    }

    .card-content h3 {
      color: #ff004c;
      margin-bottom: 8px;
    }

    .card-content p {
      font-size: 14px;
      color: #ddd;
    }

    .nav-buttons {
      text-align: center;
      margin-top: 40px;
    }

  </style>
</head>
<body>
  <header>
    <h1>Eksplor Parepare</h1>
    <nav>
      <a href="/">Home</a>
      <a href="/kontak">Kontak</a>
    </nav>
  </header>

  <main style="padding: 30px;">
    @yield('content')
  </main>

  <footer>
    <p>&copy; 2025 Eksplor Parepare | ZSH</p>
  </footer>
</body>
</html>
