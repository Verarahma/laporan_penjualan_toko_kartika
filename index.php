<?php
session_start();
include 'config/koneksi.php';

  if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $q = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
  if (mysqli_num_rows($q) > 0) {
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Username atau password salah';
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login - Toko Kartika</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      margin: 0;
      background: linear-gradient(135deg, #0B2B26, #00c6ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background: #fff;
      width: 380px;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      text-align: center;
      animation: fadeIn 0.8s ease-in-out;
    }

    .login-header {
      margin-bottom: 25px;
    }

    .login-header h2 {
      margin: 0;
      color: #000000ff;
      font-weight: 600;
      letter-spacing: 1px;
    }

    .login-header small {
      color: #666;
    }

    form {
      margin-top: 20px;
    }

    .input {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 15px;
      transition: 0.3s;
    }

    .input:focus {
      border-color: #007bff;
      outline: none;
      box-shadow: 0 0 4px rgba(0,123,255,0.4);
    }

    .btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      background: linear-gradient(135deg, #0B2B26, #2ecc71);
      color: white;
      font-weight: bold;
      transition: transform 0.2s, box-shadow 0.3s;
      margin-top: 10px;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(0,0,0,0.15);
    }

    .error {
      color: #e74c3c;
      background: #fdecea;
      border-radius: 8px;
      padding: 8px;
      margin-bottom: 15px;
      font-size: 14px;
    }

    .footer {
      margin-top: 20px;
      font-size: 13px;
      color: #777;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media(max-width: 420px) {
      .login-container {
        width: 90%;
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-header">
      <h2>Toko Kartika</h2>
      <small>Laporan Penjualan</small>
    </div>
    <h3>Login Admin / Kasir</h3>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
      <input class="input" type="text" name="username" placeholder="Username" required>
      <input class="input" type="password" name="password" placeholder="Password" required>
      <button class="btn" name="login">Login</button>
    </form>
    <div class="footer">© <?= date('Y') ?> Toko Kartika</div>
  </div>
</body>
</html>
