<?php
require_once "./funciones.php";

// Definir el directorio al inicio
$dir = "../img/premios/";

// Manejo de subida de imágenes
if (isset($_POST['upload']) && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $filename = $file['name'];
    $target = $dir . basename($filename);
    move_uploaded_file($file['tmp_name'], $target);
    header("Location: index.php?page=imagenes#imagenesPremios");
    exit();
}

// Manejo de borrado de todas las imágenes
if (isset($_POST['delete_all'])) {
    $images = glob($dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    foreach ($images as $image) {
        unlink($image);
    }
    header("Location: index.php?page=imagenes#imagenesPremios");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Configuración de Imágenes</title>
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
            color: #ff5722;
            /* Naranja vibrante */
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

        p.nota strong {
            background: yellow;
            color: #ff9800;
            font-weight: bold;
            text-decoration: underline;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 1.1em;
            /* Añadido para mayor énfasis */
            box-shadow: 0 1px 6px rgba(255, 152, 0, 0.15);
        }

        p.tc {
            text-align: center;
            font-size: 1em;
            color: #888;
            margin: 10px 0;
        }

        /* Contenedor de entrada */
        .input-container {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 15px 0;
        }

        .input-container label {
            font-size: 1.2em;
            color: #ff9800;
            font-weight: bold;
        }

        .input-container input[type="file"] {
            font-size: 1em;
            padding: 5px;
        }

        .input-container button {
            background-color: #ff5722;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .input-container button:hover {
            background-color: #e64a19;
        }

        /* Vista previa de imágenes */
        .imagenMuestra {
            text-align: center;
            margin: 20px 0;
        }

        .imagenMuestra img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Sección de premios */
        #imagenesPremios {
            margin: 20px 0;
        }

        .upload-form {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .upload-form input[type="file"] {
            font-size: 1em;
        }

        .upload-form input[type="submit"] {
            background-color: #ff5722;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .upload-form input[type="submit"]:hover {
            background-color: #e64a19;
        }

        .upload-form input[name="delete_all"] {
            background-color: #d32f2f;
            /* Rojo para borrar */
        }

        .upload-form input[name="delete_all"]:hover {
            background-color: #b71c1c;
        }

        .carousel {
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            background-color: #fafafa;
            border-radius: 8px;
        }

        .carousel-container {
            display: inline-flex;
            gap: 15px;
        }

        .carousel-item {
            display: inline-block;
        }

        .carousel-item img {
            max-height: 150px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
    <div class="seccion" id="imagenes">
        <br>
        <h1 class="tituloseccion">Imágenes</h1>
        <br>
        <p class="nota">En este apartado subiremos las imágenes que se utilizarán en la aplicación, cabecera, logotipo, favicon, imágenes que se utilizarán para los premios, y las imágenes de fondo tanto de la cabecera como del pie</p>
        <hr>
        <br>
        <p class="nota">El <strong><u>logotipo</u></strong> aparecerá en el email que se envía al participante</p>
        <br>
        <!-- Carga del logo-->
        <div class="input-container">
            <label for="logoSubida">Sube la imagen del logo:</label>
            <input type="file" id="logoSubida" name="logoSubida" accept="image/*">
            <button type="button" onclick="subirLogo()">Subir</button>
        </div>

        <div id="imagenLogo" class="imagenMuestra">
            <img src="../img/logo.png?nocache=<?php echo time(); ?>" alt="No hay imagen cargada">
        </div>
        <br>
        <p class="tc">Logo cargado actualmente</p>
        <br>
        <hr>
        <br>
        <!-- Carga del favicon ---->
        <br>
        <p class="nota">El <strong><u>favicon</u></strong> aparecerá en la pestaña del navegador junto al título de la promoción</p>
        <br>
        <div class="input-container">
            <label for="inputFavicon">Sube el favicon:</label>
            <input type="file" id="inputFavicon" name="favicon" accept="image/*">
            <button type="button" onclick="subirFavicon()">Subir</button>
        </div>
        <div id="faviconPreview" class="imagenMuestra">
            <img src="../img/favicon.png?nocache=<?php echo time(); ?>" alt="No hay imagen cargada" style="max-width: 64px; max-height: 64px;" alt="No hay imagen cargada">
        </div>
        <br>
        <p class="tc">Favicon cargado actualmente</p>
        <br>
        <hr>
        <!-- Carga del footer-->
        <br>
        <p class="nota">El <strong><u>footer</u></strong> aparecerá en el pie de la página</p>
        <br>
        <div class="input-container">
            <label for="footerSubida">Sube la imagen del footer:</label>
            <input type="file" id="footerSubida" name="footerSubida" accept="image/*">
            <button type="button" onclick="subirFooter()">Subir</button>
        </div>
        <div id="imagenFooter" class="imagenMuestra">
            <img src="../img/footer.png?nocache=<?php echo time(); ?>" alt="No hay imagen cargada">
        </div>
        <br>
        <p class="tc">Footer cargado actualmente</p>
        <br>
        <hr>
        <!-- Carga fondo del footer-->
        <br>
        <p class="nota">El <strong><u>fondo del footer</u></strong> aparecerá como fondo en el pie de la página</p>
        <br>
        <div class="input-container">
            <label for="inputFondoFooter">Sube la imagen del fondo del footer:</label>
            <input type="file" id="inputFondoFooter" name="inputFondoFooter" accept="image/*">
            <button type="button" onclick="subirFondoFooter()">Subir</button>
        </div>
        <div id="fondoFooterPreview" class="imagenMuestra">
            <img src="../img/fondo-footer.png?nocache=<?php echo time(); ?>" alt="No hay imagen cargada">
        </div>
        <br>
        <p class="tc">Fondo del footer cargado actualmente</p>
        <br>
        <hr>
        <!-- Subir archivo de cabecera -->
        <br>
        <p class="nota">La <strong><u>cabecera</u></strong> aparecerá como banner en la parte superior</p>
        <br>
        <div class="input-container">
            <label for="cabeceraSubida">Sube la imagen de la cabecera:</label>
            <input type="file" id="cabeceraSubida" name="cabeceraSubida" accept="image/*">
            <button type="button" onclick="subirCabecera()">Subir</button>
        </div>

        <div id="imagenCabecera" class="imagenMuestra">
            <img src="../img/cabecera.png?nocache=<?php echo time(); ?>" alt="No hay imagen cargada">
        </div>
        <br>
        <p class="tc">Cabecera cargada actualmente</p>
        <br>
        <hr>
        <!-- Carga fondo de cabecera-->
        <br>
        <p class="nota">El <strong><u>fondo de la cabecera</u></strong> aparecerá como fondo en la parte superior</p>
        <br>
        <div class="input-container">
            <label for="inputFondoCabecera">Sube la imagen del fondo de la cabecera:</label>
            <input type="file" id="inputFondoCabecera" name="inputFondoCabecera" accept="image/*">
            <button type="button" onclick="subirFondoCabecera()">Subir</button>
        </div>
        <div id="fondoCabeceraPreview" class="imagenMuestra">
            <img src="../img/bg.png?nocache=<?php echo time(); ?>" alt="No hay imagen cargada">
        </div>
        <br>
        <p class="tc">Fondo de la cabecera cargado actualmente</p>
        <br>
        <hr>
        <!-- Imagenes para os premios -->
        <br>
        <p class="nota">Sube las <strong><u>imágenes de los premios</u></strong></p>
        <br>
        <div id="imagenesPremios">
            <div class="upload-form">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="image" accept="image/*" required>
                    <input type="submit" name="upload" value="Subir Imagen">
                </form>
            </div>
            <div class="carousel">
                <div class="carousel-container" id="carousel">
                    <?php
                    $images = glob($dir . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);

                    if (empty($images)) {
                        echo '<p>No hay imágenes cargadas</p>';
                    } else {
                        foreach ($images as $image) {
                            echo '<div class="carousel-item"><img src="' . $image . '" alt="Premio"></div>';
                        }
                    }
                    ?>
                </div>

            </div>
            <br>
            <div class="upload-form">
                <form action="" method="post">
                    <input type="submit" name="delete_all" value="Borrar Todas">
                </form>
            </div>
            <br>
        </div>
    </div>
    <br>

    <div class="siguiente"><a href="index.php?page=camposformulario">Continúa con los datos que se solicitarán en el formulario -></a></div>
    <br>
    <br>
    <script src="./panelcontrol.js?ver=<?php echo time(); ?>"></script>
</body>

</html>