<?php
require_once 'config.php';

if ($_POST) {
    $email = $_POST['email'] ?? '';
    if ($email) {
        $result = sendEmail($email, 'Test Email - App Estación', '<h3>Email de prueba</h3><p>Si recibes este email, la configuración funciona correctamente.</p>');
        
        if ($result) {
            echo "<div style='color: green;'>Email enviado exitosamente a: $email</div>";
        } else {
            echo "<div style='color: red;'>Error enviando email a: $email</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Email</title>
</head>
<body>
    <h2>Probar envío de email</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Tu email" required>
        <button type="submit">Enviar email de prueba</button>
    </form>
</body>
</html>