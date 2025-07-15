<?php
session_start(); // Iniciar la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carpeta_destino = "/tickets/"; // Ruta a la carpeta de tickets
    $nombre_archivo = uniqid() . "_" . basename($_FILES["ticket"]["name"]); // Generar nombre único
    $ruta_archivo = $carpeta_destino . $nombre_archivo;

    if (move_uploaded_file($_FILES["ticket"]["tmp_name"], $ruta_archivo)) {
        $_SESSION["archivoTicket"] = $nombre_archivo; // Guardar el nombre en la sesión
        echo "El archivo se ha subido correctamente.";
    } else {
        echo "Error al subir el archivo.";
    }
}
?>