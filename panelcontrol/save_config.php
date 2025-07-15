<?php
// save_config.php

// Recibir los datos enviados por AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Verificar que todos los campos necesarios están presentes
if (isset($data['dbname']) && isset($data['dbuser']) && isset($data['dbpass'])) {
    
    // Crear el contenido del archivo de configuración
    $config = [
        'dbname' => $data['dbname'],
        'dbuser' => $data['dbuser'],
        'dbpass' => $data['dbpass']
    ];
    
    // Guardar la configuración en un archivo
    $file = 'db_config.txt';
    
    // Cifrar mínimamente el contenido (opcional pero recomendado)
    $encrypted = base64_encode(serialize($config));
    
    // Guardar en el archivo
    if (file_put_contents($file, $encrypted)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se pudo escribir en el archivo']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Faltan datos requeridos']);
}
?>