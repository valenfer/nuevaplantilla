<?php
// Inicializar $config y $message
$config = ['dbname' => 'plantilla', 'dbuser' => 'plantilla', 'dbpass' => 'plantilla1234']; // Valores por defecto
$message = '';

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $dbname = $_POST['dbname'] ?? '';
    $dbuser = $_POST['dbuser'] ?? '';
    $dbpass = $_POST['dbpass'] ?? '';

    // Contenido del archivo db_config.txt
    $configContent = "dbname=$dbname\n";
    $configContent .= "dbuser=$dbuser\n";
    $configContent .= "dbpass=$dbpass";

    // Ruta del archivo
    $filePath = 'php/db_config.txt';

    // Escribir en el archivo
    if (file_put_contents($filePath, $configContent) !== false) {
        $message = "Configuración guardada correctamente en $filePath";
        // Actualizar $config con los nuevos valores
        $config = [
            'dbname' => $dbname,
            'dbuser' => $dbuser,
            'dbpass' => $dbpass
        ];
    } else {
        $message = "Error al guardar la configuración en $filePath";
    }

    // Redirigir a index.php después de procesar el formulario
    header("Location: panelcontrol/index.php");
    exit(); // Asegura que el script termine tras la redirección
} else {
    // Intentar leer el archivo existente al cargar la página
    $filePath = 'php/db_config.txt';
    if (file_exists($filePath)) {
        $config = parse_ini_file($filePath);
        if ($config === false) {
            $message = "Error al leer el archivo de configuración existente";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración de Base de Datos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .configbd-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        p {
            color: #7f8c8d;
            margin-bottom: 20px;
        }
        .input-container {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .input-container label {
            flex: 0 0 200px; /* Ancho fijo para labels */
            font-weight: bold;
            color: #34495e;
        }
        .input-container input {
            flex: 1; /* Ocupa el resto del espacio */
            padding: 8px;
            border: 1px solid #dcdcdc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .input-container input:focus {
            border-color: #3498db;
            outline: none;
        }
        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2980b9;
        }
        #message.success {
            color: #27ae60;
            margin-top: 15px;
            font-weight: bold;
        }
        #message.error {
            color: #c0392b;
            margin-top: 15px;
            font-weight: bold;
        }
        div:not(.configbd-container, .input-container) {
            background-color: #fce4e4;
            padding: 10px;
            border: 1px solid #e74c3c;
            border-radius: 5px;
            color: #c0392b;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div> Atención!!! Antes de comenzar la configuración del sorteo debes configurar la conexión de la base de datos desde el dominio donde se vaya a ejecutar la aplicación</div>
<div class="configbd-container">
    <h4>Configuración y actualización de Base de Datos</h4>
    <p>Introduce los datos de la base de datos para poder configurar la conexión</p>

    <form id="dbConfigForm" method="POST">
        <div class="input-container">
            <label for="dbname">Nombre de base de datos</label>
            <input type="text" id="dbname" name="dbname" value="<?php echo htmlspecialchars($config['dbname']); ?>" required />
        </div>
        <div class="input-container">
            <label for="dbuser">Usuario base de datos:</label>
            <input type="text" id="dbuser" name="dbuser" value="<?php echo htmlspecialchars($config['dbuser']); ?>" required />
        </div>
        <div class="input-container">
            <label for="dbpass">Contraseña base de datos:</label>
            <input type="text" id="dbpass" name="dbpass" value="<?php echo htmlspecialchars($config['dbpass']); ?>" />
        </div>
        <button type="submit">Guardar configuración</button>
    </form>

    <div id="message" class="<?php echo isset($message) ? (strpos($message, 'Error') === 0 ? 'error' : 'success') : ''; ?>">
        <?php echo $message ?? ''; ?>
    </div>
</div>
</body>
</html>