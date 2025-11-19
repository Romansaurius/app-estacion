<?php
require_once 'config.php';

if (isLoggedIn()) {
    redirectTo('index.php');
}

$error = '';
$success = '';

if ($_POST) {
    $email = $_POST['email'] ?? '';
    $nombres = $_POST['nombres'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if ($email && $nombres && $password && $confirm_password) {
        if ($password !== $confirm_password) {
            $error = 'Las contraseñas no coinciden';
        } else {
            // Verificar si el email ya existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios_estacion WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error = 'El email ya corresponde a un usuario. <a href="login.php">Iniciar sesión</a>';
            } else {
                $token = generateToken();
                $token_action = generateToken();
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $pdo->prepare("INSERT INTO usuarios_estacion (token, email, nombres, contraseña, token_action) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$token, $email, $nombres, $hashedPassword, $token_action]);
                
                // Enviar email de activación
                $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
                $baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
                $emailBody = "
                    <h3>Bienvenido a App Estación</h3>
                    <p>Gracias por registrarte. Para activar tu cuenta haz clic en el siguiente botón:</p>
                    <a href='$baseUrl/validate.php?token_action=$token_action' style='background:#44ff44;color:black;padding:10px;text-decoration:none;'>Click aquí para activar tu usuario</a>
                ";
                sendEmail($email, 'Activar cuenta - App Estación', $emailBody);
                
                $success = 'Usuario registrado. Revisa tu email para activar la cuenta.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - App Estación</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrarse</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php else: ?>
            <form method="POST">
                <input type="text" name="nombres" placeholder="Nombres" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="password" name="confirm_password" placeholder="Repetir contraseña" required>
                <button type="submit">Registrarse</button>
            </form>
        <?php endif; ?>
        
        <p><a href="login.php">¿Ya tienes cuenta? Iniciar sesión</a></p>
    </div>
</body>
</html>