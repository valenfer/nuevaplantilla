<?php
require_once "./funciones.php";
$config = parse_ini_file('../php/db_config.txt');
$url = $config['url']; // "" (vacío)
// Función para leer el archivo db_config.txt y devolver los valores
function readDbConfig()
{
    $file = '../php/db_config.txt';
    $config = ['dbname' => '', 'dbuser' => '', 'dbpass' => '', 'url' => ''];

    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                if (array_key_exists($key, $config)) {
                    $config[$key] = $value;
                }
            }
        }
    }
    return $config;
}
//Archivos de imagenes de tickets
$directorio = '../tickets/'; // Ruta al directorio

// Contar archivos
$archivos = glob($directorio . "*");
$cantidad_archivos = count($archivos);

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar borrado de tablas
    if (isset($_POST['borrar_participantes'])) {
        $conn = connectDB();
        $conn->exec("DELETE FROM participantes");
        $conn->exec("ALTER TABLE participantes AUTO_INCREMENT = 1");
        $message = "Tabla participantes borrada correctamente.";
    }
    if (isset($_POST['borrar_premiados'])) {
        $conn = connectDB();
        $conn->exec("DELETE FROM premiados");
        $conn->exec("ALTER TABLE premiados AUTO_INCREMENT = 1");
        $message = "Tabla premiados borrada correctamente.";
    }
    if (isset($_POST['borrar_premios'])) {
        $conn = connectDB();
        $conn->exec("DELETE FROM premios");
        $conn->exec("ALTER TABLE premios AUTO_INCREMENT = 1");
        $message = "Tabla de premios borrada correctamente.";
    }
    if (isset($_POST['borrarTickets'])) {
        foreach ($archivos as $archivo) {
            if (is_file($archivo)) {
                unlink($archivo); // Borrar el archivo
            }
        }
        $message = "Im´genes de tickets han sido borrados.";
    }
}

// Leer los valores actuales del archivo (si existe)
$config = readDbConfig();

// Consultar información de las tablas
$conn = connectDB();

// Contar participantes y obtener fecha más reciente
$stmt = $conn->prepare("SELECT COUNT(*) as total, MAX(fecha_jugada) as ultima_fecha FROM participantes");
$stmt->execute();
$participantes_data = $stmt->fetch(PDO::FETCH_ASSOC);
$total_participantes = $participantes_data['total'];
$ultima_fecha = $participantes_data['ultima_fecha'] ?? 'No hay registros';

// Contar premiados
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM premiados");
$stmt->execute();
$total_premiados = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener el valor de 'codigos' desde la tabla config
$stmt = $conn->prepare("SELECT valor FROM config WHERE ajuste = 'codigo'");
$stmt->execute();
$codigosVisible = $stmt->fetch(PDO::FETCH_ASSOC)['valor'] ?? '0';

// Contar premios
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM premios");
$stmt->execute();
$total_premios = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

//Archivos de imagenes de tickets
$directorio = '../tickets/'; // Ruta al directorio

// Contar archivos
$archivos = glob($directorio . "*");
$cantidad_archivos = count($archivos);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bases de Datos</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 90%;
            /* Ampliado al 90% como en ejemplos anteriores */
            margin: 0 auto;
        }

        h3 {
            text-align: center;
            color: #ff5722;
            /* Naranja vibrante */
            font-size: 2em;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        hr {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, #ff9800, transparent);
            margin: 30px 0;
        }

        p {
            font-size: 1.1em;
            color: #555;
            text-align: center;
            margin: 10px 0;
        }

        p.nota {
            font-style: italic;
        }

        /* Contenedores de visitas y códigos */
        .visitas-container,
        .seccion {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .visitas-container p,
        .seccion p {
            margin: 0;
            font-size: 1.1em;
        }

        .input-container {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .input-container label {
            font-size: 1.2em;
            color: #ff9800;
            /* Naranja */
            font-weight: bold;
            margin: 0;
            white-space: nowrap;
        }

        .input-container input[type="number"] {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            width: 80px;
            text-align: center;
        }

        /* Botones */
        button,
        input[type="submit"] {
            background-color: #ff5722;
            /* Naranja */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        button:hover,
        input[type="submit"]:hover {
            background-color: #e64a19;
            /* Naranja más oscuro */
        }

        .visitas-container input[type="submit"],
        .seccion .input-container button[name="borrar_codigos"] {
            background-color: #d32f2f;
            /* Rojo para botones de borrado */
        }

        .visitas-container input[type="submit"]:hover,
        .seccion .input-container button[name="borrar_codigos"]:hover {
            background-color: #b71c1c;
            /* Rojo más oscuro */
        }

        /* Mensaje */
        #message {
            margin-top: 20px;
            text-align: center;
            font-size: 1.1em;
        }

        #message.success {
            color: #27ae60;
            /* Verde para éxito */
        }

        #message.error {
            color: #d32f2f;
            /* Rojo para error */
        }

        .codigos {
            display: flex;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
            justify-content: space-around;
        }
    </style>
</head>

<body>
    <div class="container">
        <br>
        <h3>En este apartado puedes restaurar las tablas y valores así como añadir códigos de participación</h3>
        <br>
        <div class="visitas-container">
            <p>En la tabla participantes hay <?php echo $total_participantes; ?> registros </p>
            <form action="" method="post">
                <input type="submit" name="borrar_participantes" value="Borrar">
            </form>
        </div>
        <br>
        <div class="visitas-container">
            <p>En la tabla premiados hay <?php echo $total_premiados; ?> registros</p>
            <form action="" method="post">
                <input type="submit" name="borrar_premiados" value="Borrar">
            </form>
        </div>
        <br>
        <div class="visitas-container">
            <?php
            $conn = connectDB();
            $visitas = obtenerVisitas($conn);
            ?>
            <p>Visitas acumuladas: <?php echo $visitas; ?></p>
            <form action="" method="post">
                <input type="submit" name="resetear" value="Poner a cero">
            </form>
        </div>
        <br>
        <div class="visitas-container">
            <p>En la tabla premios hay <?php echo $total_premios; ?> registros</p>
            <form action="" method="post">
                <input type="submit" name="borrar_premios" value="Borrar">
            </form>
        </div>
        <br>
        <div class="visitas-container">
            <p id="archivosTikets">Hay <?php echo $cantidad_archivos; ?> archivos de imagenes de tickes almacenados</p>
            <form action="" method="post">
                <input type="submit" name="borrarTickets" value="Borrar">
            </form>
        </div>
        <br>
        <hr>
        <br>
        <?php if ($codigosVisible == '1') { ?>
            <p>Actualmente tienes configurado el sorteo para que se requiera código para participar</p>
            <p class="nota">Añade los códigos para participar, generará tantos códigos como introduzcas. Puedes borrar los códigos existentes o añadir a los ya existentes.</p>
            <div class="seccion borrarCodigos">
                <div class="input-container">
                    <form class="codigos" method="post">
                        <label>Actualmente tienes <?php echo contarCodigos(); ?> códigos</label>
                        <button type="submit" name="borrar_codigos">Borrar</button>
                    </form>
                </div>
            </div>
            <div class="seccion">
                <div class="input-container">
                    <form class="codigos" method="post">
                        <label for="cantidadCodigos">Añadir códigos (Si hay códigos se añadirán)</label>
                        <input type="number" id="cantidadCodigos" name="cantidadCodigos" min="1">
                        <button type="submit">Generar Códigos</button>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <p>Actualmente tienes configurado el sorteo para participar SIN códigos</p>
        <?php } ?>
        <?php if (isset($message)) { ?>
            <p id="message" class="<?php echo strpos($message, 'correctamente') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
        <?php } ?>
    </div>
</body>

</html>