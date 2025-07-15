<?php

require_once 'sorteos.php';
require_once 'config.php';
require_once 'mails.php';


if (!empty($_POST)) {
	extract($_POST);
	if (isset($funcion)) {
		if ($funcion == "comprobarNum") {
			comprobarNumero($num);
		}

		/********** Modificación añadida para nuevo sistema de momentos */
		if ($funcion == "comprobarParticipacionDiraria") {
			comprobarParticipacionDiraria($num);
		}
		/************************************************* */

		if ($funcion == "comprobarMail") {
			comprobarMail($correo);
		}

		if ($funcion == "comprobarCodigo") {
			comprobarCodigo($cod);
		}

		if ($funcion == "registrarDatos") {
			registrarDatos($datos);
		}

		if ($funcion == "getDatos") {
			getDatos($telefono);
		}
	}
}


function getDatos($telefono)
{
	echo json_encode(consulta("select * from participantes where telefono='$telefono'"));
}

function promoAbierta()
{
	$c1 = consulta("select valor from config where id = 17 and time(valor)>CURRENT_TIME");
	$c2 = consulta("select valor from config where id = 18 and time(valor)<CURRENT_TIME");
	$valido = true;
	if (empty($c1) && empty($c2)) {
		$valido = false;
	}

	return $valido;
}

function comprobarNumero($num)
{
	$consulta = "select * from participantes where telefono=:num;";
	$miconexion = connectDB();
	$statement = $miconexion->prepare($consulta);
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	$statement->bindParam(':num', $num, PDO::PARAM_STR);
	if (!$statement->execute()) {
		echo "ERROR";
		$miconexion->close();
	}
	$datos = [];
	while ($fila = $statement->fetch()) {
		$datos[] = $fila;
	}
	if (count($datos) != 0) {
		echo "existe";
	} else {
		echo "no-existe";
	}
}

/************************* Añadido para nuevo sistema de momentos****************** */
/** Esta función comprueba si el cliente ya ha participado con el mismo teléfono en el día en curso*/
function comprobarParticipacionDiraria($num)
{
	//Obtenemos fecha actual
	$fecha_actual = date('Y-m-d');
	echo "Fecha actual: " . $fecha_actual . "<br>";

	$consulta = "select * from participantes where telefono=:num ;";
	$miconexion = connectDB();
	$statement = $miconexion->prepare($consulta);
	$statement->setFetchMode(PDO::FETCH_ASSOC);
	$statement->bindParam(':num', $num, PDO::PARAM_STR);
	if (!$statement->execute()) {
		echo "ERROR";
		$miconexion->close();
	}
	$datos = [];
	while ($fila = $statement->fetch()) {
		$datos[] = $fila;
	}
	foreach ($datos as $dato) {
		echo $dato["telefono"] . "<br>" . $dato["fecha_jugada"] . "<br>";
		$date1 = new DateTime($fecha_actual);
		$date2 = new DateTime($dato["fecha_jugada"]);
		// Comparar las fechas
		if ($date1->format('Y-m-d') !== $date2->format('Y-m-d')) {
			echo "diferentes.";
		} else {
			echo "iguales.";
		}
	}
}
/********************************************************************************* */
function comprobarCodigo($cod)
{

	$consulta = consulta("select codigo from codigos where codigo = '$cod';");
	//	echo "select codigo from codigos where codigo = '$cod';";
	if (empty($consulta)) {
		echo "no-existe";
	} else {
		$consulta2 = consulta("select cod_juego from participantes where cod_juego = '$cod';");
		if (!empty($consulta2)) {
			echo "utilizado";
		} else {
			echo "valido";
		}
	}
}

function comprobarCodigo2($cod)
{

	$consulta = consulta("select codigo from codigos where codigo = '$cod';");
	//	echo "select codigo from codigos where codigo = '$cod';";
	if (empty($consulta)) {
		return false;
	} else {
		$consulta2 = consulta("select cod_juego from participantes where cod_juego = '$cod';");
		if (!empty($consulta2)) {
			return false;
		} else {
			return true;
		}
	}
}


//Conexion segun lo recistrado en el panel de control
function connectDB()
{
    try {
        // Leer el archivo de configuración
        $config = parse_ini_file(__DIR__."/db_config.txt");

        if ($config === false) {
            die("Error: No se pudo leer el archivo de configuración db_config.txt");
        }
		$dbname=$config['dbname'];
		$dbaseuser=$config['dbuser'];
		$dbasepass=$config['dbpass'];
		
		/*$opc=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    	$dsn="mysql:host=localhost:3306;dbname=plantilla";
       	$usuario="plantilla";
       	$contrasena="plantilla1234";
       	$base=new PDO($dsn,$usuario,$contrasena,$opc);
		*/


		$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
		$dsn = "mysql:host=localhost:3306;dbname=" . $dbname;
		$usuario = $dbaseuser;
		$contrasena = $dbasepass;
		$base = new PDO($dsn, $usuario, $contrasena, $opc);
		
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }

    return $base;
}

/*Conexión local
function connectDB()
{
    try
    {
        $opc=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn="mysql:host=localhost:3306;dbname=plantilla";
        $usuario="root";
        $contrasena="";
        $base=new PDO($dsn,$usuario,$contrasena,$opc);
    }
    catch (PDOException $e)
    {
        die ("Error".$e->getMessage());
        $resultado=null;
    }
    return $base;
}
*/




function ejecutaConsulta($sql)
{
	//recibe una cadena conteniendo una instruccion SELECT y devuelve un resultset

	$miconexion = connectDB();
	return $miconexion->query($sql);
}

function consulta($sql)
{

	//recibe una cadena conteniendo una instruccion SELECT y devuelve un array con la fila de datos
	$datos = [];
	$resultset = ejecutaConsulta($sql);
	while ($fila = $resultset->fetch(PDO::FETCH_ASSOC)) {
		$datos[] = $fila;
	}
	return $datos;
}


function insert($sql)
{
	/*recibe una cadena conteniendo una instruccion DML, la ejecuta y
		devuelve el nº de filas afectadas por dicha instruccion*/
	$miconexion = connectDB();
	$accion = $miconexion->prepare($sql);
	$accion->execute();
	return $accion->rowCount();
	//return "1";
}

function comprobarMail($correo)
{
	$email = $correo;
	$vmail = new verifyEmail();
	if ($vmail->check($email)) {
		echo 1;
	} elseif ($vmail->isValid($email)) {
		echo 2;
	} else {
		echo 0;
	}
}

function registrarDatos($datos)
{
	$aDatos = json_decode($datos, true);
	extract($aDatos);
	$valido = true;

	//Comantar para juagr sin código
	if (isset($codigo)) {
		if (!comprobarCodigo2($codigo)) {
			$valido = false;
		}
	}
	//
	if ($valido) {
		global $asuntoMail, $color, $nombreEmpresa, $mailEmpresa, $mailEmpresa, $txtMailGanador;
		if (!isset($codigo)) {
			$codigo = "-";
		}
		$sorteo = hacerSorteo();
		if (is_array($sorteo)) {
			$premio = $sorteo[1];
			$idPremio = $sorteo[0];

			// Obtener el nombre de la imagen del premio ANTES de enviar el mail
			$imgPremio = "";
			if ($premio != "-") {
				$miconexion2 = connectDB();
				$stmtImg = $miconexion2->prepare("SELECT img FROM premios WHERE id = :id LIMIT 1");
				$stmtImg->bindParam(':id', $idPremio, PDO::PARAM_INT);
				$stmtImg->execute();
				$imgData = $stmtImg->fetch(PDO::FETCH_ASSOC);
				if ($imgData && isset($imgData['img'])) {
					$imgPremio = $imgData['img'];
				}
			}

			$estadoMail = "no";
			$errorMail = "";
            if ($premio != "-") {
                $mail = enviarMail($email, $premio, $asuntoMail, $color, $nombreEmpresa, $mailEmpresa, $codigo, $txtMailGanador, $idPremio, $imgPremio);
                enviarCopia($mailEmpresa, $premio, "Nuevo ganador en " . $nombreEmpresa, $nombre, $nombreEmpresa, $mailEmpresa, $codigo);
                $estadoMail = (strpos($mail, "error") === 0) ? "no" : "si";
                if (strpos($mail, "error") === 0) {
                    $errorMail = $mail;
                }
                $consulta = "insert into premiados (Nombre, codigo, premio)
                values (:nombre, :codigo, :premio);";
                $miconexion = connectDB();
                $statement = $miconexion->prepare($consulta);
                $statement->bindParam(':codigo', $codigo);
                $statement->bindParam(':premio', $premio);
                $statement->bindParam(':nombre', $nombre);
                $statement->execute();
            } else {
                global $asuntoMailPerdedor;
                $mailP = enviarMailPerdedor($email, $premio, $asuntoMailPerdedor, $color, $nombreEmpresa, $mailEmpresa);
                $estadoMail = (strpos($mailP, "error") === 0) ? "no" : "si";
                if (strpos($mailP, "error") === 0) {
                    $errorMail = $mailP;
                }
            }
            $cod_canjeo = "-";
            $consulta = "insert into participantes (cod_juego, cod_canjeo, premio, email, nombre, telefono, edad, municipio, cod_postal, direccion, fecha_jugada, canjeado, estado_mail, ticket, auxiliar1, auxiliar2, auxiliar3, auxiliar4, imagen_subida)
    values (:codigo, :cod_canjeo, :premio, :email, :nombre, :telefono, :edad, :municipio, :cod_postal, :direccion, CURRENT_TIMESTAMP, :canjeado, :estado_mail, :ticket, :auxiliar1, :auxiliar2, :auxiliar3, :auxiliar4, :imagen_subida)";
            $miconexion = connectDB();
            $statement = $miconexion->prepare($consulta);
            $statement->bindParam(':codigo', $codigo);
            $statement->bindParam(':cod_canjeo', $cod_canjeo);
            $statement->bindParam(':premio', $idPremio);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':nombre', $nombre);
            $statement->bindParam(':telefono', $telefono);
            $statement->bindParam(':edad', $edad);
            $statement->bindParam(':municipio', $municipio);
            $statement->bindParam(':cod_postal', $cod_postal);
            $statement->bindParam(':direccion', $direccion);
            $statement->bindParam(':canjeado', $cod_canjeo);
            $statement->bindParam(':estado_mail', $estadoMail);
            $statement->bindParam(':ticket', $ticket);
            $statement->bindParam(':auxiliar1', $auxiliar1);
            $statement->bindParam(':auxiliar2', $auxiliar2);
            $statement->bindParam(':auxiliar3', $auxiliar3);
            $statement->bindParam(':auxiliar4', $auxiliar4);
            $statement->bindParam(':imagen_subida', $ticketImagen);
            if ($statement->execute()) {
                // Devolver id, nombre, nombre de imagen del premio y error de email si lo hay
                echo json_encode([$idPremio, $premio, $imgPremio, $errorMail]);
            } else {
                echo "error al registrar datos";
            }
		} else {
			echo "error en el sorteo";
		}
	} else {
		echo "error-codigo";
	}
}

function timeStamp($timestamp)
{
	$fechaHora = explode(" ", $timestamp);
	$dato = [];
	$dato["fecha"] = $fechaHora[0];
	$dato["hora"] = $fechaHora[1];
	return $dato;
}
