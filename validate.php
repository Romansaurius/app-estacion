<?php
require_once 'config.php';

if (isLoggedIn()) {
    redirectTo('index.php');
}

$message = '';
$token_action = $_GET['token_action'] ?? '';

if ($token_action) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios_estacion WHERE token_action = ? AND activo = 0");
    $stmt->execute([$token_action]);
    $user = $stmt->fetch();
    
    if ($user) {
        $stmt = $pdo->prepare("UPDATE usuarios_estacion SET activo = 1, token_action = NULL, active_date = NOW() WHERE id = ?");
        $stmt->execute([$user['id']]);
        
        // Enviar email de confirmación
        $emailBody = "
            <h3>Cuenta activada</h3>
            <p>Tu cuenta ha sido activada exitosamente. Ya puedes iniciar sesión en App Estación.</p>
        ";
        sendEmail($user['email'], 'Cuenta activada - App Estación', $emailBody);
        
        redirectTo('login.php');
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
    <title>Validar cuenta - App Estación</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Validar cuenta</h1>
        <div class="error"><?= $message ?></div>
        <p><a href="login.php">Volver al login</a></p>
    </div>
</body>
</html>