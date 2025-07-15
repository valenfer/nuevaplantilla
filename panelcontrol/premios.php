<?php
require_once "./funciones.php";
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00=00 GMT);");
$timestamps = time();
$config = parse_ini_file('../php/db_config.txt');
$url = $config['url'];
// Asegura que $url tenga el esquema http:// o https://
if (!preg_match('#^https?://#', $url)) {
    $url = 'http://' . $url;
}
$conn = connectDB();
//Obtener el valor de 'codigos' desde la tabla config
$stmt = $conn->prepare("SELECT valor FROM config WHERE ajuste = 'codigo'");
$stmt->execute();
$codigosVisible = $stmt->fetch(PDO::FETCH_ASSOC)['valor'] ?? '0';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Configuración de Premios</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Estilos generales (sin cambios) */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .seccion {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        h1.tituloseccion {
            text-align: center;
            color: #ff5722;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        h3.tc {
            text-align: center;
            color: #ff9800;
            font-size: 1.6em;
            margin: 20px 0;
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
        }

        p.aviso {
            color: #d32f2f;
            font-size: 1.1em;
            font-style: italic;
        }

        .input-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 15px 0;
            align-items: center;
        }

        .input-container label {
            font-size: 1.2em;
            color: #ff9800;
            font-weight: bold;
            min-width: 120px;
        }

        .input-container input {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            width: 100%;
            max-width: 200px;
        }

        .inputtable {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            width: 100%;
            max-width: 200px;
        }

        #carruselPremios {
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            background-color: #fafafa;
            border-radius: 8px;
            margin: 20px 0;
        }

        #carruselPremios img {
            height: 100px;
            margin-right: 10px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        #carruselPremios img:hover {
            transform: scale(1.05);
        }

        #divTabla {
            margin: 20px 0;
        }

        #miTabla {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        #miTabla th,
        #miTabla td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #miTabla th {
            background-color: #ff9800;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        #miTabla tr:nth-child(even) {
            background-color: #fafafa;
        }

        #miTabla tr:hover {
            background-color: #f5f5f5;
        }

        #miTabla img {
            max-width: 50px;
            height: auto;
            border-radius: 4px;
        }

        .botonera {
            text-align: center;
            margin: 20px 0;
        }

        input[type="submit"] {
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

        .modifbtn {
            background-color: #ff5722;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .modifbtn:hover {
            background-color: #e64a19;
        }

        /* Estilos para el botón de borrar */
        .borrarbtn {
            background-color: #d32f2f;
            /* Rojo intenso */
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        .borrarbtn:hover {
            background-color: #b71c1c;
            /* Rojo más oscuro para hover */
        }

        #datosPremios {
            display: flex;
            justify-content: space-around;
        }

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
    <div class="container">
        <div class="seccion" id="premios">
            <br>
            <h1 class="tituloseccion">Premios</h1>
            <br>
            <hr>
            <br>
            <h3 class="tc">Insertar nuevos premios</h3>
            <br>
            <form method="POST" action="">
                <p class="nota">Por cada tipo de premio introduce el nombre que describe al premio, la cantidad que se entregarán y desde qué hora hasta qué hora.</p>
                <p class="nota">Esto repartirá tantos premios introducidos en horas más o menos equidistantes en el tramo horario definido.</p>
                <p class="nota">Repite el proceso para cada premio.</p>
                <br>
                <p class="nota">Este proceso se repetirá por cada premio y en cada día que se entregarán. Por ejemplo: Queremos regalar 20 cajas de gambas en una fecha concreta entre las 9 de la mañana y las 9 de la noche</p>
                <p class="nota">Pondremos el día concreto, en el nombre Caja de gambas, y 20 en la cantidad y la hora de inicio y fin y se repartirán de forma equidistante las 20 cajas de gambas en tre las 9:00 y las 21:00</p>
                <p class="nota">En tabla inferor podrás modificar la hora así como eliminar premios que aún no se han entregado</p>
                <br>
                <div>
                    <p class="nota" style="color:#d32f2f;font-weight:bold;">
                        <strong>¿Cómo asignar prioridad a un premio?</strong><br>
                        Para que un premio salga a una hora concreta o tenga prioridad sobre otros, primero introdúcelo con los datos básicos.<br>
                        <u>Después</u>, en la tabla inferior, puedes modificar la <strong>prioridad</strong> (nivel), la <strong>hora</strong> y la <strong>fecha</strong> de cada premio.<br>
                        El sistema seleccionará el premio pendiente con mayor prioridad (nivel) cuya hora sea igual o anterior al momento del sorteo.<br>
                        Si hay varios premios con la misma prioridad, se elegirá el de hora más reciente.<br>
                        Cuanto mayor sea el nivel de prioridad, más prioridad tendrá el premio.<br>
                        Así, puedes hacer que un premio concreto salga a una hora determinada o posterior, aunque haya premios pendientes de horas anteriores.<br>
                        <br>
                        <span style="color:#ff9800;">Recuerda: tras modificar la prioridad, hora o fecha en la tabla, el cambio se aplica automáticamente.</span>
                    </p>
                </div>
                <br>
                <p class="nota">Introduce el nombre del premio, como se identificará en la presentación y los correos, y la cantidad a repartir entre la franja horaria definida.</p>
                <br>
                <div id="datosPremios" class="input-container">
                    <div>
                        <label for="nombreRegalo">Premio:</label>
                        <input type="text" id="nombreRegalo" name="nombreRegalo" value="" required>
                    </div>
                    <div>
                        <label for="cantidadRegalo">Cantidad:</label>
                        <input type="number" id="cantidadRegalo" name="cantidadRegalo" value="" required>
                    </div>
                </div>
                <br>
                <p class="nota">Introduce la fecha en la que se repartirá el regalo que estás configurando y el tramo horario en el que se entregará.</p>
                <br>
                <div class="input-container">
                    <label for="fechaRegalo">Fecha:</label>
                    <input type="date" id="fechaRegalo" name="fechaRegalo" value="" required>
                    <br>
                    <label for="horaInicioRegalo">Desde:</label>
                    <input type="time" id="horaInicioRegalo" name="horaInicioRegalo" value="" required>
                    <label for="horaFinRegalo">Hasta:</label>
                    <input type="time" id="horaFinRegalo" name="horaFinRegalo" value="" required>
                </div>
                <br>
                <hr>
                <br>
                <div class="input-container">
                    <label for="imagenPremio">Selecciona la imagen del premio:</label>
                    <input type="text" id="imagenPremio" name="imagenPremio" value="" required>
                </div>
                <br>
                <div id="carruselPremios">
                    <?php
                    $directorio = '../img/premios/';
                    $archivos = glob($directorio . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
                    foreach ($archivos as $archivo) {
                        $nombreArchivo = basename($archivo);
                        echo '<img src="' . $archivo . '" alt="' . $nombreArchivo . '" onclick="seleccionarImagen(\'' . $nombreArchivo . '\')">';
                    }
                    ?>
                </div>
                <script>
                    function seleccionarImagen(nombreArchivo) {
                        document.getElementById('imagenPremio').value = nombreArchivo;
                    }
                </script>
                <br>
                <input type="hidden" name="btn_premio" id="btn_premio" value="">
                <div class="botonera">
                    <input type="submit" value="Añadir premio" onclick="document.getElementById('btn_premio').value = 'premio';">
                </div>
            </form>
            <br>
            <p class="nota">En la siguiente tabla aparecerán los premios y las horas que tienes configuradas en estos momentos.</p>
            <p class="nota">Sobre la misma tabla puedes modificar o eliminar premios existentes. Para ver los cambios debes recargar la página</p>
            <p class="nota">Para borrar todos lso premiso ve a la opción de <a href="./index.php?page=tablas">tablas</a></p>

            <br>
            <div id="divTabla">
                <?php
                require_once "../php/conexion.php"; // Asegúrate de que la ruta sea correcta
                $conn = connectDB();
                $sql = "SELECT id, nombre, cantidad, img, momento, fecha, nivel FROM premios ORDER BY fecha ASC, momento ASC;";
                $resultado = $conn->query($sql);

                if ($resultado->rowCount() > 0) {
                    echo "<div class='tc'><h3>Tabla actual de premios</h3></div>";
                    echo "<table id='miTabla' border='1'>";
                    echo "<tr><th>Regalo</th><th>Cantidad</th><th>Imagen</th><th>Momento</th><th>Fecha</th><th>Prioridad</th><th>Modificar</th><th>Borrar</th></tr>";

                    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $fila['nombre'] . "</td>";
                        echo "<td>" . $fila['cantidad'] . "</td>";
                        echo "<td><img src='../img/premios/" . $fila['img'] . "' alt='" . $fila['nombre'] . "'></td>";

                        // Campo Momento
                        if ($fila['cantidad'] > 0) {
                            echo "<td><input class='inputtable momento-input' type='time' value='" . $fila['momento'] . "'></td>";
                        } else {
                            echo "<td>" . $fila['momento'] . "</td>";
                        }

                        // Campo Fecha
                        if ($fila['cantidad'] > 0) {
                            echo "<td><input class='inputtable fecha-input' type='date' value='" . $fila['fecha'] . "'></td>";
                        } else {
                            echo "<td>" . $fila['fecha'] . "</td>";
                        }

                        // Campo Prioridad (nivel) editable
                        $nivel = $fila['nivel'] ?? 1;
                        echo "<td><select class='inputtable nivel-input'>";
                        for ($n = 1; $n <= 5; $n++) {
                            $etiqueta = ($n == 1) ? '1 (Baja)' : (($n == 5) ? '5 (Alta)' : $n);
                            $selected = ($nivel == $n) ? 'selected' : '';
                            echo "<option value='$n' $selected>$etiqueta</option>";
                        }
                        echo "</select></td>";

                        // Botón Modificar
                        if ($fila['cantidad'] > 0) {
                            echo "<td><button class='modifbtn' data-id='" . $fila['id'] . "'>Modificar</button></td>";
                        } else {
                            echo "<td><button class='modifbtn' data-id='" . $fila['id'] . "' disabled>Deshabilitado</button></td>";
                        }
                        // Botón borrar
                        echo "<td><button class='borrarbtn' data-id='" . $fila['id'] . "'>Borrar</button></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p class='tc aviso'>No hay premios registrados.</p>";
                }
                $conn = null;
                ?>
            </div>



            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const botonesModificar = document.querySelectorAll('.modifbtn');
                    const botonesBorrar = document.querySelectorAll('.borrarbtn');

                    botonesModificar.forEach(boton => {
                        boton.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');
                            const fila = this.closest('tr');
                            const momento = fila.querySelector('.momento-input').value;
                            const fecha = fila.querySelector('.fecha-input').value;
                            const nivel = fila.querySelector('.nivel-input').value;

                            fetch('actualizar_premio.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `id=${encodeURIComponent(id)}&momento=${encodeURIComponent(momento)}&fecha=${encodeURIComponent(fecha)}&nivel=${encodeURIComponent(nivel)}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Premio actualizado correctamente');
                                    } else {
                                        alert('Error al actualizar el premio: ' + (data.error || 'Desconocido'));
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error: ' + error.message);
                                });
                        });
                    });

                    botonesBorrar.forEach(boton => {
                        boton.addEventListener('click', function() {
                            const id = this.getAttribute('data-id');

                            fetch('borrar_premio.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `id=${encodeURIComponent(id)}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Premio borrado correctamente');
                                        // Recarga la tabla o elimina la fila de la tabla
                                        location.reload(); // Recarga la página después de borrar
                                    } else {
                                        alert('Error al borrar el premio: ' + (data.error || 'Desconocido'));
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error: ' + error.message);
                                });
                        });
                    });
                });
            </script>
        </div>
        <br>


        <?php
        // Opción 1: Usando un bloque PHP con condicional if
        if ($codigo == 1) {
        ?>
            <div class="siguiente"><a href="index.php?page=tablas">El sorteo requiere códigos introdúcelos en la opción de Tablas >></a></div>;
        <?php
        } else {
        ?>
            <div class="siguiente"><a href="<?php echo $url; ?>">Este sorteo no requiere códigos ya puedes acceder desde <?php echo $url; ?></a></div>;
        <?php
        }
        ?>

    </div>
    <script src="./panelcontrol.js?ver=<?php echo $timestamps; ?>"></script>
</body>

</html>

<?php
if (isset($_POST['btn_premio']) && $_POST['btn_premio'] === 'premio') {
    // Debug: mostrar el valor recibido
    error_log('Valor recibido nivelRegalo: ' . var_export($_POST['nivelRegalo'], true));
    $nombre = $_POST['nombreRegalo'] ?? '';
    $cantidad = $_POST['cantidadRegalo'] ?? '';
    $nivel = isset($_POST['nivelRegalo']) ? intval($_POST['nivelRegalo']) : 1;
    if ($nivel < 1 || $nivel > 5) {
        $nivel = 1;
    }
    $fecha = $_POST['fechaRegalo'] ?? '';
    $horaInicio = $_POST['horaInicioRegalo'] ?? '';
    $horaFin = $_POST['horaFinRegalo'] ?? '';
    $imagen = $_POST['imagenPremio'] ?? '';

    $conn = connectDB();
    // Calcular los momentos para cada premio
    if ($cantidad > 0) {
        $inicio = strtotime($horaInicio);
        $fin = strtotime($horaFin);
        $intervalo = ($fin - $inicio) / max($cantidad, 1);
        for ($i = 0; $i < $cantidad; $i++) {
            $momento = date('H:i:s', $inicio + $intervalo * $i);
            $sql = "INSERT INTO premios (nombre, cantidad, nivel, img, momento, fecha) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nombre, 1, $nivel, $imagen, $momento, $fecha]);
        }
    }
}
?>