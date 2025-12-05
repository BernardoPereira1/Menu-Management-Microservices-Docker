<?php
session_start();
include('database/ementas_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (authenticateUser($conn, $username, $password)) {
        $_SESSION['user'] = ['username' => $username];
        header('Location: /admin.php');
        exit;
    } else {
        header('Location: /login.php?error=1');
        exit;
    }
}
?>