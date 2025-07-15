<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP; // Added SMTP namespace
use PHPMailer\PHPMailer\Exception;


// Incluimos las clases de PHPMailer.
require_once __DIR__ . '/mailClass/PHPMailer.php';
require_once __DIR__ . '/mailClass/SMTP.php';
require_once __DIR__ . '/mailClass/Exception.php';

require_once("config.php");

// Modified CSS to use placeholders for dynamic color
$css = 'body{
		   			background-color:#ededed;
		   		}
		   		.cuerpo{
		   			max-width:600px;
		   			
		   			margin:0 auto;
		   			background-color:white;
		   			border-radius:10px;
		   			border:1px solid #d9d9d9;
		   			overflow:hidden;

		   		}
		   		h1{
		   			color: %%COLOR%%;
		   			font-weight:300;
		   			text-transform:uppercase;
		   		}

		   		.cabecera{
		   			width:100%;
		   			
		   			background-color:%%COLOR%%;
		   		
		   			padding:20px 0	;
		   			background-size:cover;
		   			background-position:top center;
		   		}
		   		.contenido{
		   			padding:15px;
		   			text-align:center;
		   		}
		   		p{
		   			font-size:14px;
		   		}
		   		.premio{
		   			text-transform:uppercase;

		   		}
		   		.info-legal{
		   			max-width:600px;
		   			color:grey;
		   			margin:0 auto;
		   			font-size:10px;
		   			text-align:center;
		   			margin-top:20px;
		   		}';

function enviarMailPerdedor($destino, $premio, $asunto, $color, $empresa, $emisor)
{
	global $css;
	global $infoLegal;
	global $txtMailPerdedor;
	global $host, $username, $password, $port, $mailEmpresa; // Added global SMTP variables
	$mail = new PHPMailer(TRUE);
	try {
		// Process CSS with dynamic color
		$processed_css = str_replace('%%COLOR%%', $color, $css);
		// Embed images
		$mail->addEmbeddedImage(__DIR__ . '/../img/cabecera.png', 'cabecera_logo_email');
		$mail->addEmbeddedImage(__DIR__ . '/../img/logo.png', 'main_logo_email');
		// Configuraciones del servidor SMTP.
		$mail->SMTPDebug = SMTP::DEBUG_OFF;
		$mail->isSMTP();
		$mail->Host       = $host; 
		$mail->SMTPAuth   = true;               
		$mail->Username   = $username; 
		$mail->Password   = $password;      
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
		$mail->Port       = (int)$port; // Ensure port is an integer             
		// Destinatarios.
		$mail->setFrom($mailEmpresa, $empresa); // Use $mailEmpresa and $empresa parameter
		$mail->addAddress($destino);     
		$mail->CharSet = 'UTF-8'; 
		// Contenido del correo.
		$mail->isHTML(true);                   
		$mail->Subject = $asunto;
		$mail->Body = '<html><head>
	   	<style>
	   		' . $processed_css . '
	   	</style>
	   </head><body>
	   	<div class="cuerpo">
	   		<div class="cabecera" style="background-image:url(../img/bg.png)">
           <img style="width:100%;display:block;" src="cid:cabecera_logo_email">
       </div>
	   		<div class="contenido">
	   			' . $txtMailPerdedor . '
	   			<center>
	   				<img width="50%" style="margin-top:15px" src="cid:main_logo_email">
					<p>Los sentimos, en esta ocasión no has ganado ningún premio.</p>
	   			</center> 
	   		</div>
	   	</div>
	   	<div class="info-legal">
	   		' . $infoLegal . '
	   	</div>
	   </body>';
		$mail->send();
		return "ok";
	} catch (Exception $e) {
		error_log("PHPMailer Error in enviarMailPerdedor: No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo} | Email: {$destino}");
		return "error: " . $mail->ErrorInfo;
	}
}


function enviarMail($destino, $premio, $asunto, $color, $empresa, $emisor, $codigo, $texto, $idPremio = null, $imgPremio = null)
{
	global $infoLegal;
	global $css;
	global $conexion;
	global $host, $username, $password, $port, $mailEmpresa;
	$mail = new PHPMailer(TRUE);
	try {
		$processed_css = str_replace('%%COLOR%%', $color, $css);
		$mail->addEmbeddedImage(__DIR__ . '/../img/cabecera.png', 'cabecera_logo_email');
		$mail->addEmbeddedImage(__DIR__ . '/../img/logo.png', 'main_logo_email');
		$prize_image_html_tag = '';
		$actual_prize_image_filename = '';
		// Usar el nombre de la imagen si se pasa
		if (!empty($imgPremio)) {
			$actual_prize_image_filename = $imgPremio;
		} else if (!empty($idPremio)) {
			$sql = "SELECT img FROM premios WHERE id = :id LIMIT 1";
			$stmt = connectDB()->prepare($sql);
			$stmt->bindParam(':id', $idPremio, PDO::PARAM_INT);
			$stmt->execute();
			$premio_data = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!empty($premio_data) && isset($premio_data['img'])) {
				$actual_prize_image_filename = $premio_data['img'];
			}
		} else if (!empty($premio) && isset($conexion)) {
			$sql = "SELECT img FROM premios WHERE nombre = :nombre LIMIT 1";
			$stmt = connectDB()->prepare($sql);
			$stmt->bindParam(':nombre', $premio, PDO::PARAM_STR);
			$stmt->execute();
			$premio_data = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!empty($premio_data) && isset($premio_data['img'])) {
				$actual_prize_image_filename = $premio_data['img'];
			}
		}
		if (!empty($actual_prize_image_filename)) {
			$prize_image_path = __DIR__ . '/../img/premios/' . $actual_prize_image_filename;
			if (file_exists($prize_image_path)) {
				$mail->addEmbeddedImage($prize_image_path, 'prize_image_email');
				$prize_image_html_tag = '<img src="cid:prize_image_email" alt="Imagen del Premio" style="max-width:100%; height:auto; margin-top:10px; border:1px solid #ddd; padding:5px;">';
			} else {
				error_log("Prize image file not found: " . $prize_image_path . " (Filename from DB: " . $actual_prize_image_filename . ")");
			}
		} else {
			error_log("Prize image filename not found in DB for prize id: " . $idPremio . " o nombre: " . $premio);
		}
		$mail->SMTPDebug = SMTP::DEBUG_OFF;
		$mail->isSMTP();
		$mail->Host       = $host;
		$mail->SMTPAuth   = true;
		$mail->Username   = $username;
		$mail->Password   = $password;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port       = (int)$port;
		$mail->setFrom($mailEmpresa, $empresa);
		$mail->addAddress($destino);
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true);
		$mail->Subject = $asunto;
		$mail->Body = '<html><head>
   	<style>
   		'.$processed_css.'
   	</style>
   </head><body>
   	<div class="cuerpo">
   		<div class="cabecera" style="background-image:url(../img/bg.png)">
           <img style="width:100%;display:block;" src="cid:cabecera_logo_email">
       </div>
   		<div class="contenido">
   			<h1>¡Enhorabuena!</h1>
   			<p>Has sido ganador en el sorteo de nuestra promoción</p>
   			<p>Tu premio es:</p>
   			<h2 class="premio">'.$premio.'</h2>
   			' . $prize_image_html_tag . '
   			<div style="margin-top:10px">
             <span style="color:'.$color.'">Código de canjeo: <b>'.$codigo.'</b></span>
           </div>
   			'.$texto.'
   			<center>
   				<img width="50%" style="margin-top:15px" src="cid:main_logo_email">
   			</center>
   		</div>
   	</div>
   	<div class="info-legal">
   		'.$infoLegal.'
   	</div>
   </body>';
		$mail->send();
		return "ok";
	} catch (Exception $e) {
		error_log("PHPMailer Error in enviarMail: No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo} | Email: {$destino}");
		return "error: " . $mail->ErrorInfo;
	}
}


function enviarCopia($destino, $premio, $asunto, $ganador, $empresa, $emisor, $codigo)
{
	global $host, $username, $password, $port, $mailEmpresa; // Added global SMTP variables
	$mail = new PHPMailer(TRUE);
	try {
		$mail->SMTPDebug = SMTP::DEBUG_OFF;
		$mail->isSMTP();
		$mail->Host       = $host; 
		$mail->SMTPAuth   = true;               
		$mail->Username   = $username; 
		$mail->Password   = $password;      
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
		$mail->Port       = (int)$port; // Ensure port is an integer                
		$mail->setFrom($mailEmpresa, $empresa); // Use $mailEmpresa, kept original name
		$mail->addAddress($destino);     
		$mail->CharSet = 'UTF-8';
		$mail->isHTML(true);                   
		$mail->Subject = $asunto;
		$mail->Body = '<html><body>
	   	<h1>Premio registrado en '.$empresa.'</h1>
	   	<p>Premio: '.$premio.'</p>
	   	<p>Nombre del ganador: '.$ganador.'</p>
	   	<p>Código ganador: '.$codigo.'</p>
	   </body>';
		$mail->send();
		return "ok";
	} catch (Exception $e) {
		error_log("PHPMailer Error in enviarCopia: No se pudo enviar el mensaje. Mailer Error: {$mail->ErrorInfo} | Email: {$destino}");
		return "error: " . $mail->ErrorInfo;
	}
}
