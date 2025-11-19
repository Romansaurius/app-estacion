<?php
require_once 'config.php';

$message = '';
$token = $_GET['token'] ?? '';

if ($token) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios_estacion WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        $token_action = generateToken();
        
        $stmt = $pdo->prepare("UPDATE usuarios_estacion SET bloqueado = 1, token_action = ?, blocked_date = NOW() WHERE id = ?");
        $stmt->execute([$token_action, $user['id']]);
        
        // Enviar email de bloqueo
        $emailBody = "
            <h3>Cuenta bloqueada</h3>
            <p>Tu cuenta ha sido bloqueada por seguridad. Para cambiar tu contraseña haz clic en el siguiente botón:</p>
            <a href='http://mattprofe.com.ar/alumno/9909/app-estacion/reset.php?token_action=$token_action' style='background:#ffa500;color:white;padding:10px;text-decoration:none;'>Click aquí para cambiar contraseña</a>
        ";
        sendEmail($user['email'], 'Cuenta bloqueada - App Estación', $emailBody);
        
        $message = 'Usuario bloqueado, revise su correo electrónico';
    } else {
        $message = 'El token no corresponde a un usuario';
    }
} else {
    $message = 'Token no válido';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta bloqueada - App Estación</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Cuenta bloqueada</h1>
        <div class="message"><?= $message ?></div>
        <p><a href="login.php">Volver al login</a></p>
    </div>
</body>
</html>