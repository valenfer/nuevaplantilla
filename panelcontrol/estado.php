<?php
require_once __DIR__ . "/../php/conexion.php"; // Incluye el archivo con connectdb()

// Obtener la conexión
$conn = connectdb();
if (!$conn instanceof PDO) {
    die("Error: No se pudo establecer la conexión a la base de datos. Revisa connectdb() en conexion.php.");
}

// Función auxiliar para obtener valores de la tabla config
function getConfigValue($conn, $ajuste) {
    $stmt = $conn->prepare("SELECT valor FROM config WHERE ajuste = ?");
    $stmt->execute([$ajuste]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['valor'] ?? 'No disponible';
}

try {
    // Variables solicitadas
    $estado = getConfigValue($conn, 'estado');
    $nombrePromo = getConfigValue($conn, 'nombrePromo');
    $visitas = getConfigValue($conn, 'visitas');

    // Número de participantes agrupados por teléfono
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT telefono) as num FROM participantes");
    $stmt->execute();
    $numParticipantes = $stmt->fetch(PDO::FETCH_ASSOC)['num'] ?? 0;

    // Premios entregados (cantidad = 0) agrupados por nombre
    $stmt = $conn->prepare("SELECT nombre, COUNT(*) as cantidad FROM premios WHERE cantidad = 0 GROUP BY nombre");
    $stmt->execute();
    $premiosEntregadosData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $premiosEntregadosTotal = array_sum(array_column($premiosEntregadosData, 'cantidad'));
    $premiosEntregadosTexto = [];
    foreach ($premiosEntregadosData as $row) {
        $premiosEntregadosTexto[] = $row['cantidad'] . ' ' . htmlspecialchars($row['nombre']);
    }
    $premiosEntregadosTexto = empty($premiosEntregadosTexto) ? 'Ninguno' : implode('<br>', $premiosEntregadosTexto);

    // Premios pendientes (cantidad = 1) agrupados por nombre
    $stmt = $conn->prepare("SELECT nombre, COUNT(*) as cantidad FROM premios WHERE cantidad = 1 GROUP BY nombre");
    $stmt->execute();
    $premiosPendientesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $premiosPendientesTotal = array_sum(array_column($premiosPendientesData, 'cantidad'));
    $premiosPendientesTexto = [];
    foreach ($premiosPendientesData as $row) {
        $premiosPendientesTexto[] = $row['cantidad'] . ' ' . htmlspecialchars($row['nombre']);
    }
    $premiosPendientesTexto = empty($premiosPendientesTexto) ? 'Ninguno' : implode('<br>', $premiosPendientesTexto);

    // Consulta para participantes por código postal
    $stmt = $conn->prepare("SELECT cod_postal, COUNT(*) as participantes 
                          FROM participantes 
                          GROUP BY cod_postal 
                          ORDER BY participantes DESC");
    $stmt->execute();
    $codPostalData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para la tabla de premiados
    $stmt = $conn->prepare("SELECT id, nombre, codigo, premio, canjeado FROM premiados ORDER BY id");
    $stmt->execute();
    $premiadosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}

// Fecha y hora actual
$horaActual = date('H:i:s');
$fechaActual = date('d/m/Y');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado del Sorteo</title>
    <style>
        .estado-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h2, h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-bottom: 40px;
        }
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 250px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-text {
            color: #34495e;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .card-total {
            color: #2c3e50;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .card-details {
            color: #34495e;
            font-size: 14px;
            line-height: 1.4;
        }
        .table-container {
            margin-top: 40px;
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
        .table-container h3{
            text-align: center;
            margin: 20px;
        }
        #banner{
            text-align: center;
        }
        #banner img{
            width: 75%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="estado-container">
        <h2>Estado del Sorteo</h2>
        <div id="banner">
            <img src="../img/cabecera.png" alt="">
        </div>
        <div class="cards-container">
            <div class="card">
                <div class="card-text">El sorteo "<?php echo htmlspecialchars($nombrePromo); ?>" está</div>
                <div class="card-total"><?php echo $estado == 1 ? 'Activo' : 'Finalizado'; ?></div>
            </div>
            <div class="card">
                <div class="card-text">Participantes hasta las <?php echo $horaActual; ?> del <?php echo $fechaActual; ?></div>
                <div class="card-total"><?php echo $numParticipantes; ?></div>
            </div>
            <div class="card">
                <div class="card-text">Visitas recibidas</div>
                <div class="card-total"><?php echo $visitas; ?></div>
            </div>
        </div>
            <div class="cards-container">
            <div class="card">
                <div class="card-text">Premios entregados</div>
                <div class="card-total"><?php echo $premiosEntregadosTotal; ?></div>
                <div class="card-details"><?php echo $premiosEntregadosTexto; ?></div>
            </div>
            <div class="card">
                <div class="card-text">Premios pendientes</div>
                <div class="card-total"><?php echo $premiosPendientesTotal; ?></div>
                <div class="card-details"><?php echo $premiosPendientesTexto; ?></div>
            </div>
        </div>

        <div class="table-container">
            <h3>Participantes por Código Postal</h3>
            <table>
                <thead>
                    <tr>
                        <th>Código Postal</th>
                        <th>Número de Participantes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($codPostalData as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['cod_postal'] ?? 'Sin datos'); ?></td>
                            <td><?php echo $row['participantes']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


    </div>
</body>
</html>