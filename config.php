<?php
session_start();

require_once '/home/9909/public_html/PHPMailer/src/Exception.php';
require_once '/home/9909/public_html/PHPMailer/src/PHPMailer.php';
require_once '/home/9909/public_html/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Configuración de base de datos
define('DB_HOST', 'mattprofe.com.ar');
define('DB_NAME', '9909');
define('DB_USER', '9909');
define('DB_PASS', 'buey.sauce.silla');

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
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host       = 'mattprofe.com.ar';
        $mail->SMTPAuth   = true;
        $mail->Username   = '9909@mattprofe.com.ar';
        $mail->Password   = 'buey.sauce.silla';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        $mail->setFrom('9909@mattprofe.com.ar', 'App Estación');
        $mail->addAddress($to);
        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error enviando email: {$mail->ErrorInfo}");
        return false;
    }
}
?>