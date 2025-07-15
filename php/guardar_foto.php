<?php
header('Content-Type: application/json');

try {
    // Verificar si se recibió la foto
    if (!isset($_POST['photo'])) {
        throw new Exception('No se recibió ninguna foto');
    }
    
    // Obtener los datos de la imagen
    $photoData = $_POST['photo'];
    
    // Verificar que es una imagen en base64
    if (strpos($photoData, 'data:image/jpeg;base64,') !== 0) {
        throw new Exception('Formato de imagen no válido');
    }
    
    // Eliminar el prefijo de la cadena base64
    $photoData = str_replace('data:image/jpeg;base64,', '', $photoData);
    
    // Decodificar los datos base64
    $photoDecoded = base64_decode($photoData);
    
    if ($photoDecoded === false) {
        throw new Exception('Error al decodificar la imagen');
    }
    
    // Generar un nombre único para la imagen
    $filename = 'uploads/foto_' . date('Ymd_His') . '_' . uniqid() . '.jpg';
    
    // Asegurarse de que el directorio existe
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }
    
    // Guardar la imagen en el servidor
    if (file_put_contents($filename, $photoDecoded) === false) {
        throw new Exception('Error al guardar la imagen en el servidor');
    }
    
    // Devolver éxito
    echo json_encode([
        'success' => true,
        'filename' => $filename
    ]);
    
} catch (Exception $e) {
    // Devolver error
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>