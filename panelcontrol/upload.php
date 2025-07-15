<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'setLogoActivo') {
            // Copiar la imagen seleccionada a logo.png
            $logo = $_POST['logo'];
            $src = '../img/logos/' . $logo;
            $dest = '../img/logo.png';

            if (copy($src, $dest)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error al copiar la imagen']);
            }
        }
    } else if (isset($_FILES['logo'])) {
        // Subir una nueva imagen a la carpeta logos
        $targetDir = '../img/logos/';
        $targetFile = $targetDir . basename($_FILES['logo']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Verificar si es una imagen válida
        $check = getimagesize($_FILES['logo']['tmp_name']);
        if ($check === false) {
            echo json_encode(['success' => false, 'error' => 'El archivo no es una imagen válida']);
            exit;
        }

        // Verificar si el archivo ya existe
        if (file_exists($targetFile)) {
            echo json_encode(['success' => false, 'error' => 'El archivo ya existe']);
            exit;
        }

        // Verificar el tamaño del archivo (opcional)
        if ($_FILES['logo']['size'] > 5000000) { // 5MB
            echo json_encode(['success' => false, 'error' => 'El archivo es demasiado grande']);
            exit;
        }

        // Permitir solo ciertos formatos de imagen
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo json_encode(['success' => false, 'error' => 'Solo se permiten archivos JPG, JPEG, PNG y GIF']);
            exit;
        }

        // Mover el archivo subido a la carpeta logos
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al subir el archivo']);
        }
    }
}