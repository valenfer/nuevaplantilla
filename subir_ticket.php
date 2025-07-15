<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carpeta_destino = "tickets/"; // Ajusta la ruta si es necesario
    $nombre_archivo = uniqid() . "_" . basename($_FILES["ticket"]["name"]);
    $ruta_archivo = $carpeta_destino . $nombre_archivo;

    if (move_uploaded_file($_FILES["ticket"]["tmp_name"], $ruta_archivo)) {
        $_SESSION["archivoTicket"] = $nombre_archivo;
        $_SESSION["mensaje_subida"] = "El archivo se ha subido correctamente."; // Guardar mensaje en sesión
    } else {
        $_SESSION["mensaje_subida"] = "Error al subir el archivo."; // Guardar mensaje de error
    }
    header("Location: index.php#formulario"); // Redirigir de vuelta al formulario
    exit(); // Asegurar que el script se detenga después de la redirección
}
?>