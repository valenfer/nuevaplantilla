<?php
require_once "../php/conexion.php"; // Asegúrate de que la ruta sea correcta
header('Content-Type: application/json');

try {
    if (!isset($_POST['id'])) {
        throw new Exception('Falta el parámetro ID');
    }

    $conn = connectDB();
    $id = $_POST['id'];

    $sql = "DELETE FROM premios WHERE id = :id";
    $stmt = $conn->prepare($sql);
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