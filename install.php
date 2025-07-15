<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Iniciar sesión

// Inicializar $config y $message
$config = ['dbname' => 'plantilla', 'dbuser' => 'maruja', 'dbpass' => 'maruja1234!', 'url' => 'https://eager-shamir.185-18-197-134.plesk.page/plantilla/']; // Valores por defecto
$message = '';

// Obtener la URL actual
$currentUrl = dirname("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $dbname = $_POST['dbname'] ?? '';
    $dbuser = $_POST['dbuser'] ?? '';
    $dbpass = $_POST['dbpass'] ?? '';
    $submittedUrl = $_POST['urls'] ?? ''; // Corregido para que coincida con el name del input 'urls'
    // Si la URL enviada está vacía, usa la calculada, si no, usa la enviada.
    $urlToSave = !empty($submittedUrl) ? $submittedUrl : dirname("http" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);


    // Contenido del archivo db_config.txt
    // Escribir los valores entre comillas dobles para permitir caracteres especiales
    $configContent = "dbname=\"".$dbname."\"\n";
    $configContent .= "dbuser=\"".$dbuser."\"\n";
    $configContent .= "dbpass=\"".$dbpass."\"\n";
    $configContent .= "url=\"".$urlToSave."\"";

    // Ruta del archivo
    $filePath = __DIR__ . '/php/db_config.txt'; // Ruta más robusta
    
    // Asegurarse de que el directorio php exista y tenga permisos de escritura
    $dirPath = __DIR__ . '/php';
    if (!is_dir($dirPath)) {
        // Intentar crear el directorio si no existe
        if (!mkdir($dirPath, 0755, true) && !is_dir($dirPath)) {
            $message = "Error: No se pudo crear el directorio de configuración: " . $dirPath . ". Verifique los permisos del directorio padre (" . __DIR__ . ").";
            // No salir, permitir que la página se renderice con el mensaje
        }
    }

    if (empty($message)) { // Solo intentar escribir si no hubo error creando el directorio
        // Escribir en el archivo
        if (file_put_contents($filePath, $configContent) !== false) {
            $config = [
                'dbname' => $dbname,
                'dbuser' => $dbuser,
                'dbpass' => $dbpass,
                'url' => $urlToSave
            ];
            // Redirigir SOLO si todo fue exitoso
            header("Location: ./panelcontrol/index.php?config_saved=true");
            exit();
        } else {
            $message = "Error al guardar la configuración en $filePath. Verifique los permisos del archivo/directorio y los logs del servidor.";
            // No salir, permitir que la página se renderice con el mensaje
        }
    }
    // Si $message tiene algo (error al crear dir o al escribir), la redirección no ocurrirá
    // y la página se renderizará mostrando el $message.

} else {
    // Intentar leer el archivo existente al cargar la página
    $filePath = __DIR__ . '/php/db_config.txt'; // Ruta más robusta

    if (!file_exists($filePath)) {
        $message = "Error: El archivo de configuración NO EXISTE en la ruta: " . realpath(__DIR__ . '/php/') . DIRECTORY_SEPARATOR . 'db_config.txt' . " (Calculada como: " . $filePath . ")";
    } elseif (!is_readable($filePath)) {
        $message = "Error: El archivo de configuración EXISTE pero NO ES LEGIBLE en la ruta: " . $filePath . ". Verifique los permisos y la configuración de open_basedir.";
    } else {
        $loaded_config = parse_ini_file($filePath);
        if ($loaded_config === false) {
            $message = "Error: Se pudo acceder al archivo de configuración en '" . $filePath . "', pero no se pudo parsear (parse_ini_file falló). ¿Está el archivo vacío o mal formateado?";
        } else {
            $config = $loaded_config; // Cargar la configuración leída
            // $message = "Configuración cargada desde " . $filePath; // Mensaje de éxito opcional
        }
    }
    // Si $config no se pudo cargar completamente o alguna clave falta, asegúrate de que tenga valores por defecto para evitar errores más adelante
    // y para que el formulario se muestre correctamente.
    $default_keys = ['dbname' => 'plantilla', 'dbuser' => 'root', 'dbpass' => '', 'url' => $currentUrl];
    foreach ($default_keys as $key => $defaultValue) {
        if (!isset($config[$key])) {
            $config[$key] = $defaultValue;
        }
    }
    if (empty($config['url'])) { // Asegurar que la URL no esté vacía para mostrar en el formulario
        $config['url'] = $currentUrl;
    }

    if (empty($message) && !file_exists($filePath) && isset($_GET['config']) && $_GET['config'] == '1') {
        // Si se accede a la página de configuración y el archivo no existe, no mostrar error aún,
        // permitir al usuario crearlo.
    } else if (empty($message) && file_exists($filePath) && isset($_GET['config']) && $_GET['config'] == '1') {
         $message = "Archivo de configuración encontrado en: " . $filePath . ". Modifique si es necesario.";
    }


}

// Si venimos de setup.php, guardar el nombre de la carpeta y la base de datos en sesión para prellenar el formulario
if (isset($_GET['folder']) && !empty($_GET['folder'])) {
    $_SESSION['last_folder'] = $_GET['folder'];
}

// Verificar si se recibió la variable GET 'config'
$showConfig = isset($_GET['config']) && $_GET['config'] == '1';

// Antes de mostrar el formulario, si hay valor en sesión, adapta los valores aunque exista db_config.txt
if ($showConfig && isset($_SESSION['last_folder']) && !empty($_SESSION['last_folder'])) {
    $folder = $_SESSION['last_folder'];
    $config['dbname'] = $folder;
    // Adaptar la URL: reemplazar la última parte (plantilla o lo que sea) por el nombre de la carpeta
    if (!empty($config['url'])) {
        $config['url'] = preg_replace('#/[^/]+/?$#', '/' . $folder . '/', rtrim($config['url'], '/'));
    } else {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $baseUrl = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');
        $config['url'] = $protocol . $host . $baseUrl . '/' . $folder . '/';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="./panelcontrol/img/maruja.png" type="image/png">
    <title>Configuración de sorteos</title>
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
            font-size: 2rem;
            /* Tamaño de fuente grande */
            color: #ffffff;
            /* Color blanco */
            text-transform: uppercase;
            /* Texto en mayúsculas */
            letter-spacing: 2px;
            /* Espaciado entre letras */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            /* Sombra para resaltar el texto */
            padding: 15px 30px;
            /* Espaciado interno */
            border: 2px solid #ffffff;
            /* Borde blanco */
            border-radius: 10px;
            /* Bordes redondeados */
            background: rgba(0, 0, 0, 0.2);
            /* Fondo semitransparente */
            transition: all 0.3s ease-in-out;
            /* Transición suave */
            text-align: center;
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
            flex: 0 0 200px;
            font-weight: bold;
            color: #34495e;
        }

        .input-container input {
            flex: 1;
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
            color: rgb(74, 86, 192);
            margin-top: 15px;
            font-weight: bold;
        }

        div:not(.configbd-container, .input-container) {
            background-color: rgb(243, 230, 117);
            padding: 10px;
            border: 1px solidrgb(118, 129, 223);
            border-radius: 5px;
            color: rgb(65, 39, 179);
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        #banner {
            background-color: black;
            text-align: center;
            /* Centra la imagen horizontalmente */
            padding: 20px 0;
            /* Margen superior e inferior de 20px */
        }

        #banner img {
            display: inline-block;
            /* Permite centrar la imagen con text-align */
            vertical-align: middle;
            /* Centra la imagen verticalmente */
        }
    </style>
</head>

</head>

<body>
    <div id="banner">
        <img src="./panelcontrol/img/logo-blanco.png" alt="Logo">
    </div>
    <?php if (!$showConfig): ?>
        <h4>Configuración de nuevo sorteo</h4>
        <div id="copiaApp">

            <p>Vamos a crear la carpeta donde se alojará el nuevo sorteo y nos redirigiremos allí para comenzar con la configuración</p>
            <p style="color: red;">Recuerda haber realizado aneriormente una copia de la base de datos <i>plantilla</i> a otra con el mismo nombre que elijas para la carpeta</p>
            <form method="POST" action="setup.php">
                <label for="folderName">Nombre de la carpeta y la base de datos:</label>
                <input type="text" id="folderName" name="folderName" required>
                <input type="submit" value="Crear y redirigir">
                <br>
                <br>
                <p> Actualmente te encuentras en: <?php echo htmlspecialchars($currentUrl); ?> </p>
                <p> Para modificar la promoción actual pincha aquí <a href="./panelcontrol/">aquí</a> </p>
            </form>
        </div>
    <?php endif; ?>


    <?php if ($showConfig): ?>
        <h4>Configuración y actualización de Base de Datos</h4>
        <div class="configbd-container">
            
            <p>Confirma datos de la base de datos para poder configurar la conexión</p>
            <p>Comprueba que se ha seleccionado el nombre de la base de datos y la url correcta</p>
            <p>Cambia donde pone "plantilla" por el nombre selccionado anteriormente para la carpeta y la base de datos</p>



            <form id="dbConfigForm" method="POST" action="install.php"> 
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
                <div class="input-container">
                    <label for="url">URL:</label>
                    <input type="text" id="url" name="urls" value="<?php echo htmlspecialchars($config['url']); ?>" />
                </div>
                <button type="submit">Confirmar</button>
            </form>

            <div id="message" class="<?php echo isset($message) ? (strpos($message, 'Error') === 0 ? 'error' : 'success') : ''; ?>">
                <?php echo $message ?? ''; ?>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>