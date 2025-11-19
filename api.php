<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Obtener datos de la API real
try {
    $url = 'https://mattprofe.com.ar/proyectos/app-estacion/datos.php?mode=list-stations';
    
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'header' => 'Accept: application/json'
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data && is_array($data)) {
            echo json_encode($data);
            exit;
        }
    }
    
    throw new Exception('API no disponible');
    
} catch (Exception $e) {
    // Fallback con datos simulados solo si la API falla
    $estaciones = [
        [
            'chipid' => '713630',
            'apodo' => 'MattLab I',
            'ubicacion' => 'Buenos Aires, Tortuguitas',
            'visitas' => '3549',
            'dias_inactivo' => '0'
        ],
        [
            'chipid' => '3973796',
            'apodo' => 'MattLab II',
            'ubicacion' => 'Buenos Aires, Tortuguitas',
            'visitas' => '649',
            'dias_inactivo' => '0'
        ],
        [
            'chipid' => '11214452',
            'apodo' => 'AEROCLUB LA CUMBRE',
            'ubicacion' => 'Córdoba, Aeroclub La Cumbre',
            'visitas' => '8047',
            'dias_inactivo' => '0'
        ]
    ];
    
    echo json_encode($estaciones);
}
?>