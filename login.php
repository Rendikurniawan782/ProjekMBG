<?php
session_start();
include 'koneksi.php';

$error = '';

if (isset($_SESSION['role'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $akun = [
        'admin' => [
            'password' => 'Admin123!',
            'role' => 'admin'
        ],
        'siswa' => [
            'password' => 'Siswa123!',
            'role' => 'siswa'
        ]
    ];

        if (isset($akun[$username]) &&
        hash_equals($akun[$username]['password'], $password)) {

        session_regenerate_id(true);
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $akun[$username]['role'];

        // CEK ROLE - INI YANG DI GANTI
        if ($akun[$username]['role'] === 'siswa') {
            header('Location: tampilSiswa.php');
        } else {
            header('Location: index.php');
        }
        exit;
        
    } else {
        $error = 'Username atau password salah!';
        }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login MBG</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 320px;
            box-shadow: 0 4px 15px #0002;
        }
        h2 { text-align: center; color: #2c3e50; }
        input, button {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            box-sizing: border-box;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: #2980b9;
            color: white;
            border: 0;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover{background:#2471a3}
        .error { color: red; text-align: center; font-size:14px; }
        .akun { font-size: 13px; color: #555; margin-top: 20px; background:#f8f9fa; padding:10px; border-radius:6px}
        
        /* untuk lihat password */
        .password-wrapper{
            position: relative;
            margin-top: 12px;
        }
        .password-wrapper input{
            margin-top: 0;
            padding-right: 40px;
        }
        .toggle-password{
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="login">
        <h2>Login Aplikasi MBG</h2>

        <?php if ($error): ?>
            <p class="error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username"
                   placeholder="Username" required>
            
            <div class="password-wrapper">
                <input type="password" name="password" id="password"
                       placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>

            <button type="submit" name="login">Login</button>
        </form>

        <div class="akun">
            <p><b>Admin:</b> admin / Admin123!</p>
            <p><b>Siswa:</b> siswa / Siswa123!</p>
        </div>
    </div>

<script>
function togglePassword(){
    const input = document.getElementById('password');
    const icon = document.querySelector('.toggle-password');
    if(input.type === 'password'){
        input.type = 'text';
        icon.textContent = '👁️';
    } else {
        input.type = 'password';
        icon.textContent = '🙈';
    }
}
</script>
</body>
</html>