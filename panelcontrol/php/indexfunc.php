<?php
// Función para conectar a la base de datos (PDO)

// Función para verificar y manejar las tablas
function checkAndHandleTables($pdo) {
    $tables = ['participantes', 'premiados']; // Nombres de las tablas a verificar
    $output = '';

    foreach ($tables as $table) {
        // Consultar el número de registros en la tabla
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM $table");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];

        if ($count === 0) {
            $output .= "<p>La tabla <strong>$table</strong> está vacía.</p>";
        } else {
            $output .= "<p>La tabla <strong>$table</strong> tiene $count registros, posiblemente de un sorteo anterior.</p>";
            $output .= "<form method='POST' style='display:inline;'>";
            $output .= "<input type='hidden' name='table' value='$table'>";
            $output .= "<button type='submit' name='delete'>Borrar</button>";
            $output .= "</form><br>";
        }
    }

    return $output;
}

// Manejar la solicitud de borrado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $table = $_POST['table'];

    try {
        // Borrar todos los registros de la tabla
        $pdo = connectDB();
        $stmt = $pdo->prepare("DELETE FROM $table");
        $stmt->execute();

        // Reiniciar los índices de la tabla
        $pdo->exec("ALTER TABLE $table AUTO_INCREMENT = 1");

        echo "<p>Los registros de la tabla <strong>$table</strong> han sido borrados y los índices han sido reiniciados.</p>";
    } catch (PDOException $e) {
        echo "<p>Error al borrar los registros de la tabla <strong>$table</strong>: " . $e->getMessage() . "</p>";
    }
}
?>