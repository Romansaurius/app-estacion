<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirectTo('login.php');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTACIONES</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">ESTACIONES</h1>
            <a href="logout.php" class="logout-btn">Salir</a>
        </div>
        <div id="estaciones-list" class="estaciones-list">
            <!-- Las estaciones se cargarán aquí dinámicamente -->
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>