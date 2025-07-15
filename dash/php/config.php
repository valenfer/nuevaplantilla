<?php
	require_once 'conexion.php';
	$c = consulta("select * from config");


	$nombrePromo = $c[0]["valor"];

	$codigo = boolval($c[1]["valor"]);

	$color = $c[2]["valor"];

	$nombreEmpresa = $c[3]["valor"];

	$variasParticipaciones = boolval($c[4]["valor"]);

	$asuntoMail = $c[5]["valor"];	

	$mailEmpresa =  $c[6]["valor"];	

	$valEstado = boolval($c[7]["valor"]);

	$fechaFin = $c[9]["valor"];

	$infoLegal = $c[10]["valor"];

	$basesLegales = $c[11]["valor"];

	$txtMailGanador = $c[12]["valor"];

	$txtMailPerdedor = $c[13]["valor"];

	$asuntoMailPerdedor = $c[14]["valor"];

	$minutos = $c[15]["valor"];

	$horaAp = $c[16]["valor"];
	$horaC = $c[17]["valor"];


?>