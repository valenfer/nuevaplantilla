<?php
$directorio = '../img/premios/';
$archivos = glob($directorio . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

foreach ($archivos as $archivo) {
    if (is_file($archivo)) {
        if (!unlink($archivo)) {
            echo json_encode(['success' => false, 'error' => 'Error al borrar el archivo: ' . $archivo]);
            exit;
        }
    }
}

echo json_encode(['success' => true]);
header("Location: ./index.php?page=configuracion#premios");
exit();

?>