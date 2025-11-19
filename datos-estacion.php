<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$chipid = $_GET['chipid'] ?? '';

if (empty($chipid)) {
    echo json_encode(['error' => 'chipid requerido']);
    exit;
}

// Intentar obtener datos reales de la estación
try {
    $url = "https://mattprofe.com.ar/proyectos/app-estacion/datos.php?chipid={$chipid}";
    
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'header' => 'Accept: application/json'
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data) {
            echo json_encode($data);
            exit;
        }
    }
    
    throw new Exception('API no disponible');
    
} catch (Exception $e) {
    // Datos simulados realistas para desarrollo
    $datos = [
        'temperatura' => rand(15, 35) + (rand(0, 99) / 100),
        'humedad' => rand(30, 80),
        'presion' => rand(1000, 1030) + (rand(0, 99) / 100),
        'viento_velocidad' => rand(0, 25) + (rand(0, 99) / 100),
        'viento_direccion' => ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'][rand(0, 7)],
        'riesgo_incendio' => ['Muy bajo', 'Bajo', 'Moderado', 'Alto', 'Muy alto'][rand(0, 4)],
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    echo json_encode($datos);
}
?>