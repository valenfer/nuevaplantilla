<?php
header('Content-Type: application/json');

try {
    $conn = connectDB();
    
    // Obtener datos del POST
    $id = $_POST['id'];
    $momento = $_POST['momento'];
    $fecha = $_POST['fecha'];
    
    // Preparar y ejecutar la actualización
    $sql = "UPDATE premios SET momento = :momento, fecha = :fecha WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':momento', $momento);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':id', $id);
    
    $resultado = $stmt->execute();
    
    echo json_encode(['success' => $resultado]);
    
    $conn = null;
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>