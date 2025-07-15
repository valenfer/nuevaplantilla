<?php
// Evitar que se muestre cualquier error o advertencia como HTML
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Establecer encabezados para respuesta JSON
header('Content-Type: application/json');

try {
    // Directorio donde se guardará la imagen
    $target_dir = __DIR__ . "/../img/";
    $target_file = $target_dir . "bg.png";

    // Registrar información para depuración
    $log = [
        "target_dir" => $target_dir,
        "target_file" => $target_file
    ];

    // Verificar que se envió un archivo
    if (!isset($_FILES["fondoCabecera"])) {
        echo json_encode([
            "success" => false, 
            "message" => "No se recibió ningún archivo",
            "debug" => $log
        ]);
        exit;
    }

    // Verificar si hay errores en la subida
    if ($_FILES["fondoCabecera"]["error"] !== UPLOAD_ERR_OK) {
        echo json_encode([
            "success" => false, 
            "message" => "Error en la subida del archivo: " . $_FILES["fondoCabecera"]["error"],
            "debug" => $log
        ]);
        exit;
    }

    // Verificar si es una imagen real
    $check = getimagesize($_FILES["fondoCabecera"]["tmp_name"]);
    if ($check === false) {
        echo json_encode([
            "success" => false, 
            "message" => "El archivo no es una imagen",
            "debug" => $log
        ]);
        exit;
    }

    // Comprobar si existe el directorio, si no, intentar crearlo
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0755, true)) {
            echo json_encode([
                "success" => false, 
                "message" => "No se pudo crear el directorio para guardar la imagen",
                "debug" => $log
            ]);
            exit;
        }
    }

    // Verificar permisos de escritura
    if (!is_writable($target_dir)) {
        echo json_encode([
            "success" => false, 
            "message" => "El directorio no tiene permisos de escritura",
            "debug" => $log
        ]);
        exit;
    }

    // Intentar mover el archivo subido al destino final
    if (move_uploaded_file($_FILES["fondoCabecera"]["tmp_name"], $target_file)) {
        echo json_encode([
            "success" => true, 
            "message" => "La imagen se ha subido correctamente",
            "debug" => $log
        ]);
    } else {
        $error_msg = error_get_last() ? error_get_last()['message'] : 'Error desconocido';
        echo json_encode([
            "success" => false, 
            "message" => "Error al mover el archivo al destino final: " . $error_msg,
            "debug" => [
                "log" => $log,
                "file_info" => $_FILES["fondoCabecera"]
            ]
        ]);
    }
} catch (Exception $e) {
    // Capturar cualquier excepción y devolverla como JSON
    echo json_encode([
        "success" => false,
        "message" => "Error en el servidor: " . $e->getMessage()
    ]);
}
?>