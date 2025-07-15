<?php
require_once "../php/conexion.php"; // Asegúrate de que la ruta sea correcta
header('Content-Type: application/json');

try {
    if (!isset($_POST['id']) || !isset($_POST['momento']) || !isset($_POST['fecha']) || !isset($_POST['nivel'])) {
        throw new Exception('Faltan parámetros');
    }

    $conn = connectDB();
    $id = $_POST['id'];
    $momento = $_POST['momento'];
    $fecha = $_POST['fecha'];
    $nivel = $_POST['nivel'];

    $sql = "UPDATE premios SET momento = :momento, fecha = :fecha, nivel = :nivel WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':momento', $momento);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':nivel', $nivel);
    $stmt->bindParam(':id', $id);

    $resultado = $stmt->execute();

    echo json_encode(['success' => $resultado]);
    $conn = null;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
exit;
?>