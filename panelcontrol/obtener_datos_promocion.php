<?php
require_once '../php/conexion.php';

header('Content-Type: application/json'); // Establecer el tipo de contenido como JSON

if (isset($_GET['promocion'])) {
    try {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM promociones WHERE nombrePromo = :nombre");
        $stmt->execute(['nombre' => $_GET['promocion']]);
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($empresa) {
            echo json_encode($empresa, JSON_THROW_ON_ERROR);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Empresa no encontrada'], JSON_THROW_ON_ERROR);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()], JSON_THROW_ON_ERROR);
    } catch(JsonException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al codificar JSON'], JSON_THROW_ON_ERROR);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No se especificó empresa'], JSON_THROW_ON_ERROR);
}
?>