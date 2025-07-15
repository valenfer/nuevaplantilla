<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['favicon'])) {
    $file = $_FILES['favicon'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];

    if ($fileError === 0) {
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = array('jpg', 'jpeg', 'png', 'gif', 'ico'); // Extensiones permitidas

        if (in_array($fileExt, $allowedExt)) {
            $fileDestination = '../img/favicon.png';
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error al mover el archivo.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Extensión de archivo no permitida.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al subir el archivo.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Solicitud no válida.']);
}
?>