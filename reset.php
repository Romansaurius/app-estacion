<?php
require_once 'config.php';

if (isLoggedIn()) {
    redirectTo('index.php');
}

$error = '';
$success = '';
$token_action = $_GET['token_action'] ?? '';
$validToken = false;

if ($token_action) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios_estacion WHERE token_action = ? AND (bloqueado = 1 OR recupero = 1)");
    $stmt->execute([$token_action]);
    $user = $stmt->fetch();
    
    if ($user) {
        $validToken = true;
        
        if ($_POST) {
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if ($password && $confirm_password) {
                if ($password === $confirm_password) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    
                    $stmt = $pdo->prepare("UPDATE usuarios_estacion SET contraseña = ?, token_action = NULL, bloqueado = 0, recupero = 0 WHERE id = ?");
                    $stmt->execute([$hashedPassword, $user['id']]);
                    
                    // Enviar email de confirmación
                    $ip = getClientIP();
                    $userAgent = getUserAgent();
                    $emailBody = "
                        <h3>Contraseña restablecida</h3>
                        <p>Tu contraseña ha sido restablecida exitosamente.</p>
                        <p>IP: $ip</p>
                        <p>Navegador: $userAgent</p>
                        <a href='http://mattprofe.com.ar/alumno/9909/app-estacion/blocked.php?token={$user['token']}' style='background:#ff4444;color:white;padding:10px;text-decoration:none;'>No fui yo, bloquear cuenta</a>
                    ";
                    sendEmail($user['email'], 'Contraseña restablecida - App Estación', $emailBody);
                    
                    redirectTo('login.php');
                } else {
                    $error = 'Las contraseñas no coinciden';
                }
            }
        }
    } else {
        $error = 'Token no válido';
    }
} else {
    $error = 'Token no proporcionado';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - App Estación</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Restablecer contraseña</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($validToken && !$success): ?>
            <form method="POST">
                <input type="password" name="password" placeholder="Nueva contraseña" required>
                <input type="password" name="confirm_password" placeholder="Repetir contraseña" required>
                <button type="submit">Restablecer</button>
            </form>
        <?php endif; ?>
        
        <p><a href="login.php">Volver al login</a></p>
    </div>
</body>
</html>