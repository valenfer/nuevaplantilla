<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbname = $_POST['dbname'];
    $dbuser = $_POST['dbuser'];
    $dbpass = $_POST['dbpass'];

    $data = "dbname=$dbname\ndbuser=$dbuser\ndbpass=$dbpass";

    // Guardar los datos en un archivo de texto
    $file = 'db_config.txt';
    if (file_put_contents($file, $data) !== false) {
        echo "Configuración guardada correctamente.";
    } else {
        echo "Error al guardar la configuración.";
    }
}
?>