<?php
session_start();

// Configuración de base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'app_estacion');
define('DB_USER', 'root');
define('DB_PASS', '');

// Conexión PDO
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Funciones auxiliares
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirectTo($page) {
    header("Location: $page");
    exit;
}

function generateToken() {
    return bin2hex(random_bytes(32));
}

function getUserAgent() {
    return $_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido';
}

function getClientIP() {
    return $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';
}

function sendEmail($to, $subject, $body) {
    // Simulación de envío de email
    error_log("EMAIL TO: $to\nSUBJECT: $subject\nBODY: $body");
    return true;
}
?>