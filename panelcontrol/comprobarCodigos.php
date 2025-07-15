
<?php
require_once "../php/conexion.php";
/**
 * Comprueba si todos los códigos en la tabla 'codigos' son únicos
 * 
 * @param PDO $conn Conexión PDO a la base de datos
 * @return array Resultado de la verificación con las siguientes claves:
 *         - 'sonUnicos': bool - true si todos los códigos son únicos, false si hay duplicados
 *         - 'duplicados': array - lista de códigos duplicados (vacío si no hay duplicados)
 *         - 'totalCodigos': int - total de códigos en la tabla
 *         - 'codigosUnicos': int - cantidad de códigos únicos
 */
function verificarCodigosUnicos($conn) {
    try {
        // Consulta para identificar códigos duplicados
        $query = "SELECT codigo, COUNT(*) as cantidad 
                  FROM codigos 
                  GROUP BY codigo 
                  HAVING COUNT(*) > 1";
        
        $stmt = $conn->query($query);
        $duplicados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener el total de códigos y códigos únicos
        $stmtTotal = $conn->query("SELECT COUNT(*) FROM codigos");
        $totalCodigos = $stmtTotal->fetchColumn();
        
        $stmtUnicos = $conn->query("SELECT COUNT(DISTINCT codigo) FROM codigos");
        $codigosUnicos = $stmtUnicos->fetchColumn();
        
        // Preparar el resultado
        $resultado = [
            'sonUnicos' => empty($duplicados),
            'duplicados' => array_column($duplicados, 'codigo'),
            'totalCodigos' => $totalCodigos,
            'codigosUnicos' => $codigosUnicos
        ];
        
        return $resultado;
        
    } catch (PDOException $e) {
        return [
            'error' => true,
            'mensaje' => 'Error al verificar códigos: ' . $e->getMessage()
        ];
    }
}

// Ejemplo de uso:

$conn = connectDB();
$resultado = verificarCodigosUnicos($conn);

if ($resultado['sonUnicos']) {
    echo "Todos los códigos son únicos. Total: {$resultado['totalCodigos']}";
} else {
    echo "Se encontraron códigos duplicados: " . 
         implode(', ', $resultado['duplicados']) . 
         "\nTotal códigos: {$resultado['totalCodigos']}" . 
         "\nCódigos únicos: {$resultado['codigosUnicos']}";
}
?>