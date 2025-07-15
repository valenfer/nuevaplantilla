<?php
session_start(); // Iniciar sesión para guardar el nombre de la imagen

// Verificar si se ha enviado un archivo
if(isset($_FILES['imagen'])) {
    $archivo = $_FILES['imagen'];
    
    // Obtener información del archivo
    $nombre = $archivo['name'];
    $tipo = $archivo['type'];
    $tamano = $archivo['size'];
    $temp = $archivo['tmp_name'];
    $error = $archivo['error'];
    
    // Verificar si hubo algún error en la subida
    if($error !== UPLOAD_ERR_OK) {
        switch($error) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "<div class='alert alert-danger'>El archivo es demasiado grande. El límite es de 3MB.</div>";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "<div class='alert alert-danger'>El archivo solo se subió parcialmente.</div>";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "<div class='alert alert-danger'>No se seleccionó ningún archivo.</div>";
                break;
            default:
                echo "<div class='alert alert-danger'>Error al subir el archivo.</div>";
        }
        exit;
    }
    
    // Verificar el tamaño (3MB = 3 * 1024 * 1024 bytes)
    $tamano_maximo = 3 * 1024 * 1024; // 3MB en bytes
    if($tamano > $tamano_maximo) {
        echo "<div class='alert alert-danger'>El archivo es demasiado grande. El límite es de 3MB.</div>";
        exit;
    }
    
    // Verificar que sea una imagen
    $tipos_permitidos = array('image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp');
    if(!in_array($tipo, $tipos_permitidos)) {
        echo "<div class='alert alert-danger'>El archivo debe ser una imagen (JPEG, PNG, GIF, WEBP o BMP).</div>";
        exit;
    }
    
    // Generar un nombre único para evitar sobrescrituras
    $nombre_nuevo = uniqid('img_') . '.' . pathinfo($nombre, PATHINFO_EXTENSION);
    $directorio_destino = '../uploads/'; // Asegúrate de que este directorio exista y tenga permisos de escritura
    
    // Crear el directorio si no existe
    if(!is_dir($directorio_destino)) {
        mkdir($directorio_destino, 0755, true);
    }
    
    // Mover el archivo a la ubicación final
    if(move_uploaded_file($temp, $directorio_destino . $nombre_nuevo)) {
        // Guardar el nombre de la imagen en la sesión para usarlo después
        $_SESSION['imagen_subida'] = $nombre_nuevo;
        
        // Mostrar mensaje de éxito y redireccionar al formulario principal
        echo "
        <div class='alert alert-success'>
            La imagen se ha subido correctamente.
            <br>
            <img src='../uploads/{$nombre_nuevo}' style='max-width: 200px; margin-top: 10px;'>
        </div>
        <script>
            // Redireccionar al formulario principal después de 2 segundos
            setTimeout(function() {
                window.location.href = '../index.php?imagen_ok=1';
            }, 2000);
        </script>";
    } else {
        echo "<div class='alert alert-danger'>Error al guardar la imagen.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>No se recibió ninguna imagen.</div>";
}
?>