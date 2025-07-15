
<?php
session_start();
// Verificar si se envió el formulario
if (isset($_POST['subirTicket'])) {
    // Verificar si hay un archivo
    if (!isset($_FILES['archivoTicket']) || $_FILES['archivoTicket']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['mensaje'] = 'Error al subir el archivo: ' . $_FILES['archivoTicket']['error'];
        $_SESSION['tipo_mensaje'] = 'error';
        exit();
    }
    
    // Obtener la información del archivo
    $archivo = $_FILES['archivoTicket'];
    $nombre_tmp = $archivo['tmp_name'];
    $nombre_original = $archivo['name'];
    
    // Obtener la extensión del archivo
    $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
    
    // Generar un nombre único para el archivo
    $nombre_unico = uniqid('ticket_') . '_' . time() . '.' . $extension;
    
    // Ruta de destino
    $ruta_destino = '/tickets/' . $nombre_unico;
    
    // Mover el archivo a la carpeta de destino
    if (move_uploaded_file($nombre_tmp, $ruta_destino)) {
        // Éxito
        $_SESSION['mensaje'] = 'Archivo subido correctamente.';
        $_SESSION['tipo_mensaje'] = 'exito';
        $_SESSION['nombre_archivo_ticket'] = $nombre_unico;
    } else {
        // Error
        $_SESSION['mensaje'] = 'Error al guardar el archivo en el servidor.';
        $_SESSION['tipo_mensaje'] = 'error';
    }
    
    // Redireccionar de vuelta al formulario
    exit;
} else {
    // Si alguien intenta acceder directamente a este script
    $_SESSION['mensaje'] = 'Acceso no permitido.';
    $_SESSION['tipo_mensaje'] = 'error';
    exit;
}
?>