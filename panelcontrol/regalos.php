<?php
include "funciones.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Configuración</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./csspanelcontrol.css">
</head>

<body>
    <div class="container">
        <h1>Configuración de sorteos</h1>
        <div class="seccion" id="premios">
            <form method="POST" action="">
                <h4>Configuración de premios</h4>
                <div class="input-container">
                    <label for="nombreRegalo">Premio:</label>
                    <input type="text" id="nombreRegalo" name="nombreRegalo" value="" required>
                    <select id="listaRegalos">
                        <option value="">Nueva regalo</option>
                        <?php
                        // Obtener la lista de regalos desde la regalos DB
                        $conn = connectDB();
                        $stmt = $conn->query("SELECT regalo FROM regalos");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['regalo'] . "'>" . $row['regalo'] . "</option>";
                        }
                        ?>
                    </select>
                    <label for="cantidadRegalo">Cantidad:</label>
                    <input type="number" id="cantidadRegalo" name="cantidadRegalo" value="" required>
                </div>
                <div class="input-container">
                    <label for="imagenPremio">Selecciona la imagen del premio (el archivo debe estar en la carpeta img/premios):</label>
                    <input type="text" id="imagenPremio" name="imagenPremio" value="" required>
                </div>
                <div id="carruselPremios" style="overflow-x: auto; white-space: nowrap;">
                    <?php
                    $directorio = '../img/premios/';
                    $archivos = glob($directorio . '*.{jpg,jpeg,png,gif}', GLOB_BRACE); // Obtiene archivos jpg, jpeg, png, gif

                    foreach ($archivos as $archivo) {
                        $nombreArchivo = basename($archivo);
                        echo '<img src="' . $archivo . '" alt="' . $nombreArchivo . '" style="height: 100px; margin-right: 10px; cursor: pointer;" onclick="seleccionarImagen(\'' . $nombreArchivo . '\')">';
                    }
                    ?>
                </div>

                <script>
                    function seleccionarImagen(nombreArchivo) {
                        document.getElementById('imagenPremio').value = nombreArchivo;
                    }
                </script>
                <div class="input-container">
                    <label for="horaInicioRegalo">Desde:</label>
                    <input type="time" id="horaInicioRegalo" name="horaInicioRegalo" value="" required>
                    <label for="horaFinRegalo">Hasta:</label>
                    <input type="time" id="horaFinRegalo" name="horaFinRegalo" value="" required>
                    <label for="fechaRegalo">Fecha:</label>
                    <input type="date" id="fechaRegalo" name="fechaRegalo" value="" required>
                </div>

                <input type="hidden" name="boton_pulsado" id="boton_pulsado" value="">
                <div class="botonera">
                    <input type="submit" value="Guardar datos empresa" onclick="document.getElementById('boton_pulsado').value = 'premios';">
                </div>
            </form>
        </div>

    </div>
    <script src="./panelcontrol.js"></script>

</body>

</html>

</html>