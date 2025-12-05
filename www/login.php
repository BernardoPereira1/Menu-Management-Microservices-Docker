<?php
session_start();
include('includes/database/ementas_db.php');

// Redirect to admin if already logged in
if (isset($_SESSION['user'])) {
    header('Location: admin.php');
    exit;
}

$error = isset($_GET['error']) ? 'Utilizador ou palavra-passe inválidos.' : '';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="card">
                <div class="card-header">
                    Login Admin
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form action="includes/authenticate.php" method="POST">
                        <div class="form-group">
                            <label for="username">Utilizador</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Digite o seu utilizador" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Palavra-passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Digite a sua palavra-passe" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>