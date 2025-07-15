<?php
require "../php/conexion.php";
require_once "../php/config.php";
echo "<script>console.log($campos)</script>";
$conn = connectDB();

// Recoger los valores del formulario
$camposPost = isset($_POST['campos']) ? $_POST['campos'] : [];

// Obtener los valores originales de config para mantener los tipos y todas las claves
$consulta = consulta("SELECT valor FROM config WHERE id = 27");
$camposOriginales = json_decode($consulta[0]["valor"], true);
echo "<script>console.log('Campos originnales:'+$campos)</script>";

// Construir el array actualizado con todas las claves
$camposActualizados = [];
foreach ($camposOriginales as $clave => $valores) {
    $tipo = $valores[0]; // Mantener el tipo original ("text" o "number")
    // Si la clave está en $_POST['campos'] y es "1", asignar 1; si no, asignar 0
    $nuevoValor = isset($camposPost[$clave]) && $camposPost[$clave] === "1" ? 1 : 0;
    $camposActualizados[$clave] = [$tipo, $nuevoValor];
}

// Guardamos archivo con la definicion d elos campos auxiliares
// Array con los nombres de los campos que esperamos
$camposAuxiliares = [
    'inputAuxname1',
    'inputAuxname2',
    'inputAuxname3',
    'inputAuxname4'
];

// Contenido que se escribirá en el archivo
$contenido = '';

// Recorremos cada campo
foreach ($camposAuxiliares as $campo) {
    // Verificamos si el campo existe y no está vacío
    if (isset($_POST[$campo]) && $_POST[$campo] !== '') {
        $valor = trim($_POST[$campo]); // Limpiamos espacios
        $contenido .= "$campo=$valor\n"; // Añadimos al contenido con salto de línea
    }else{
        $valor = ""; // Limpiamos espacios
        $contenido .= "$campo=$valor\n"; // Añadimos al contenido con salto de línea
    }
}

// Nombre del archivo (puedes personalizarlo)
$nombreArchivo = 'camposauxiliares.txt';

// Guardamos el contenido en el archivo
if (!empty($contenido)) {
    file_put_contents($nombreArchivo, $contenido);
    echo "Archivo creado exitosamente: $nombreArchivo";
} else {
    echo "No se ingresaron datos válidos";
}

// Convertir a JSON para almacenar
$jsonCampos = json_encode($camposActualizados);
echo "<script>console.log('Campos actualizados: '+$jsoncampos)</script>";

// Actualizar la tabla config (id = 27)
$conn = connectDB();
$sql = "UPDATE config SET valor = :valor WHERE id = 27";
$stmt = $conn->prepare($sql);
$stmt->execute([':valor' => $jsonCampos]);

header("Location: ./index.php?page=camposformulario");
exit(); // Asegura que el script termine después de la redirecci