<?php 
function obtenerRutaImagenPremio($id_premio)
{
    echo "<script>alert('dentro de obtener ruta');</script>";
    // Establece la conexión a la base de datos usando tu función connectDB()
    $conn = connectDB();

    // Consulta la base de datos para obtener la ruta de la imagen
    $sql = "SELECT img FROM premios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id_premio, PDO::PARAM_INT); // Bind el parametro para prevenir inyecciones sql
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $mensaje = 'Imagen capturada de la tabla: ' . $resultado['img'];
        echo "<script>console.log(" . json_encode($mensaje) . ");</script>";

        return $resultado['img'];
    } else {
        return "";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'obtener_imagen') {
    $id_premio = $_GET['id'];
    $rutaImagen = obtenerRutaImagenPremio($id_premio);
    echo $rutaImagen;
}