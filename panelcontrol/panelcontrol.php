<?php
require_once "./funciones.php";
require_once "../php/conexion.php";
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00=00 GMT);");
$timestamps = time();
$conn = connectDB();
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
    <title>Configuración</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: none;
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

        h4 {
            color: #ff9800;
            font-size: 1.6em;
            margin: 20px 0 10px;
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
            /* Centrar las notas */
        }

        .input-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin: 15px 0;
            align-items: center;
            /* Centrar los elementos dentro del contenedor */
        }

        .input-container.inline {
            flex-direction: row;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            /* Centrar horizontalmente los elementos inline */
        }

        .input-container label {
            font-size: 1.2em;
            color: #ff9800;
            font-weight: bold;
        }

        .input-container input,
        .input-container select {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            width: 100%;
            max-width: 400px;
        }

        .input-container input[type="color"] {
            padding: 2px;
            width: 60px;
            height: 40px;
        }

        .input-container textarea {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            width: 100%;
            max-width: none;
            resize: vertical;
        }

        .aviso {
            color: #d32f2f;
            font-size: 0.9em;
            font-style: italic;
        }

        #configmail {
            max-width: 600px;
            margin: 0 auto;
        }

        #opciones {
            margin: 20px 0;
            display: flex;
            justify-content: space-around;
        }

        .opcion-box {
            border: 2px solid #ff9800;
            border-radius: 8px;
            padding: 15px;
            background-color: #fafafa;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 250px;
        }

        .opcion-box label {
            font-size: 1.2em;
            color: #ff9800;
            font-weight: bold;
            margin: 0 30px 0 0;
            /* separa el título de los checkbox */
            min-width: 120px;
        }

        .radio-group {
            display: flex;
            gap: 15px;
        }

        .radio-group label {
            font-size: 1em;
            color: #555;
            font-weight: normal;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .radio-group input[type="radio"] {
            transform: scale(1.5);
        }

        .inline-form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
            justify-content: center;
            /* Centrar el inline-form */
        }

        .inline-form label {
            font-size: 1.2em;
            color: #ff9800;
            font-weight: bold;
        }

        .inline-form input {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
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

        .opcion-explicacion {
            color: #888;
            font-size: 1em;
            margin-left: 0;
            padding-left: 0;
            max-width: 600px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="seccion" id="empresa">
            <br>
            <h1 class="tituloseccion">Datos de la empresa</h1>
            <br>
            <hr>
            <br>
            <form method="POST" action="">
                <br>
                <p class="nota">El nombre de la empresa se utilizará para guardar la configuración, aparecerá en los textos legales y en el email que se envía a los participantes</p>
                <br>
                <div class="input-container inline">
                    <label for="nombreEmpresa">Nombre de la Empresa:</label>
                    <input type="text" id="nombreEmpresa" name="nombreEmpresa" value="<?php echo $nombreEmpresa; ?>" required>
                    <select id="listaEmpresas">
                        <option value="">Nueva empresa</option>
                        <?php
                        $conn = connectDB();
                        $stmt = $conn->query("SELECT nombreEmpresa FROM empresas");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['nombreEmpresa'] . "'>" . $row['nombreEmpresa'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <br>
                <br>
                <p class="nota">El correo de empresa se utilizará para enviar al cliente los datos de participación una vez finalizada la promoción</p>
                <br>
                <div class="input-container inline">
                    <label for="correoEmpresa">Correo de la Empresa:</label>
                    <input type="email" id="correoEmpresa" name="correoEmpresa" value="<?php echo $correoEmpresa; ?>" required>
                </div>
                <br>
                <hr>
                <br>
                <div id="configmail">
                    <h4>Configuración del correo</h4>
                    <br>
                    <p class="nota">Estos datos quedarán asociados a la empresa y se utilizarán para gestionar el envío de emails a los participantes y al cliente</p>
                    <br>
                    <div class="input-container inline">
                        <label for="host">Host:</label>
                        <input type="text" id="host" name="host" value="<?php echo $host; ?>" required>
                    </div>
                    <div class="input-container inline">
                        <label for="username">Nombre de Usuario:</label>
                        <input type="email" id="username" name="username" value="<?php echo $username; ?>" required>
                    </div>
                    <div class="input-container inline">
                        <label for="password">Contraseña:</label>
                        <input type="text" id="password" name="password" value="<?php echo $password; ?>" required>
                    </div>
                    <div class="input-container inline">
                        <label for="port">Puerto:</label>
                        <input type="number" id="port" name="port" value="<?php echo $port; ?>" required>
                    </div>
                    <br><br>
                </div>
                <br>
                <hr>
                <br>
                <div id="textos">
                    <br>
                    <p class="nota">El texto de los correos está adaptado según la empresa, si se guardan asociados a una empresa se podrán cargar y reutilizarlos</p>
                    <br>
                    <h4>Texto de correos</h4>
                    <br>
                    <div class="input-container inline">
                        <label for="asuntoMail">Asunto del correo para ganadores:</label>
                        <input type="text" id="asuntoMail" name="asuntoMail" value="<?php echo $asuntoMail; ?>" required>
                    </div>
                    <br>
                    <div class="input-container">
                        <label for="txtMailGanador">Texto del correo para ganadores con código:</label>
                        <textarea id="txtMailGanador" name="txtMailGanador" rows="5"><?php echo $txtMailGanador; ?></textarea>
                    </div>
                    <br>
                    <div class="input-container inline">
                        <label for="asuntoMailPerdedor">Asunto del Correo para Perdedores:</label>
                        <input type="text" id="asuntoMailPerdedor" name="asuntoMailPerdedor" value="<?php echo $asuntoMailPerdedor; ?>" required>
                    </div>
                    <br>
                    <div class="input-container">
                        <label for="txtMailPerdedor">Texto del Corre para Perdedores:</label>
                        <textarea id="txtMailPerdedor" name="txtMailPerdedor" rows="5"><?php echo $txtMailPerdedor; ?></textarea>
                    </div>
                    <br>
                    <div class="input-container">
                        <label for="infoLegal">Información Legal:</label>
                        <textarea id="infoLegal" name="infoLegal" rows="5"><?php echo $infoLegal; ?></textarea>
                    </div>
                    <br>
                    <div class="input-container">
                        <label for="basesLegales">Bases Legales: <span class="aviso">Atención, ten en cuenta que las bases legales varían de una promoción a otra, es donde explica en qué consisten las condiciones de la participación y los premios</span></label>
                        <textarea id="basesLegales" name="basesLegales" rows="5"><?php echo $basesLegales; ?></textarea>
                    </div>
                    <br>
                    <div class="input-container inline">
                        <label for="linkBasesLegales">Link para las bases legales:</label>
                        <input type="text" id="linkBasesLegales" name="linkBasesLegales" value="<?php echo $linkBasesLegales; ?>" required>
                    </div>
                    <br>
                    <div class="input-container inline">
                        <label for="linkTerminosUso">Link para los términos de uso:</label>
                        <input type="text" id="linkTerminosUso" name="linkTerminosUso" value="<?php echo $linkTerminosUso; ?>" required>
                    </div>
                    <br>
                    <hr>
                </div>
                <input type="hidden" name="btn_empresa" id="btn_empresa" value="">
                <div class="botonera">
                    <input type="submit" value="Guardar datos empresa" onclick="document.getElementById('btn_empresa').value = 'empresa';">
                </div>
            </form>
        </div>
        <br>
        <br>
        <br>
        <div class="seccion" id="promocion">
            <br>
            <br>
            <br>
            <br>
            <br>
            <h1 class="tituloseccion">Datos de la promoción</h1>
            <br>
            <hr>
            <br>
            <form method="POST" action="">
                <br>
                <p class="nota">Si seleccionas una promoción del listado se cargará la configuración guardada para esa promoción</p>
                <p class="nota">Si introduces un nuevo nombre, se creará una nueva promoción con ese nombre y la configuración seleccionada</p>
                <p class="nota">El nombre de la promoción aparecerá en la pestaña del navegador junto al favicon</p>
                <br>
                <div class="input-container inline">
                    <label for="nombrePromo">Nombre de la promoción:</label>
                    <input type="text" id="nombrePromo" name="nombrePromo" value="<?php echo $nombrePromo; ?>" required>
                    <select id="listaPromos">
                        <option value="">Nueva Promoción</option>
                        <?php
                        $conn = connectDB();
                        $stmt = $conn->query("SELECT nombrePromo FROM promociones");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['nombrePromo'] . "'>" . $row['nombrePromo'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <br>
                <hr>
                <br>
                <br>
                <p class="nota">Selecciona si se solicitará código para participar, si se permitirá que un mismo teléfono pueda participar más de una vez al día y el color de los botones y si requiere subir foto del ticket</p>
                <br>
                <div id="opciones" style="flex-direction: column; gap: 20px;">
                    <div class="opcion-box" style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <label for="codigo_si">Códigos:</label>
                            <br>
                            <div class="radio-group">
                                <label><input type="radio" id="codigo_si" name="codigo" value="1" <?php if ($codigo == 1) echo "checked"; ?> required> Sí</label>
                                <label><input type="radio" id="codigo_no" name="codigo" value="0" <?php if ($codigo == 0) echo "checked"; ?>> No</label>
                            </div>
                        </div>
                        <div class="opcion-explicacion">Si activas esta opción, el usuario deberá introducir un código para participar.</div>
                    </div>
                    <div class="opcion-box" style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <label for="multi_si">Multiparticipación:</label>
                            <div class="radio-group">
                                <label><input type="radio" id="multi_si" name="multiParticipacion" value="1" <?php if ($multiParticipacion == 1) echo "checked"; ?> required> Sí</label>
                                <label><input type="radio" id="multi_no" name="multiParticipacion" value="0" <?php if ($multiParticipacion == 0) echo "checked"; ?>> No</label>
                            </div>
                        </div>
                        <div class="opcion-explicacion">Permite que un mismo teléfono pueda participar más de una vez al día.</div>
                    </div>
                    <div class="opcion-box" style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <label for="foto_si">Foto:</label>
                            <div class="radio-group">
                                <label><input type="radio" id="foto_si" name="fotoTicket" value="1" <?php if ($subirImagen == 1) echo "checked"; ?> required> Sí</label>
                                <label><input type="radio" id="foto_no" name="fotoTicket" value="0" <?php if ($subirImagen == 0) echo "checked"; ?>> No</label>
                            </div>
                        </div>
                        <div class="opcion-explicacion">Solicita al usuario subir una foto del ticket para participar.</div>
                    </div>
                    <div class="opcion-box" style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <label for="color">Color:</label>
                            <input type="color" id="color" name="color" value="<?php echo $color; ?>" required>
                        </div>
                        <div class="opcion-explicacion">Selecciona el color principal de los botones y campos de texto de la promoción.</div>
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <p class="nota">Indica la fecha de inicio y fin de la promoción y el horario en el que estará activa</p>
                <br>
                <div class="inline-form">
                    <label for="inicio_promo">Fecha de INICIO de Promoción:</label>
                    <input type="date" id="inicio_promo" name="inicio_promo" value="<?php echo $inicio_promo; ?>" required>
                    <label for="fin_promo">Fecha de FIN de Promoción:</label>
                    <input type="date" id="fin_promo" name="fin_promo" value="<?php echo $fin_promo; ?>" required>
                </div>
                <br>
                <div class="inline-form">
                    <label for="horaAp">Hora de Apertura:</label>
                    <input type="time" id="horaAp" name="horaAp" value="<?php echo $horaAp; ?>" required>
                    <label for="horaC">Hora de Cierre:</label>
                    <input type="time" id="horaC" name="horaC" value="<?php echo $horaC; ?>" required>
                </div>
                <br>
                <input type="hidden" name="btn_promocion" id="btn_promocion" value="">
                <div class="botonera">
                    <input type="submit" value="Guardar datos promoción" onclick="document.getElementById('btn_promocion').value = 'promocion';">
                </div>
                <br>
            </form>
        </div>
        <br>
        <div class="siguiente"><a href="index.php?page=premios">Continúa introduciendo los premios >></a></div>
        <br>
    </div>
    <script src="./panelcontrol.js?ver=" <?php echo $timestamps; ?>"></script>
</body>

</html>