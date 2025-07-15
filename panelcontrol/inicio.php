<?php
require_once "./php/indexfunc.php";
$config = parse_ini_file('../php/db_config.txt');

// Acceder a los valores
$dbname = $config['dbname']; // "plantilla"
$dbuser = $config['dbuser']; // "root"
$dbpass = $config['dbpass']; // "" (vacío)
$url = $config['url']; // "" (vacío)
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Configuración de Sorteos</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #ff5722;
            /* Naranja vibrante */
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .inicio-container {
            max-width: 90%;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para los mensajes condicionales */
        .inicio-container div[style] {
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
            font-size: 1.2em;
            line-height: 1.5;
        }

        /* Estilo específico para el mensaje de plantilla */
        .inicio-container div[style*="background-color:rgb(236, 248, 73)"] {
            background-color: #fff9c4 !important;
            /* Amarillo suave */
            border-left: 6px solid #fdd835 !important;
            /* Amarillo más fuerte */
            color: #c62828 !important;
            /* Rojo oscuro */
        }

        /* Estilo específico para el mensaje de nuevo sorteo */
        .inicio-container div[style*="background-color: yellow"] {
            background-color: #c8e6c9 !important;
            /* Verde claro */
            border-left: 6px solid #4caf50 !important;
            /* Verde */
            color: #2e7d32 !important;
            /* Verde oscuro */
        }

        p {
            font-size: 1.1em;
            line-height: 1.6;
            color: #555;
        }

        .section {
            margin: 20px 0;
            padding: 15px;
            background-color: #fafafa;
            border-radius: 8px;
            border-left: 4px solid #ff9800;
            /* Naranja */
        }

        .section h3 {
            color: #ff9800;
            font-size: 1.6em;
            margin: 0 0 10px 0;
        }

        .section ul {
            list-style-type: none;
            padding-left: 20px;
        }

        .section ul li {
            position: relative;
            margin: 8px 0;
            font-size: 1em;
            color: #666;
        }

        .section ul li:before {
            content: "➜";
            /* Flecha estilizada */
            color: #ff5722;
            position: absolute;
            left: -20px;
        }

        .section p {
            font-style: italic;
            color: #888;
            margin-top: 10px;
        }

        hr {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, #ff9800, transparent);
            margin: 30px 0;
        }

        /* Botón siguiente */
        .siguiente {
            text-align: center;
        }

        .siguiente a {
            display: inline-block;
            background-color: #ff5722;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .siguiente a:hover {
            background-color: #e64a19;
        }
    </style>
</head>

<body>
    <div class="inicio-container">
        <?php
        $ultima_parte = basename($url); // Obtiene la última parte de la URL

        if ($ultima_parte === "plantilla") {
            echo '
    <div style="
        background-color:rgb(236, 248, 73);
        border-left: 6px solidrgb(220, 233, 42);
        padding: 15px 20px;
        margin: 20px 0;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        color:rgb(255, 0, 0);
        font-size: 1.5em;
    ">
        <strong>¡Atención!</strong> Actualmente te encuentras configurando la <i>plantilla</i>, y modificando la base de datos <i>' . $dbname . '</i> y todos los cambios que hagas en ella se copiarán a cualquier sorteo que configures
</div>';
        } else {
            echo '
    <div style="
        background-color: yellow;
        border-left: 6px solid #4caf50;
        padding: 15px 20px;
        margin: 20px 0;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        color: #2e7d32;
    ">
        <strong>Información:</strong> Actualmente estás configurando un nuevo sorteo que será accesible desde: 
        <a href="' . $url . '" style="color: #2e7d32; text-decoration: underline;">' . $url . '</a>
    </div>';
        }
        ?>
        <h2>Bienvenido a la Configuración de Sorteos</h2>

        <br>
        <p>Esta aplicación te ayudará a configurar los sorteos. Para ello, es conveniente que tengas preparados la siguiente información y recursos:</p>

        <div class="section">
            <h3>Imágenes</h3>
            <ul>
                <li>Logotipo</li>
                <li>Banner de cabecera</li>
                <li>Footer</li>
                <li>Fondos de footer y cabecera</li>
                <li>Favicon</li>
                <li>Imágenes para los premios</li>
            </ul>
            <p><em>Recomendable en formato .png. Por el nombre de los archivos no te preocupes.</em></p>
        </div>

        <div class="section">
            <h3>Datos</h3>
            <ul>
                <li>Ten en cuenta la cantidad de cada premio</li>
                <li>Horarios en los que se entregarán</li>
                <li>Datos de la empresa</li>
            </ul>
        </div>

        <div class="section">
            <h3>Textos legales</h3>
            <ul>
                <li>Bases legales y términos de uso</li>
                <li>Información legal que recibirán por correo</li>
            </ul>
        </div>

        <div class="section">
            <h3>Textos para correos</h3>
            <ul>
                <li>El texto que recibirán los participantes por email para informarles si han ganado o perdido</li>
            </ul>
        </div>

        <div class="section">
            <h3>Características de la promoción</h3>
            <ul>
                <li>Color corporativo para los campos y los botones</li>
                <li>Si se requiere código o no</li>
                <li>Si se permite participar mas de una vez al día (se controla por el teléfono)</li>
                <li>Los datos que se pedirán para la participación (Dirección, Código Postal, edad, etc)</li>
            </ul>
        </div>

    </div>
    <br>
    <div class="siguiente"><a href="index.php?page=imagenes">Comienza subiendo las imágenes >></a></div>
