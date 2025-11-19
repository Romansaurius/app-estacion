<?php
session_start();

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
    include_once 'credenciales.php';
    include_once 'Mailer/src/PHPMailer.php';
    include_once 'Mailer/src/SMTP.php';
    include_once 'Mailer/src/Exception.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = 0; // Sin debug
        $mail->Host = HOST;
        $mail->Port = PORT;
        $mail->SMTPAuth = SMTP_AUTH;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Username = REMITENTE;
        $mail->Password = PASSWORD;
        
        error_log("Configuración SMTP: Host=" . HOST . ", Port=" . PORT . ", User=" . REMITENTE);
        
        $mail->setFrom(REMITENTE, NOMBRE);
        $mail->addAddress($to);
        
        $mail->isHTML(true);
        $mail->Subject = utf8_decode($subject);
        $mail->Body = $body;
        
        if ($mail->send()) {
            error_log("Email enviado exitosamente a: $to");
            return true;
        } else {
            error_log("Error PHPMailer: " . $mail->ErrorInfo);
            return false;
        }
    } catch (Exception $e) {
        error_log("Error enviando email: " . $e->getMessage());
        return false;
    }
}
?>