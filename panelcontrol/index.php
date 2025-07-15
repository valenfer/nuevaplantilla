<?php


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./img/maruja.png">
    <title>Configuración de Sorteos</title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="./img/logopequeno.png" alt="Logo MarujaLimón">
            </div>

            <nav class="menu">
                <ul>
                    <li><a href="#" data-page="inicio">Inicio</a></li>
                    <li><a href="#" data-page="imagenes">Imagenes</a></li>
                    <li><a href="#" data-page="camposformulario">Campos Formulario</a></li>
                    <li><a href="#" data-page="configuracion">Empresa/Promoción</a></li>
                    <li><a href="#" data-page="premios">Premios</a></li>
                    <li><a href="#" data-page="tablas">Tablas</a></li>
                    <li style="color: white;">|</li>
                    <li><a href="#" data-page="estado">Estado</a></li>
                    <li><a href="#" data-page="canjear">Canjear</a></li>
                </ul>
            </nav>

        </div>
    </header>

    <main id="content">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'inicio';
        switch ($page) {
            case 'configuracion':
                include 'panelcontrol.php';
                break;
                case 'empresa':
                    include 'empresa.php';
                    break;
            case 'camposformulario':
                include 'camposformulario.php';
                break;
            case 'imagenes':
                include 'imagenes.php';
                break;
            case 'tablas':
                include 'configbd.php';
                break;
            case 'premios':
                include 'premios.php';
                break;
            case 'estado':
                include 'estado.php';
                break;
            case 'canjear':
                include 'canjear.php';
                break;
            case 'inicio':
            default:
                include 'inicio.php';
                break;
        }
        ?>
    </main>

    <script src="./js/index.js"></script>
</body>

</html>