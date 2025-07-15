<?php

require_once "../php/config.php";


// Obtener los datos de la tabla config
$c = consulta("SELECT * FROM config");

// Función para obtener el valor de un ajuste específico
function obtenerValor($ajuste, $c)
{
    foreach ($c as $fila) {
        if ($fila["ajuste"] == $ajuste) {
            return $fila["valor"];
        }
    }
    return ""; // Valor por defecto si no se encuentra el ajuste
}

// Inicializar variables con los valores de la base de datos
$nombrePromo = obtenerValor("nombrePromo", $c);
$codigo = obtenerValor("codigo", $c);
$color = obtenerValor("color", $c);
$nombreEmpresa = obtenerValor("nombreEmpresa", $c);
$correoEmpresa = obtenerValor("correoEmpresa", $c);
$multiParticipacion = obtenerValor("multiParticipacion", $c);
$asuntoMail = obtenerValor("asuntoMail", $c);
$fin_promo = obtenerValor("fin_promo", $c);
$infoLegal = obtenerValor("infoLGPD", $c);
$basesLegales = obtenerValor("bases_legales", $c);
$txtMailGanador = obtenerValor("texto_mail_ganador", $c);
$txtMailPerdedor = obtenerValor("texto_mail_perdedor", $c);
$asuntoMailPerdedor = obtenerValor("asuntoMailPerdedor", $c);
$horaAp = obtenerValor("horaAp", $c);
$horaC = obtenerValor("horaC", $c);
$host = obtenerValor("host", $c);
$username = obtenerValor("username", $c);
$password = obtenerValor("password", $c);
$port = obtenerValor("port", $c);
$link = obtenerValor("link", $c);
$linkBasesLegales = obtenerValor("linkBasesLegales", $c);
$linkTerminosUso = obtenerValor("linkTerminosUso", $c);
$inicio_promo = obtenerValor("inicio_promo", $c);
$subirImagen = obtenerValor("subirImagen", $c);

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['btn_empresa']) && ($_POST['btn_empresa'] === 'empresa')) {
        actualizarEmpresa();
    }
    if (isset($_POST['btn_promocion']) && ($_POST['btn_promocion'] === 'promocion')) {
        actualizarPromocion();
        header("Location: ./index.php?page=premios");
        exit();
    }
}


//aCTUALIZAMOS EMPRESA
function actualizarEmpresa()
{
    // Recoger los datos del formulario
    $nombreEmpresa = $_POST['nombreEmpresa'];
    $correoEmpresa = $_POST['correoEmpresa'];
    $asuntoMail = $_POST['asuntoMail'];
    $infoLegal = $_POST['infoLegal'];
    $basesLegales = $_POST['basesLegales'];
    $txtMailGanador = $_POST['txtMailGanador'];
    $txtMailPerdedor = $_POST['txtMailPerdedor'];
    $asuntoMailPerdedor = $_POST['asuntoMailPerdedor'];
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $port = $_POST['port'];
    $linkBasesLegales = $_POST["linkBasesLegales"];
    $linkTerminosUso = $_POST["linkTerminosUso"];


    // Actualizar emporesa en la tabla config
    $actualizaciones = [
        ["ajuste" => "nombreEmpresa", "valor" => $nombreEmpresa],
        ["ajuste" => "correoEmpresa", "valor" => $correoEmpresa],
        ["ajuste" => "asuntoMail", "valor" => $asuntoMail],
        ["ajuste" => "infoLGPD", "valor" => $infoLegal],
        ["ajuste" => "bases_legales", "valor" => $basesLegales],
        ["ajuste" => "texto_mail_ganador", "valor" => $txtMailGanador],
        ["ajuste" => "texto_mail_perdedor", "valor" => $txtMailPerdedor],
        ["ajuste" => "asuntoMailPerdedor", "valor" => $asuntoMailPerdedor],
        ["ajuste" => "host", "valor" => $host],
        ["ajuste" => "username", "valor" => $username],
        ["ajuste" => "password", "valor" => $password],
        ["ajuste" => "port", "valor" => $port],
        ["ajuste" => "linkBasesLegales", "valor" => $linkBasesLegales],
        ["ajuste" => "linkTerminosUso", "valor" => $linkTerminosUso],
    ];

    foreach ($actualizaciones as $actualizacion) {
        //Actualizamos tabla config para sorteo en curso
        $sql = "UPDATE config SET valor = '" . $actualizacion["valor"] . "' WHERE ajuste = '" . $actualizacion["ajuste"] . "'";
        insert($sql); // Ejecutar la consulta de actualización
    }
    // Verificar si la empresa ya existe en la tabla empresas
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM empresas WHERE nombreEmpresa = :nombreEmpresa");
    $stmt->execute([':nombreEmpresa' => $nombreEmpresa]);
    $count = $stmt->fetchColumn();
    if ($count == 0) {
        //Si no existe la añadimos a la tabla empresas
        $sql = "INSERT INTO empresas (nombreEmpresa, correoEmpresa, host, username, password, port, asuntoMail, txtMailGanador, asuntoMailPerdedor, txtMailPerdedor, infoLegal, basesLegales, linkBasesLegales, linkTerminosUso)
                VALUES (:nombreEmpresa, :correoEmpresa, :host, :username, :password, :port, :asuntoMail, :txtMailGanador, :asuntoMailPerdedor, :txtMailPerdedor, :infoLegal, :basesLegales, :linkBasesLegales, :linkTerminosUso)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombreEmpresa' => $nombreEmpresa,
            ':correoEmpresa' => $correoEmpresa,
            ':host' => $host,
            ':username' => $username,
            ':password' => $password,
            ':port' => $port,
            ':asuntoMail' => $asuntoMail,
            ':txtMailGanador' => $txtMailGanador,
            ':asuntoMailPerdedor' => $asuntoMailPerdedor,
            ':txtMailPerdedor' => $txtMailPerdedor,
            ':infoLegal' => $infoLegal,
            ':basesLegales' => $basesLegales,
            ':linkBasesLegales' => $linkBasesLegales,
            ':linkTerminosUso' => $linkTerminosUso
        ]);
        echo "<script>
            alert('Se ha añadido la nueva empresa.');
        </script>";
    } else { //Si la empresa ya esiste se actualiza con los datos del formulario
        $sql = "UPDATE empresas SET 
                nombreEmpresa = :nombreEmpresa,
                correoEmpresa = :correoEmpresa, 
                host = :host, 
                username = :username, 
                password = :password, 
                port = :port, 
                asuntoMail = :asuntoMail, 
                txtMailGanador = :txtMailGanador, 
                asuntoMailPerdedor = :asuntoMailPerdedor, 
                txtMailPerdedor = :txtMailPerdedor, 
                infoLegal = :infoLegal, 
                basesLegales = :basesLegales,
                linkBasesLegales = :linkBasesLegales,
                linkTerminosUso= :linkTerminosUso
            WHERE nombreEmpresa = :nombreEmpresa";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombreEmpresa' => $nombreEmpresa,
            ':correoEmpresa' => $correoEmpresa,
            ':host' => $host,
            ':username' => $username,
            ':password' => $password,
            ':port' => $port,
            ':asuntoMail' => $asuntoMail,
            ':txtMailGanador' => $txtMailGanador,
            ':asuntoMailPerdedor' => $asuntoMailPerdedor,
            ':txtMailPerdedor' => $txtMailPerdedor,
            ':infoLegal' => $infoLegal,
            ':basesLegales' => $basesLegales,
            ':linkBasesLegales' => $linkBasesLegales,
            ':linkTerminosUso' => $linkTerminosUso
        ]);
        echo "<script>
            alert('Se ha actualizado la empresa ya existente.');
        </script>";
    }
    header("Location: ./index.php?page=configuracion#promocion");
    exit();
}

//ACTUALIZAMOS DATOS DE PROMOCION

function actualizarPromocion()
{
    $prom=$_POST['btn_promocion'];
    echo "<script>
            console.log('Datos recibidos: ' + $prom);
        </script>";
    // Recoger los datos del formulario
    $nombrePromo = $_POST['nombrePromo'];
    $codigo = $_POST['codigo'];
    $color = $_POST['color'];
    $multiParticipacion = $_POST['multiParticipacion'];
    $fin_promo = $_POST['fin_promo'];
    $inicio_promo = $_POST['inicio_promo'];
    $horaAp = $_POST['horaAp'];
    $horaC = $_POST['horaC'];
    $link = "";
    $fotoTicket = $_POST['fotoTicket'];

    //$link = $_POST['link'];
    

    // Actualizar promocion en la tabla config

    $actualizaciones = [
        ["ajuste" => "nombrePromo", "valor" => $nombrePromo],
        ["ajuste" => "codigo", "valor" => $codigo],
        ["ajuste" => "color", "valor" => $color],
        ["ajuste" => "multiParticipacion", "valor" => $multiParticipacion],
        ["ajuste" => "fin_promo", "valor" => $fin_promo],
        ["ajuste" => "horaAp", "valor" => $horaAp],
        ["ajuste" => "horaC", "valor" => $horaC],
        ["ajuste" => "inicio_promo", "valor" => $inicio_promo],
        ["ajuste" => "subirImagen", "valor" => $fotoTicket]
    ];

    foreach ($actualizaciones as $actualizacion) {
        //Actualizamos tabla config para sorteo en curso
        $sql = "UPDATE config SET valor = '" . $actualizacion["valor"] . "' WHERE ajuste = '" . $actualizacion["ajuste"] . "'";
        insert($sql); // Ejecutar la consulta de actualización
    }
    echo "<script>
            alert('Datos de la promoción actual actualizada correctamente en config');
        </script>";
    //Verificar si la empresa ya existe en la tabla empresas
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT COUNT(*) FROM promociones WHERE nombrePromo = :nombrePromo");
    $stmt->execute([':nombrePromo' => $nombrePromo]);
    $count = $stmt->fetchColumn();

    if ($count == 0) { //Si la promocion no está guardada
        // Insertar los datos en la tabla promociones
        $sql = "INSERT INTO promociones (nombrePromo, color, codigo, multiParticipacion, fin_promo, horaAp, horaC, link) 
                VALUES (:nombrePromo, :color, :codigo, :multiParticipacion, :fin_promo, :horaAp, :horaC, :link)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombrePromo' => $nombrePromo,
            ':color' => $color,
            ':codigo' => $codigo,
            ':multiParticipacion' => $multiParticipacion,
            ':fin_promo' => $fin_promo,
            ':horaAp' => $horaAp,
            ':horaC' => $horaC,
            ':link' => $link
        ]);
        echo "<script>
            alert('Se ha añadido la nueva promocion.');
        </script>";
    } else { //Si la empresa ya esiste se actualiza con los datos del formulario
        $sql = "UPDATE promociones SET 
            color = :color, 
            codigo = :codigo, 
            multiParticipacion = :multiParticipacion, 
            fin_promo = :fin_promo, 
            horaAp = :horaAp, 
            horaC = :horaC, 
            link = :link
        WHERE nombrePromo = :nombrePromo"; // Cláusula WHERE para especificar el registro

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombrePromo' => $nombrePromo, // Clave para la cláusula WHERE
            ':color' => $color,
            ':codigo' => $codigo,
            ':multiParticipacion' => $multiParticipacion,
            ':fin_promo' => $fin_promo,
            ':horaAp' => $horaAp,
            ':horaC' => $horaC,
            ':link' => $link
        ]);
        echo "<script>
            alert('Se ha actualizado la promocion ya existente.');
        </script>";
    }
    header("Location: ./index.php?page=configuracion#promocion");
    exit();
}


//Añadir premios a la tabla
function guardarPremiosMultiples()
{
    $conn = connectDB();
    $nombreRegalo = $_POST['nombreRegalo'];
    $cantidadPremios = $_POST['cantidadRegalo'];
    $imagenPremio = $_POST['imagenPremio'];
    $horaInicioRegalo = $_POST['horaInicioRegalo'];
    $horaFinRegalo = $_POST['horaFinRegalo'];
    $fechaRegalo = $_POST['fechaRegalo'];

    $horaInicio = strtotime($horaInicioRegalo);
    $horaFin = strtotime($horaFinRegalo);
    // Genera números aleatorios entre 1 y 10 minutos
    $minutosInicioAleatorio = rand(1, 10) * 60; // Convertir a segundos
    $minutosFinAleatorio = rand(1, 10) * 60; // Convertir a segundos

    // Suma minutos aleatorios a la hora de inicio y resta a la hora de fin
    $horaInicio += $minutosInicioAleatorio;
    $horaFin -= $minutosFinAleatorio;

    $duracionTotal = $horaFin - $horaInicio;
    $intervalo = $cantidadPremios > 1 ? $duracionTotal / ($cantidadPremios - 1) : 0; // Evita división por cero

    for ($i = 0; $i < $cantidadPremios; $i++) {
        $horaPremio = date('H:i', $horaInicio + ($intervalo * $i));

        $sql = "INSERT INTO premios (nombre, cantidad, img, momento, fecha) VALUES (:nombre, :cantidad, :img, :momento, :fecha)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombreRegalo);
        $stmt->bindValue(':cantidad', 1); // Cantidad siempre es 1
        $stmt->bindParam(':img', $imagenPremio);
        $stmt->bindParam(':momento', $horaPremio);
        $stmt->bindParam(':fecha', $fechaRegalo);
        try {
            $stmt->execute();
            /*Obtener el ID del premio recién insertado
            $premioId = $conn->lastInsertId();

            // Renombrar la imagen
            $extension = pathinfo($imagenPremio, PATHINFO_EXTENSION);
            $nuevoNombreImagen = $premioId . '.' . $extension;
            $rutaOrigen = '../img/premios/' . $imagenPremio;
            $rutaDestino = '../img/premios/' . $nuevoNombreImagen;
            copy($rutaOrigen, $rutaDestino);*/
        } catch (PDOException $e) {
            echo "Error al guardar el premio: " . $e->getMessage();
            return; // Detiene la ejecución en caso de error
        }
    }

    echo "<script>
            alert('Se han añadido los premios.');
        </script>";
    $conn = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_premio']) && $_POST['btn_premio'] === 'premio') {
    guardarPremiosMultiples();
    header("Location: ./index.php?page=premios");
    exit;
}

function subirArchivoPremio()
{
    if (isset($_FILES['archivoSubida']) && $_FILES['archivoSubida']['error'] === UPLOAD_ERR_OK) {
        $archivo_temporal = $_FILES['archivoSubida']['tmp_name'];
        $nombre_archivo = $_FILES['archivoSubida']['name'];
        $ruta_destino = '../img/premios/' . $nombre_archivo;

        if (move_uploaded_file($archivo_temporal, $ruta_destino)) {
            echo "Archivo subido correctamente.";
        } else {
            echo "Error al subir el archivo.";
        }
    }
}

function actualizarCarrusel()
{
    $directorio = '../img/premios/';
    $archivos = glob($directorio . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

    $html = '';
    foreach ($archivos as $archivo) {
        $nombreArchivo = basename($archivo);
        $html .= '<img src="' . $archivo . '" alt="' . $nombreArchivo . '" style="height: 100px; margin-right: 10px; cursor: pointer;" onclick="seleccionarImagen(\'' . $nombreArchivo . '\')">';
    }
    echo $html;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivoSubida'])) {
        subirArchivoPremio();
        exit;
    }

    if (isset($_POST['actualizar_carrusel']) && $_POST['actualizar_carrusel'] === '1') {
        actualizarCarrusel();
        exit;
    }
}

function obtenerRutaImagenPremio($id_premio)
{

    // Establece la conexión a la base de datos usando tu función connectDB()
    $conn = connectDB();

    // Consulta la base de datos para obtener la ruta de la imagen
    $sql = "SELECT img FROM premios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id_premio, PDO::PARAM_INT); // Bind el parametro para prevenir inyecciones sql
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        //$mensaje = 'Imagen capturada de la tabla: ' . $resultado['img'];
        //echo "<script>console.log(' . json_encode($mensaje) . ');</script>";

        return $resultado['img'];
    } else {
        return "";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'obtener_imagen') {
    $id_premio = $_GET['id'];
    // var_dump("Entramso en obtener ruta de imagen con id: " . $id_premio); // Commented out to prevent AJAX issues
    $rutaImagen = obtenerRutaImagenPremio($id_premio);
    echo $rutaImagen;
}

//************************************ Generar codigos de participacion ******************************************* */
function contarCodigos()
{
    $conn = connectDB();

    try {
        $stmt = $conn->query("SELECT COUNT(*) FROM codigos");
        $count = $stmt->fetchColumn();
        return $count;
    } catch (PDOException $e) {
        echo "Error al contar registros: " . $e->getMessage();
        return null;
    }

    return null;
}
function borrarCodigos()
{
    $conn = connectDB();
    try {
        $conn->exec("DELETE FROM codigos");
        $conn->exec("ALTER TABLE codigos AUTO_INCREMENT = 1");
        echo "<script>alert('Tabla de codigos borrada con éxito')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error')</script>" . $e->getMessage();
        return null;
    }
}
if (isset($_POST['borrar_codigos'])) {
    borrarCodigos();
    // Opcional: Redirige a la misma página para evitar reenvío del formulario
    header("Location: ./index.php?page=tablas");
    exit;
}


if (isset($_POST['cantidadCodigos'])) {
    generarCodigos($_POST['cantidadCodigos']);
    // Redirigir solo después de terminar todas las inserciones
    header("Location: ./index.php?page=tablas");
    exit;
}

function generarCodigos($candidadCodigos)
{
    $cantidadCodigos = (int)$_POST['cantidadCodigos'];
    $conn = connectDB();

    // Obtener códigos existentes
    $stmt = $conn->query("SELECT codigo FROM codigos");
    $codigos = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Generar nuevos códigos
    $nuevosCodigosGenerados = 0;
    $intentosMaximos = $cantidadCodigos * 3; // Para evitar bucles infinitos
    $intentos = 0;

    while ($nuevosCodigosGenerados < $cantidadCodigos && $intentos < $intentosMaximos) {
        $nuevoCodigo = generarCodigoUnico();
        $intentos++;

        if (!in_array($nuevoCodigo, $codigos)) {
            // Agregar al array local
            $codigos[] = $nuevoCodigo;
            $nuevosCodigosGenerados++;

            // Insertar en la base de datos
            $stmt = $conn->prepare("INSERT INTO codigos (codigo) VALUES (?)");
            $stmt->execute([$nuevoCodigo]);
        }
    }
}


function generarCodigoUnico()
{
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud = strlen($caracteres);
    $codigo = '';
    for ($i = 0; $i < 5; $i++) {
        $codigo .= $caracteres[rand(0, $longitud - 1)];
    }
    return $codigo;
}

//Resetear visitas
function obtenerVisitas($pdo)
{
    $sql = "SELECT valor FROM config WHERE ajuste = 'visitas'";
    $stmt = $pdo->query($sql);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['valor'];
    } else {
        return 0;
    }
}

// Función para resetear las visitas a cero
function resetearVisitas($pdo)
{
    $sql = "UPDATE config SET valor = 0 WHERE ajuste = 'visitas'";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute();
}

// Procesar el formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resetear'])) {
    $conn = connectDB();
    if (resetearVisitas($conn)) {
        header("Location: ./index.php?page=tablas");
        exit;
    } else {
        echo "<p>Error al resetear las visitas.</p>";
    }
}


