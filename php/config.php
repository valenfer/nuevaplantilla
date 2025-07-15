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

	$estado = boolval($c[7]["valor"]);

	$fechaFin = $c[9]["valor"];

	$infoLegal = $c[10]["valor"];	

	$basesLegales = $c[11]["valor"];

	$txtMailGanador = $c[12]["valor"];

	$txtMailPerdedor = $c[13]["valor"];

	$asuntoMailPerdedor = $c[14]["valor"];

	$minutos = $c[15]["valor"];

	$horaAp = $c[16]["valor"];
	$horaC = $c[17]["valor"];

	$host = $c[18]["valor"];
	$username = $c[19]["valor"];
	$password = $c[20]["valor"];
	$port = $c[21]["valor"];
	$link = $c[22]["valor"];

	$bdname=$c[23]["valor"];
	$bduser=$c[24]["valor"];
	$bdpass=$c[25]["valor"];
	$campos = json_decode($c[26]["valor"], true);
	$linkBasesLegales=$c[27]["valor"];
	$linkTerminosUso=$c[28]["valor"];
	$fechaInicio = $c[29]["valor"];
	$subirImagen = $c[30]["valor"];
	$d = consulta ("select CURRENT_DATE as fecha");

	if(($d[0]["fecha"]>=$fechaFin) || ($d[0]["fecha"]<=$fechaInicio)){
		insert("update config set valor=0 where ajuste='estado'");

		$estado = 0;
	} else {
		$estado = 1;
		insert("update config set valor=1 where ajuste='estado'");
	}

?>