<?php
// obtener_promocion.php
require_once 'conexion.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

if (isset($_GET['nombrePromo'])) {
    $nombrePromo = $_GET['nombrePromo'];
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT * FROM promociones WHERE nombrePromo = ?");
    $stmt->execute([$nombrePromo]);
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($datos) {
        echo json_encode($datos);
    } else {
        echo json_encode(['error' => 'Promoción no encontrada']);
    }
} else {
    echo json_encode(['error' => 'Nombre de promoción no proporcionado']);
}
?>