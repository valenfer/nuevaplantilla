<?php
session_start();
require_once("./php/config.php");
// Resetear el mensaje de subida al cargar la página
if (!empty($_SESSION['archivoTicket']) && $_SESSION['archivoTicket'] !== "No recogido") {
  try {
    // Conectar a la base de datos
    $pdo = connectDB();

    // Preparar la consulta para comprobar si el archivo ya está en la tabla
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM participantes WHERE imagen_subida = :imagen");
    $stmt->execute([':imagen' => $_SESSION['archivoTicket']]);

    // Verificar si el archivo ya existe
    if ($stmt->fetchColumn() > 0) {
      // Si ya existe, reiniciar las variables de sesión
      $_SESSION['mensaje_subida'] = "";
      $_SESSION['archivoTicket'] = "No recogido";
    }
  } catch (PDOException $e) {
    // Manejar errores de la base de datos
    error_log("Error al comprobar imagen_subida: " . $e->getMessage());
  }
}
require_once("./php/config.php");
require_once("./php/conexion.php");
$repetirTel = 'repetir="no"'; //Cambiar a si o no este valor
if ($variasParticipaciones == 1) {
  $repetirTel = 'repetir="si"';
}
insert("update config set valor = valor+1 where id = 9");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Ejecutar la consulta y decodificar el valor
$c = consulta("SELECT valor FROM config WHERE id = 27");
$campos = json_decode($c[0]["valor"], true); // Array asociativo
//Cargamos los valores de la definicion de los campos auxiliares
// Leer el archivo camposauxiliares.txt
$archivo = './panelcontrol/camposauxiliares.txt';

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


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $carpeta_destino = "tickets/"; // Ajusta la ruta si es necesario
  $nombre_archivo = uniqid() . "_" . basename($_FILES["ticketimg"]["name"]);
  $ruta_archivo = $carpeta_destino . $nombre_archivo;
  $_SESSION["requiereFotoTicket"] = 1;
  if (move_uploaded_file($_FILES["ticketimg"]["tmp_name"], $ruta_archivo)) {
    $_SESSION["archivoTicket"] = $nombre_archivo;
    $_SESSION["mensaje_subida"] = "El archivo se ha subido correctamente."; // Guardar mensaje de éxito
  } else {
    $_SESSION["mensaje_subida"] = "Error al subir el archivo."; // Guardar mensaje de error
  }
  $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'];
  $uri = $_SERVER['REQUEST_URI'];
  $urlActual = $protocolo . '://' . $host . $uri;

  header("Location: " . $urlActual); // Redirigir de vuelta al formulario
  exit(); // Asegurar que el script se detenga después de la redirección
}
?>
<script type="text/javascript">
  var linkFromPHP = <?php echo json_encode($link); ?>;
</script>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <link rel="icon" type="image/png" href="img/favicon.png">
  <meta name="theme-color" content="<?php echo $color ?>">
  <link rel="stylesheet" href="dash/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/intlTelInput.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no maximum-scale=1" user-scalable="no">
  <title><?php echo $nombrePromo; ?></title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/animate.css">
  <style type="text/css">
    .btn-info {
      background-color: <?php echo $color ?> !important;
    }

    .border-color {
      border-color: <?php echo $color ?> !important;
    }

    .check::before {
      border: 1px solid <?php echo $color ?> !important;
    }

    .cabecera {
      /* background-color:<?php echo $color ?> !important;*/
      background-color: #ebe5d3 !important;
    }

    #codigo {
      font-weight: bold;
      text-transform: uppercase;
      color: <?php echo $color ?> !important;
    }

    .color-p {
      color: <?php echo $color ?> !important;
    }

    .ticketUp {
      display: flex;
      /* Usamos flexbox para alinear los elementos en línea */
      align-items: center;
      /* Alinea los elementos verticalmente al centro */
    }

    .input[type="file"] {
      margin-right: 20px;
      /* Agrega un espacio entre el input file y el botón */
    }

    #btnuploadTicket {
      margin-left: 10px;
      padding: 10px 20px;
      /* Ajusta el padding según tus preferencias */
      background-color: <?php echo $color ?>;
      /* Color de fondo del botón */
      color: white;
      /* Color del texto */
      border: none;
      border-radius: 5px;
      /* Bordes redondeados */
      box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
      /* Sombra para el efecto 3D */
      cursor: pointer;
      /* Cambia el cursor a una mano al pasar por encima */
      transition: transform 0.2s ease-in-out;
      /* Transición suave para el efecto de clic */
      width: 30%;
    }

    #btnuploadTicket:hover {
      transform: translateY(-2px);
      /* Eleva el botón ligeramente al pasar el cursor */
      box-shadow: 3px 3px 7px rgba(0, 0, 0, 0.4);
      /* Sombra más intensa al pasar el cursor */
    }

    #btnuploadTicket:active {
      transform: translateY(1px);
      /* Baja el botón ligeramente al hacer clic */
      box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
      /* Sombra más suave al hacer clic */
    }

    .mensaje-exito {
      color: blue;
    }

    .mensaje-error {
      color: red;
    }
/* Styles for the ticket upload form */
.ticketUp {
  display: flex;
  align-items: center;
  margin-bottom: 1rem; /* Add some space below the form */
}

#customFileLabel {
  flex-grow: 1; /* Allows the label to take available space */
  margin-right: 10px; /* Space between label and button on desktop */
  /* Ensure it behaves like a block for consistent height and padding */
  display: inline-block; 
  line-height: 1.5; /* Adjust as needed to match input field height */
  padding: .75rem 1.25rem; /* Match Bootstrap's form-control-lg padding */
  cursor: pointer;
}

#btnuploadTicket {
  /* Existing styles for the button are mostly fine */
  /* Adjust width if it was previously set to a percentage that assumes side-by-side layout */
  flex-shrink: 0; /* Prevent button from shrinking if label text is long */
}

/* Media Query for Mobile Devices */
@media (max-width: 767px) {
  .ticketUp {
    flex-direction: column; /* Stack elements vertically */
    align-items: stretch;   /* Make elements take full width */
  }

  #customFileLabel {
    margin-right: 0;      /* Remove right margin */
    margin-bottom: 10px;  /* Add space below the label */
    width: 100%;          /* Make label take full width */
  }

  #btnuploadTicket {
    margin-left: 0;       /* Remove left margin if any was specific to desktop */
    width: 100%;          /* Make button take full width */
  }
}
	
</style>
</head>

<body>
  <!-- Modal -->
  <div class="modal fade" id="modalTerminos" tabindex="-1" role="dialog" aria-labelledby="modalTerminosTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTerminosTitle">Bases legales de la promoción</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php echo $basesLegales; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cerrar</button>

        </div>
      </div>
    </div>
  </div>

  <img src="img/globo1.png" class="g1 d-none">
  <img src="img/globo2.png" class="g2 d-none">
  <img src="img/globo3.png" class="g3 d-none">

  <section class="cabecera">
    <img src="img/cabecera.png" class="img-fluid">
  </section>

  <?php

  if ($estado) {
    if (!promoAbierta()) {

  ?>

      <div class="telefono contenido text-center mb-3">

        <div class="row">
          <div class="col-12">

            <?php if ($subirImagen == 1) { ?>
              <h3>SUBE FOTO DEL TICKET</h3>
              <form class="ticketUp" action="" method="post" enctype="multipart/form-data">
                <!-- Etiqueta personalizada para mostrar el texto -->
                <label class="form-control form-control-lg border border-color campo" id="customFileLabel" for="ticketimg">
                  <?php echo isset($_SESSION['archivoTicket']) && $_SESSION['archivoTicket'] !== "No recogido" ? $_SESSION['archivoTicket'] : "Pincha aquí"; ?>
                </label>
                <!-- Input de tipo file oculto -->
                <input class="form-control form-control-lg border border-color campo" type="file" name="ticketimg" id="ticketimg" style="display: none;">
                <!-- Botón para subir el archivo -->
                <input class="form-control form-control-lg border border-color campo btnSubitTicket" id="btnuploadTicket" type="submit" value="Subir">
              </form>

              <script>
                // Cambiar el texto del label cuando se selecciona un archivo
                document.getElementById('ticketimg').addEventListener('change', function(event) {
                  const fileName = event.target.files[0] ? event.target.files[0].name : "Sube archivo con foto del ticket";
                  document.getElementById('customFileLabel').textContent = fileName;
                });
              </script>

              <?php

              if (isset($_SESSION["mensaje_subida"])) {
                $clase_mensaje = strpos($_SESSION["mensaje_subida"], "correctamente") !== false ? "mensaje-exito" : "mensaje-error";
                echo "<p class='mensaje-subida " . $clase_mensaje . "'>" . $_SESSION["mensaje_subida"] . "</p>";
              }

              ?>
            <?php } else {
              $_SESSION["archivoTicket"] = "No recogido";
              $_SESSION["mensaje_subida"] = "";
            }
            ?>

            <?php if ($codigo) { ?>
              <h3>INTRODUCE TU CÓDIGO</h3>
              <input type="text" class="form-control form-control-lg border border-color campo" id="codigo" placeholder="Código" maxlength="5">
              <div class="invalid-feedback cod">
                Introduce un código para continuar
              </div>

            <?php } ?>

            <h3 class="mt-5 ">INTRODUCE TU TELÉFONO</h3>
            <input type="number" class="form-control form-control-lg border border-color campo mb-5" <?php echo $repetirTel; ?> placeholder="TELÉFONO" id="phone">
            <div class="invalid-feedback tel">
              Introduce un teléfono para continuar
            </div>
            <?php
            $validarTicketImagen = 0;
            if ($subirImagen == 1) {
              if (isset($_SESSION['mensaje_subida']) && ($_SESSION['mensaje_subida'] === "El archivo se ha subido correctamente.")) {
                $validarTicketImagen = 1;
              }
            } else {
              $validarTicketImagen = 1;
            }
            $msg = isset($_SESSION['mensaje_subida']) ? $_SESSION['mensaje_subida'] : "No hay mensaje";
            ?>
            <script>
              var msg = <?php echo json_encode($msg); ?>;
              var validarImgTicket = <?php echo $validarTicketImagen ?>;
              console.log("validarTicket: " + validarImgTicket);
              console.log("mensaje: " + msg);
              console.log("subirImagen: " + <?php echo $subirImagen ?>);
            </script>

            <button class="btn btn-info btn-block campo mt-5" id="btn-siguiente">CONTINUAR</button>
          </div>

        </div>
      </div>

      <!--ZONA FORMULARIO-->
      <div id="formulario" class="formulario contenido d-none">
        <span class="text-center">
          <h3>¡Introduce tus datos y participa!</h3>
        </span>
        <div class="row">
          <div class="col-12">


            <?php
            // Generar el HTML
            $html = '';
            foreach ($campos as $clave => $valores) {
              $tipo = $valores[0]; // "text" o "number"
              $visible = $valores[1]; // 1 o 0
              $id = $clave; // Usar la clave como id y name
              $name = $clave;
              $placeholder = ($clave === "codp") ? "Codigo postal" : ucfirst($clave);
              //Condicionamos el placeholder si son campos auxiliares para mostrar la definicion guardada
              if ($clave === "auxiliar1") $placeholder = $camposAuxiliares['inputAuxname1'];
              if ($clave === "auxiliar2") $placeholder = $camposAuxiliares['inputAuxname2'];
              if ($clave === "auxiliar3") $placeholder = $camposAuxiliares['inputAuxname3'];
              if ($clave === "auxiliar4") $placeholder = $camposAuxiliares['inputAuxname4'];
              if ($visible == 1) {
                // Input visible con placeholder
                $html .= "<div>\n";
                $html .= "    <input type=\"$tipo\" class=\"form-control form-control-lg border border-color campo\" id=\"$id\" name=\"$name\" placeholder=\"$placeholder\">\n";
                $html .= "    <div class=\"invalid-feedback\">\n";
                $html .= "        Introduce un $clave válido\n";
                $html .= "    </div>\n";
                $html .= "</div>\n";
              } else {


                $defaultValue = ($tipo === 'text') ? "$clave no recogida" : 0;
                $html .= "<input type=\"hidden\" class=\"form-control form-control-lg border border-color campo\" id=\"$id\" name=\"$name\" value=\"$defaultValue\">\n";
              }
            }

            // Imprimir el HTML
            echo $html;
            ?>

            <!-- Campo oculto para el nombre del archivo del ticket subido -->
            <script>
              console.log("<?php echo $_SESSION['archivoTicket'] ?>")
            </script>
            <input type="hidden" id="ticketImagen" name="ticketImagen" value="<?php echo $_SESSION["archivoTicket"] ?>">

            <div class="custom-control custom-checkbox mb-2 mt-2">
              <input type="checkbox" class="custom-control-input" id="check1">
              <label class="custom-control-label check" for="check1"><span style="opacity:0%;">.</span><small style="font-size:11px;"> Al participar aceptas las <a href="<?php echo $linkBasesLegales ?>" target="_blank">bases legales de la promoción </a> y la <a href="<?php echo $linkTerminosUso ?>" target="_blank">Política de Privacidad</a></br><?php echo $nombreEmpresa ?> garantiza la protección y confidencialidad de los datos personales, de cualquier tipo que nos proporcionen nuestros clientes de acuerdo con lo dispuesto en la Ley Orgánica 15/1999, de 13 de Diciembre de Protección de Datos de Carácter Personal.</small></label>
            </div>

            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="check2">
              <label class="custom-control-label check" for="check2"><span style="opacity:0%;">.</span><small style="font-size:11px;"> Acepto los términos de uso y quiero recibir ofertas especiales, información de productos y servicios ofertados por <?php echo $nombreEmpresa ?></label></small>
            </div>

            <div id="error-checks" class="text-danger d-none">
              Es obligatorio aceptar todos los términos y condiciones.
            </div>

            <button class="btn btn-info btn-block campo mb-2" id="btn-participar">¡PARTICIPAR!</button>
          </div>

        </div>
      </div>


      <!--ZONA BUSCANDO-->
      <div class="buscando d-none">
        <div class="zona-regalo text-center">
          <img src="img/registrando.svg" class="regalo">
          <div class="lds-css ng-scope d-none lupa">
            <div style="width:100%;height:100%" class="lds-magnify">
              <div>
                <div>
                  <div></div>
                  <div></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="zona-premio contenido d-none text-center">
        <div class="ganador d-none">
          <h1 style="font-size:2rem;">¡ENHORABUENA!</h1>
          <h4>Has ganado:</h4>
          <h4><span class="text-danger" id="n-premio"></span></h4>
          <img width="300px" id="img-premio" src="">
          <?php if ($codigo) { ?>
            <p class="color-p">Código de canjeo: <span class="font-weight-bold" id="cod-usado"></span></p>
          <?php } ?>
          <!--
          <p class="text-primary">Para reclamar tu premio, acércate a nuestro centro junto al código ganador que te hemos mandado al correo electrónico.</br><small class="text-primary">Es indispensable conservar el correo con el código hasta la entrega del regalo</small></p>
          -->

        </div>
        <div class="perdedor d-none">
          <h1>¡Tu cupón no ha sido premiado!</h1>
          <h4>Tu cupón no ha sido premiado hoy pero aún puedes ganar otro día de nuestra promoción<br>¡Gracias por participar!</h4>

          <img width="200px" src="./img/sad.png" class="animated shake">
        </div>
        <button class="btn mt-4 mb-2 btn-info btn-block rounded" id="btn-salir">SALIR</button>
      </div>
  <?php

    } else {
      echo '<div class="text-center mt-3"><img class="animated swing" id="reloj" style="width:150px;" src="img/time.png"><h4 class="mt-5">Prueba suerte de</br>09:00 a 21:30 en días laborables.</h4></br><small>*No disponible Domingos y Festivos.</small></div>';
      echo '<script type="text/javascript">
            
            setInterval(function(){
              $("#reloj").removeClass("swing");
              setTimeout(function(){
                  $("#reloj").addClass("swing");
                },1000);
              },3000);
            

        </script>';
    }
  } else {
    $fecha_actual = date('Y-m-d'); // Obtiene la fecha actual en formato YYYY-MM-DD

    if ($fecha_actual > $fechaFin) {
      echo '<div class="text-center mt-3"><h1>Esta promoción ya ha finalizado</h1></div>';
    }
    if ($fecha_actual < $fechaInicio) {
      echo '<div class="text-center mt-3"><h1>Esta promoción aún no ha comenzado</h1></div>';
    }
  }

  ?>

  <section class="footer">
    <img src="img/footer.png" class="img-fluid">

  </section>

  <section id="carga" style="background-color:<?php echo $color; ?>;">

    <div class="pl-spinner">
      <div class="pl-spinner-bubble"></div>
      <div class="pl-spinner-bubble2"></div>
    </div>
  </section>



  <script
    src="https://code.jquery.com/jquery-3.4.1.js"

    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="js/intlTelInput-jquery.js"></script>
  <script src="js/utils.js"></script>

  <script type="text/javascript" src="js/general.js"></script>


</body>

</html>