<?php 
		
	

	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require_once __DIR__ . '/PHPMailer.php';
	require_once __DIR__ . '/SMTP.php';
	require_once __DIR__ . '/Exception.php';

	require_once("config.php");

	$css ='body{
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
		   			color: <?php echo $color; ?>;
		   			font-weight:300;
		   			text-transform:uppercase;
		   		}

		   		.cabecera{
		   			width:100%;
		   			
		   			background-color:<?php echo $color; ?>;
		   		
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

	function enviarMailPerdedor($destino, $premio, $asunto, $color, $empresa, $emisor){ // Parameters $emisor and $empresa for setFrom are now overridden
		global $css;
		global $infoLegal;
		global $txtMailPerdedor;
		$mail = new PHPMailer(TRUE);
		try {
		   
		   $mail->CharSet = 'UTF-8';
		   /* Add a recipient. */
		   $mail->addAddress($destino, 'Participante del sorteo');
		   $mail->IsHTML(true);
		   /* Set the subject. */
		   $mail->Subject = $asunto;
		  // $mail->AddEmbeddedImage('../img/cabecera.png', 'logo');
		 //  $mail->AddEmbeddedImage('../img/fondo-cabecera.png', 'fondo');
		 //  $mail->AddEmbeddedImage('../img/logomarca.png', 'logom');
		   /* Set the mail message body. */
		   $mail->Body = '<html><head>
		   	<style>
		   		'.$css.'

		   	</style>

		   </head><body>
		   		<div class="cuerpo">
		   			<div class="cabecera" style="background-image:url(../img/bg.png)">
		   			    <center><img style="max-width: 250px;height: auto;" src="../img/cabecera.png?nocache=<?php echo time(); ?>"></center>
		   			</div>
		   			<div class="contenido">
		   				'.$txtMailPerdedor.'
		   				<center>
		   					<img width="90%" style="margin-top:15px" src="../img/logo-aleste.png">
		   				</center> 
		   			</div>
		   		</div>
		   		<div class="info-legal">
		   			'.$infoLegal.'
		   		</div>
		   	</body>

		   ';

		   // NEW SMTP Configuration
		   $mail->SMTPDebug = SMTP::DEBUG_OFF;
		   $mail->isSMTP();
		   $mail->Host       = 'galadeldeporteutrera.es';
		   $mail->SMTPAuth   = true;
		   $mail->Username   = 'info@galadeldeporteutrera.es';
		   $mail->Password   = 'Maruja2025!'; // WARNING: Hardcoded password!
		   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		   $mail->Port       = 465;

		   // Updated setFrom
		   $mail->setFrom('info@galadeldeporteutrera.es', 'Gala del Deporte Utrera');
		   
		   /* Remove old SMTP settings and smtpConnect call */
		   // $mail->Host = 'dns111177.phdns6.es';
		   // $mail->SMTPAuth = true;
		   // $mail->SMTPSecure = true; // This was likely incorrect, SMTPSecure expects a constant like PHPMailer::ENCRYPTION_SMTPS or PHPMailer::ENCRYPTION_STARTTLS
		   // $mail->Username = 'marketing@cashdiazcadenas.com';
		   // $mail->Password = 'YdE2xf13';
		   // $mail->Port = 587;
		   // $mail->smtpConnect([
		   // 	  'ssl' => [
		   // 	        'verify_peer' => false,
		   // 	       'verify_peer_name' => false,
		   // 	        'allow_self_signed' => true
		   // 	         ]
		   // ]);

		   /* Finally send the mail. */
		   $mail->send();
		}
		catch (Exception $e)
		{
		   /* PHPMailer exception. */
		//   echo $e->errorMessage();
		   return "error";
		}
		catch (\Exception $e)
		{
		   /* PHP exception (note the backslash to select the global namespace Exception class). */
		   return $e->getMessage();
		}

	}


	function enviarMail($destino, $premio, $asunto, $color, $empresa, $emisor, $codigo, $texto){ // Parameters $emisor and $empresa for setFrom are now overridden
		global $infoLegal;
		global $css;
		$mail = new PHPMailer(TRUE);
		try {

		   $mail->CharSet = 'UTF-8';
		   /* Add a recipient. */
		   $mail->addAddress($destino, 'Ganador del sorteo');
		   $mail->IsHTML(true);
		   /* Set the subject. */
		   $mail->Subject = $asunto;
	//	   $mail->AddEmbeddedImage('../img/cabecera.png', 'logo');
	//	   $mail->AddEmbeddedImage('../img/fondo-cabecera.png', 'fondo');
	//	   $mail->AddEmbeddedImage('../img/logomarca.png', 'logom');
		   /* Set the mail message body. */
		   $mail->Body = '<html><head>
		   	<style>
		   		'.$css.'

		   	</style>

		   </head><body>
		   		<div class="cuerpo">
		   			<div class="cabecera" style="background-image:url(../img/bg.png)">
		   			    <center><img style="max-width: 250px;height: auto;" src="../img/cabecera.png"></center>
		   			</div>
		   			<div class="contenido">
		   				<h1>¡Enhorabuena!</h1>
		   				<p>Has sido ganador en el sorteo de nuestra promoción</p>
		   				<p>Tu premio es:</p>
		   				<h2 class="premio">'.$premio.'</h2>
		   			
		   				<span style="color:'.$color.'">Código de canjeo: <b>'.$codigo.'</b></span>
		   			
		   				'.$texto.'
		   				<center>
		   					<img width="90%" style="margin-top:15px" src="../img/logomarca.png">
		   				</center>
		   			</div>
		   		</div>
		   		<div class="info-legal">
		   			'.$infoLegal.'
		   		</div>
		   	</body>

		   ';

		   // NEW SMTP Configuration
		   $mail->SMTPDebug = SMTP::DEBUG_OFF;
		   $mail->isSMTP();
		   $mail->Host       = 'galadeldeporteutrera.es';
		   $mail->SMTPAuth   = true;
		   $mail->Username   = 'info@galadeldeporteutrera.es';
		   $mail->Password   = 'Maruja2025!'; // WARNING: Hardcoded password!
		   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		   $mail->Port       = 465;

		   // Updated setFrom
		   $mail->setFrom('info@galadeldeporteutrera.es', 'Gala del Deporte Utrera');

		   /* Remove old SMTP settings and smtpConnect call */
		   // $mail->Host = 'dns111177.phdns6.es';
		   // $mail->SMTPAuth = true;
		   // $mail->SMTPSecure = true;
		   // $mail->Username = 'marketing@cashdiazcadenas.com';
		   // $mail->Password = 'YdE2xf13';
		   // $mail->Port = 587;
		   // $mail->smtpConnect([
		   // 	  'ssl' => [
		   // 	        'verify_peer' => false,
		   // 	       'verify_peer_name' => false,
		   // 	        'allow_self_signed' => true
		   // 	         ]
		   // ]);

		   /* Finally send the mail. */
		   $mail->send();
		}
		catch (Exception $e)
		{
		   /* PHPMailer exception. */
	//	   echo $e->errorMessage();
		   return "error";
		}
		catch (\Exception $e)
		{
		   /* PHP exception (note the backslash to select the global namespace Exception class). */
		   return $e->getMessage();
		}

	}


	function enviarCopia($destino, $premio, $asunto, $ganador, $empresa, $emisor, $codigo){ // Parameters $emisor and $empresa for setFrom are now overridden
		
		$mail = new PHPMailer(TRUE);
		try {

		   $mail->CharSet = 'UTF-8';
		   /* Add a recipient. */
		   $mail->addAddress($destino, $empresa); // Assuming $empresa here is the recipient's name
		   $mail->IsHTML(true);
		   /* Set the subject. */
		   $mail->Subject = $asunto;
		   
		   /* Set the mail message body. */
		   $mail->Body = '<html><body>
		   		<h1>Premio registrado en '.$empresa.'</h1>
		   		<p>Premio: '.$premio.'</p>
		   		<p>Nombre del ganador: '.$ganador.'</p>
		   		<p>Código ganador: '.$codigo.'</p>
		   	</body>

		   ';

		   // NEW SMTP Configuration
		   $mail->SMTPDebug = SMTP::DEBUG_OFF;
		   $mail->isSMTP();
		   $mail->Host       = 'galadeldeporteutrera.es';
		   $mail->SMTPAuth   = true;
		   $mail->Username   = 'info@galadeldeporteutrera.es';
		   $mail->Password   = 'Maruja2025!'; // WARNING: Hardcoded password!
		   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		   $mail->Port       = 465;

		   // Updated setFrom
		   $mail->setFrom('info@galadeldeporteutrera.es', 'Gala del Deporte Utrera');

		   /* Remove old SMTP settings and smtpConnect call */
		   // $mail->Host = 'dns111177.phdns6.es';
		   // $mail->SMTPAuth = true;
		   // $mail->SMTPSecure = true;
		   // $mail->Username = 'marketing@cashdiazcadenas.com';
		   // $mail->Password = 'YdE2xf13';
		   // $mail->Port = 587;
		   // $mail->smtpConnect([
		   // 	  'ssl' => [
		   // 	        'verify_peer' => false,
		   // 	       'verify_peer_name' => false,
		   // 	        'allow_self_signed' => true
		   // 	         ]
		   // ]);

		   /* Finally send the mail. */
		   $mail->send();
		}
		catch (Exception $e)
		{
		   /* PHPMailer exception. */
	//	   echo $e->errorMessage();
		   return "error";
		}
		catch (\Exception $e)
		{
		   /* PHP exception (note the backslash to select the global namespace Exception class). */
		   return $e->getMessage();
		}

	}


 ?>