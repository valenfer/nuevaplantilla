<?php
// upload_logo.php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == UPLOAD_ERR_OK) {
    $targetDir = "../img/";
    $targetFile = $targetDir . "logo.png";

    // Verificar que el archivo sea una imagen
    $imageFileType = strtolower(pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION));
    if (getimagesize($_FILES["logo"]["tmp_name"]) === false) {
      echo json_encode(["success" => false, "message" => "El archivo no es una imagen válida."]);
      exit;
    }

    // Mover el archivo subido a la ubicación deseada
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFile)) {
      echo json_encode(["success" => true]);
    } else {
      echo json_encode(["success" => false, "message" => "Error al mover el archivo."]);
    }
  } else {
    echo json_encode(["success" => false, "message" => "No se ha recibido ningún archivo."]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>