<?php
if (!empty($_POST)) {
	extract($_POST);
	if (isset($funcion)) {
		if ($funcion == "hacerSorteo") {
			hacerSorteo();
		}
	}
}
/**************** Se cambia funcionn para sistema de momentos nuevo *********************
	function hacerSorteo(){
		
		if(consultaMomentos()){
			$premio = sorteoPrincipal();
		} else {
			$premio = sorteoSecundario();
		}

		$pMostrar = [];
		if(!is_numeric("error")){
			$aux = [];
			if($premio!=0){
				$p = consulta("select nombre from premios where id = $premio");
				
				array_push($aux, $premio, $p[0]["nombre"]);

				$pMostrar = $aux;
			} else {
				array_push($aux, "-","-");
				$pMostrar = $aux;
			}
			return $pMostrar;
		} else {
			return "error";
		}	
	}*/

/*********** Codigo nuevo para moemntos desde tabla  premios */
function hacerSorteo()
{
	$premio = sorteoPorMomento();

	$pMostrar = [];
	if (!is_numeric("error")) {
		$aux = [];
		if ($premio != 0) {
			$p = consulta("select nombre from premios where id = $premio");
			array_push($aux, $premio, $p[0]["nombre"]);
			$pMostrar = $aux;
		} else {
			array_push($aux, "-", "-");
			$pMostrar = $aux;
		}
		return $pMostrar;
	} else {
		return "error";
	}
}

function sorteoPorMomento()
{
	$horaActual = date("H:i:s"); //Obtenemos la hora actual
	$fechaActual = date("Y-m-d");
	// Buscar todos los premios pendientes cuya hora sea menor o igual a la actual, de hoy
	$premios = consulta("SELECT * FROM premios WHERE momento <= '$horaActual' AND cantidad > 0 AND fecha = '$fechaActual' ORDER BY nivel DESC, momento DESC LIMIT 1");
	if (!empty($premios)) {
		$premio = $premios[0];
		$jugadoHoy = consulta("SELECT 1 FROM participantes WHERE premio = " . $premio["id"] . " AND fecha_jugada >= '$fechaActual 00:00:00' LIMIT 1");
		if (empty($jugadoHoy)) {
			$insert = "update premios set cantidad=cantidad-1 where id = " . $premio["id"];
			if (insert($insert) != 1) {
				return "error";
			} else {
				return $premio["id"];
			}
		} else {
			return 0;
		}
	} else {
		return 0;
	}
}
/************************************************************************************/


function sorteoPrincipal()
{
	$c = consulta("select * from premios where nivel = 1 and cantidad > 0");
	if (!empty($c)) {
		$max = count($c) - 1;
		$premio =  rand(0, $max);

		$insert = "update premios set cantidad=cantidad-1 where id = " . $c[$premio]["id"];
		if (insert($insert) != 1) {
			return "error";
		} else {

			return $c[$premio]["id"];
		}
	} else {
		return "error";
	}
}

function sorteoSecundario()
{
	global $minutos;
	$premio = 0;

	$hace10min = consulta("select now() - interval " . $minutos . " minute as fh");
	$fecha = timeStamp($hace10min[0]["fh"])["fecha"];
	$hora = timeStamp($hace10min[0]["fh"])["hora"];

	$c = consulta("select p.nombre as nPremio, p.nivel as nivelPremio, pa.fecha_jugada as fecha_jugada from participantes pa inner join premios p on pa.premio = p.id where pa.fecha_jugada >= '$fecha " . $hora . "';");

	if (!empty($c)) {
		return 0;
	} else {

		$num = rand(0, 100);

		//if($num > 50){
		$p = consulta("select * from premios where nivel != 1 and cantidad > 0");
		if (!empty($p)) {
			$max = count($p) - 1;

			$tp = rand(0, $max);
			$insert = "update premios set cantidad=cantidad-1 where id = " . $p[$tp]["id"];
			if (insert($insert) != 1) {
				return "error";
			} else {

				return $p[$tp]["id"];
			}
		} else {
			return "error";
		}


		//	}

	}

	//echo "select p.nombre as nPremio, p.nivel as nivelPremio, pa.fecha_jugada as fecha_jugada from participantes pa inner join premios p on pa.premio = p.id where and pa.fecha_jugada >= '$fecha ".$hora."';";

	//$c = consulta("select * from premios where nivel = 2 and cantidad > 0");

	// 
}


/*$fechaHora = consulta("select CURRENT_TIME as hora, CURRENT_DATE as fecha");

	$premios = consulta("select * from premios;");

	$horaPremio = $premios[0]["hora1"];

	extract($fechaHora[0]);

	echo strtotime($hora);

	echo strtotime($horaPremio);*/


function consultaMomentos()
{
	$premio = false;
	$fyhActual = consulta("select CURRENT_TIMESTAMP as fh");
	$fecha = timeStamp($fyhActual[0]["fh"])["fecha"];
	//	$hora = timeStamp($fyhActual[0]["fh"])["hora"];

	$cPremios = consulta("select * from premios where nivel = 1 and cantidad > 0");

	if (!empty($cPremios)) {

		$momentos = consulta("select * from momentos where nivel = 1 and hora<=CURRENT_TIME and fecha=CURRENT_DATE");

		foreach ($momentos as $dato) {
			extract($dato);
			$c = consulta("select p.nombre as nPremio, p.nivel as nivelPremio, pa.fecha_jugada as fecha_jugada from participantes pa inner join premios p on pa.premio = p.id where p.nivel = 1 and pa.fecha_jugada >= '$fecha " . $hora . "';");

			if (empty($c)) {
				$premio = true;
			}
			//print_r("select p.nombre as nPremio, p.nivel as nivelPremio, pa.fecha_jugada as fecha_jugada from participantes pa inner join premios p on pa.premio = p.id where p.nivel = 1 and pa.fecha_jugada > '$fecha ".$hora."';");
		}
	}


	return $premio;




	//echo $premio;








	//print_r($aPremios);


	//print_r($premios);

	//$ultimoPrimerPremio = 

}
