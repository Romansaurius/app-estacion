<?php
require_once 'config.php';

if (isLoggedIn()) {
    redirectTo('index.php');
}

$error = '';
$success = '';

if ($_POST) {
    $email = $_POST['email'] ?? '';
    
    if ($email) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios_estacion WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            $token_action = generateToken();
            
            $stmt = $pdo->prepare("UPDATE usuarios_estacion SET recupero = 1, token_action = ?, recover_date = NOW() WHERE id = ?");
            $stmt->execute([$token_action, $user['id']]);
            
            // Enviar email de recuperación
            $emailBody = "
                <h3>Restablecimiento de contraseña</h3>
                <p>Se ha iniciado el proceso de restablecimiento de contraseña. Para continuar haz clic en el siguiente botón:</p>
                <a href='http://mattprofe.com.ar/alumno/9909/app-estacion/reset.php?token_action=$token_action' style='background:#00bfff;color:white;padding:10px;text-decoration:none;'>Click aquí para restablecer contraseña</a>
            ";
            sendEmail($user['email'], 'Restablecer contraseña - App Estación', $emailBody);
            
            $success = 'Se ha enviado un email con las instrucciones para restablecer tu contraseña';
        } else {
            $error = 'El email no se encuentra registrado. <a href="register.php">Registrarse</a>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña - App Estación</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Recuperar contraseña</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php else: ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">Enviar</button>
            </form>
        <?php endif; ?>
        
        <p><a href="login.php">Volver al login</a></p>
    </div>
</body>
</html>