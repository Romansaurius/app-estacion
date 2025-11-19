<?php
require_once 'config.php';

if (isLoggedIn()) {
    redirectTo('index.php');
}

$error = '';

if ($_POST) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios_estacion WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            if (password_verify($password, $user['contraseña'])) {
                if ($user['activo'] == 0) {
                    $error = 'Su usuario aún no se ha validado, revise su casilla de correo';
                } elseif ($user['bloqueado'] == 1 || $user['recupero'] == 1) {
                    $error = 'Su usuario está bloqueado, revise su casilla de correo';
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_token'] = $user['token'];
                    
                    // Enviar email de notificación
                    $ip = getClientIP();
                    $userAgent = getUserAgent();
                    $emailBody = "
                        <h3>Inicio de sesión detectado</h3>
                        <p>IP: $ip</p>
                        <p>Navegador: $userAgent</p>
                        <a href='http://mattprofe.com.ar/alumno/9909/app-estacion/blocked.php?token={$user['token']}' style='background:#ff4444;color:white;padding:10px;text-decoration:none;'>No fui yo, bloquear cuenta</a>
                    ";
                    sendEmail($user['email'], 'Inicio de sesion - App Estacion', $emailBody);
                    
                    redirectTo('index.php');
                }
            } else {
                // Enviar email de intento inválido
                $ip = getClientIP();
                $userAgent = getUserAgent();
                $emailBody = "
                    <h3>Intento de acceso con contraseña inválida</h3>
                    <p>IP: $ip</p>
                    <p>Navegador: $userAgent</p>
                    <a href='http://mattprofe.com.ar/alumno/9909/app-estacion/blocked.php?token={$user['token']}' style='background:#ff4444;color:white;padding:10px;text-decoration:none;'>No fui yo, bloquear cuenta</a>
                ";
                sendEmail($user['email'], 'Intento de acceso invalido - App Estacion', $emailBody);
                $error = 'Credenciales no válidas';
            }
        } else {
            $error = 'Credenciales no válidas';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - App Estación</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Acceder</button>
        </form>
        
        <p><a href="recovery.php">¿Olvidaste tu contraseña?</a></p>
        <p><a href="register.php">¿No tienes una cuenta? Registrarse</a></p>
    </div>
</body>
</html>