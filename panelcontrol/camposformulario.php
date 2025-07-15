<?php
require_once "./funciones.php";
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00=00 GMT);");
$timestamps = time();
// Leer el archivo camposauxiliares.txt
$archivo = './camposauxiliares.txt';

// Inicializar el array
$camposAuxiliares = [];

// Leer el archivo línea por línea
$lineas = file($archivo, FILE_IGNORE_NEW_LINES);

if ($lineas !== false) {
    foreach ($lineas as $linea) {
        // Dividir la línea en clave y valor usando el signo igual como delimitador
        $partes = explode('=', $linea, 2);

        // Asegurarse de que haya dos partes (clave y valor)
        if (count($partes) === 2) {
            $claveaux = trim($partes[0]);
            $valor = trim($partes[1]);

            // Agregar la clave y el valor al array
            $camposAuxiliares[$claveaux] = $valor;
        }
    }
} else {
    echo "No se pudo leer el archivo.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Campos Solicitados</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .seccion {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1.tituloseccion {
            text-align: center;
            color: #ff5722; /* Naranja vibrante */
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        hr {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, #ff9800, transparent);
            margin: 30px 0;
        }

        p.nota {
            font-size: 1.1em;
            color: #555;
            font-style: italic;
            margin: 10px 0;
            text-align: center;
        }

        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ff9800; /* Naranja */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #fafafa; /* Fondo gris claro para filas pares */
        }

        tr:hover {
            background-color: #f5f5f5; /* Hover sutil */
        }

        .aux-input-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .aux-input-container input[type="text"] {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            width: 200px;
        }

        td input[type="checkbox"] {
            transform: scale(1.5); /* Tamaño mayor para el checkbox */
            margin-left: 10px;
        }

        /* Botón de guardar */
        input[type="submit"] {
            display: block;
            width: 200px;
            margin: 20px auto;
            background-color: #ff5722;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #e64a19;
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
    <div class="seccion" id="camposSolicitados">
        <br>
        <h1 class="tituloseccion">Campos solicitados en el formulario</h1>
        <br>
        <hr>
        <br>
        <p class="nota">Marca o desmarca los campos que quieres que se soliciten en el formulario de participación</p>

        <p class="nota">Para los campos auxiliares introduce también el texto descriptivo que aparecerá en el campo del formulario</p>
        <br>
        <br>
        <form method="POST" action="camposSolicitados.php">
            <table>
                <tr>
                    <th>Nombre del Campo</th>
                    <th>Tipo</th>
                    <th>Seleccionar</th>
                </tr>
                <?php
                foreach ($campos as $clave => $valores) {
                    $tipo = $valores[0]; // "text" o "number"
                    $visible = $valores[1]; // 1 o 0

                    $inputAuxName = "";

                    if ($clave === "auxiliar1") {
                        $inputAuxName = "<input type=\"text\" name=\"inputAuxname1\" id=\"inputAuxname1\" value=\"{$camposAuxiliares['inputAuxname1']}\">";
                    }
                    if ($clave === "auxiliar2") {
                        $inputAuxName = "<input type=\"text\" name=\"inputAuxname2\" id=\"inputAuxname2\" value=\"{$camposAuxiliares['inputAuxname2']}\">";
                    }
                    if ($clave === "auxiliar3") {
                        $inputAuxName = "<input type=\"text\" name=\"inputAuxname3\" id=\"inputAuxname3\" value=\"{$camposAuxiliares['inputAuxname3']}\">";
                    }
                    if ($clave === "auxiliar4") {
                        $inputAuxName = "<input type=\"text\" name=\"inputAuxname4\" id=\"inputAuxname4\" value=\"{$camposAuxiliares['inputAuxname4']}\">";
                    }
                    $nombreCampo = ucfirst($clave); // Primera letra en mayúscula

                    // Checkbox: seleccionado si visible = 1, deseleccionado si 0
                    $checked = ($visible == 1) ? 'checked' : '';

                    echo '<tr>';
                    echo "<td class=\"aux-input-container\">$nombreCampo $inputAuxName</td>";
                    echo "<td>$tipo</td>";
                    echo "<td><input type=\"checkbox\" name=\"campos[$clave]\" value=\"1\" $checked></td>";
                    echo '</tr>';
                }
                ?>
            </table>
            <input type="submit" value="Guardar">
        </form>
    </div>
    <br>
    <br>
    <div class="siguiente"><a href="index.php?page=configuracion">Continúa con los datos de la empresa y la promoción >></a></div>
    <br>
</body>
</html>