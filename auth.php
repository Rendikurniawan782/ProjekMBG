<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function wajibLogin($role = null) {
    if (!isset($_SESSION['role'])) {
        header('Location: login.php');
        exit;
    }

    if ($role !== null && $_SESSION['role'] !== $role) {
        http_response_code(403);
        exit('Akses ditolak! Kamu tidak memiliki izin.');
    }
}