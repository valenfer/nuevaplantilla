<?php
require_once __DIR__ . "/../php/conexion.php"; // Incluye el archivo con connectdb()

// Obtener la conexión
$conn = connectdb();
if (!$conn instanceof PDO) {
    die("Error: No se pudo establecer la conexión a la base de datos. Revisa connectdb() en conexion.php.");
}

// Procesar el canje si se recibe un ID por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $stmt = $conn->prepare("UPDATE premiados SET canjeado = 1 WHERE id = ? AND canjeado = 0");
        $stmt->execute([$id]);
        // Redirigir para recargar la página y mostrar los cambios
        header("Location: index.php?page=canjear");
        exit;
    } catch (PDOException $e) {
        die("Error al canjear: " . $e->getMessage());
    }
}

// Obtener los datos de la tabla premiados
try {
    $stmt = $conn->prepare("SELECT id, nombre, codigo, premio, canjeado FROM premiados ORDER BY id");
    $stmt->execute();
    $premiadosData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener premiados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canjear Premios</title>
    <style>
        .canjear-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #34495e;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        button {
            background-color: #27ae60;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #219653;
        }
    </style>
</head>
<body>
    <div class="canjear-container">
        <h2>Canjear Premios</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Premio</th>
                        <th>Canjeado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($premiadosData as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre'] ?? 'Sin nombre'); ?></td>
                            <td><?php echo htmlspecialchars($row['codigo'] ?? 'Sin código'); ?></td>
                            <td><?php echo htmlspecialchars($row['premio'] ?? 'Sin premio'); ?></td>
                            <td><?php echo $row['canjeado'] ? 'Sí' : 'No'; ?></td>
                            <td>
                                <?php if (!$row['canjeado']): ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit">Canjear</button>
                                    </form>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>