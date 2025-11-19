<?php
require_once 'config.php';

// Obtener emails simulados
try {
    $stmt = $pdo->query("SELECT * FROM emails_simulados ORDER BY fecha_envio DESC");
    $emails = $stmt->fetchAll();
} catch (Exception $e) {
    $emails = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Emails Simulados - App Estación</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Emails Simulados</h1>
        <p><a href="index.php">← Volver al inicio</a></p>
        
        <?php if (empty($emails)): ?>
            <p>No hay emails simulados.</p>
        <?php else: ?>
            <?php foreach ($emails as $email): ?>
                <div style="border: 1px solid #ccc; margin: 10px 0; padding: 15px; border-radius: 5px; background: rgba(255,255,255,0.1);">
                    <h3>Para: <?= htmlspecialchars($email['destinatario']) ?></h3>
                    <p><strong>Asunto:</strong> <?= htmlspecialchars($email['asunto']) ?></p>
                    <p><strong>Fecha:</strong> <?= $email['fecha_envio'] ?></p>
                    <div style="background: rgba(255,255,255,0.9); color: black; padding: 10px; border-radius: 3px;">
                        <?= $email['cuerpo'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>