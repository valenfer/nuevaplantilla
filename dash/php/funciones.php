<?php 
	session_start();
	if((!ISSET($_GET["t"]) || $_GET["t"]!="YW5pdmVyc2FyaW9jYXNoZGlhemNhZGVuYXNhZG1pbmlzdHJhY2lvbm1hcnVqYWxpbW9u")){
		if(!ISSET($_SESSION["token"])){
		//	echo $_SESSION["token"];
			session_destroy();
			header('Location: http://www.cashdiazcadenas.com/');
		}
		
	} else {
		
		if(!ISSET($_SESSION["token"])){
			$_SESSION["token"]=$_GET["t"];
		}
		
	}

	require_once("conexion.php");
	if(!empty($_GET)){
		extract($_GET);
		if(ISSET($exportar)){
			exportarDatos();
		}
		
	}
	if(!empty($_POST)){
		extract($_POST);
		if(ISSET($funcion)){
			if($funcion=="insertarMomento"){
				insertarMomento($fecha,$hora,$nivel);
			}

			if($funcion=="eliminarMomento"){
				eliminarMomento($id);
			}
			

		}
	//	print_r($_POST);
		if(ISSET($form_cliente)){
		  $c = "update config set valor = '$n_empresa' where ajuste='nombreEmpresa';update config set valor = '$n_promo' where ajuste='nombrePromo';update config set valor = '$f_promo' where ajuste='fin_promo';update config set valor = '$minutos' where ajuste='minutos'; update config set valor='$horaAp' where ajuste='horaAp'; update config set valor='$horac' where ajuste='horaC';";
		  insert($c);
		  
		}
		if(ISSET($form_mail)){
		  $c = "update config set valor = '$remitente' where ajuste='correoEmpresa';update config set valor = '$asunto_mail' where ajuste='asuntoMail';update config set valor = '$text_ganador' where ajuste='texto_mail_ganador';update config set valor = '$asunto_perdedor' where ajuste='asuntoMailPerdedor';update config set valor = '$text_perdedor' where ajuste='texto_mail_perdedor'; update config set valor = '$lgpd' where ajuste='infoLGPD';";
		  insert($c);
		  
		}
		if(ISSET($form_e_premio)){
		  $c = "update premios set nombre = '$nombre' where id=$id;update premios set cantidad = '$cantidad' where id=$id;update premios set nivel = '$nivel' where id=$id;";
		 
		  insert($c);
		  	
		}

	}

	function exportarDatos(){
		//get records from database
		global $nombreEmpresa;
		$query = consulta("select * from participantes group by telefono;");

		if(!empty($query)){
		 
		    $delimiter = ",";
		    $filename = "leads_".$nombreEmpresa.'_'. date('Y-m-d') . ".csv";
		    
		    //create a file pointer
		    $f = fopen('php://memory', 'w');
		    
		    //set column headers
		    $fields = array('id', 'nombre', 'email', 'telefono', 'direccion', 'poblacion', 'edad', 'municipio', 'cod_postal');
		    fputcsv($f, $fields, $delimiter);
		    
		    //output each row of the data, format line as csv and write to file pointer
		    $row = 0;
		   foreach ($query as $row){
		   	$lineData = array($row['id'], $row['nombre'], $row['email'], $row['telefono'], $row['direccion'], $row['poblacion'], $row['edad'], $row['municipio'], $row['cod_postal']);
		   	fputcsv($f, $lineData, $delimiter);
		   }
		    
		    //move back to beginning of file
		    fseek($f, 0);
		    
		    //set headers to download file rather than displayed
		    header('Content-Type: text/csv');
		    header('Content-Disposition: attachment; filename="' . $filename . '";');
		    
		    //output all remaining data on a file pointer
		    fpassthru($f);
		}
		echo '<script type="text/javascript">window.close();</script>';
		exit;

	}
	function tablaDatos(){
		$c = consulta("select p.id as id, p.cod_juego as cod_juego, p.cod_canjeo as cod_canjeo, pe.nombre as premio, p.email as email, p.nombre as nombre, p.telefono as telefono, p.edad as edad, p.municipio as municipio, p.cod_postal as cod_postal, p.direccion as direccion, p.fecha_jugada as fecha_jugada, p.canjeado as canjeado, p.estado_mail as estado_mail from participantes p left join premios pe on p.premio = pe.id;");

		foreach ($c as $valor){
			extract($valor);
			echo '<tr>
				      <th scope="row">'.$id.'</th>
				      <td>'.$nombre.'</td>
				      <td>'.$premio.'</td>
				      <td>'.$telefono.'</td>
				      <td>'.$email.'</td>
				      <td>'.$edad.'</td>
				      <td>'.$municipio.'</td>
				      <td>'.$direccion.'</td>
				      <td>'.$cod_postal.'</td>
				      <td>'.$fecha_jugada.'</td>
				      <td>'.$canjeado.'</td>
				      <td>'.$cod_juego.'</td>
				      <td>'.$cod_canjeo.'</td>
				      <td>'.$estado_mail.'</td>
				    </tr>';
		}



	}

	function tablaDatosGanadores(){
		$c = consulta("select * from premiados;");

		foreach ($c as $valor){
			extract($valor);
			echo '<tr>
				      <th scope="row">'.$id.'</th>
				      <td>'.$Nombre.'</td>
				      <td>'.$premio.'</td>
				      <td>'.$codigo.'</td>			    
				    </tr>';
		}



	}

	function getLeads(){
		$c = consulta("select * from participantes group by telefono;");

		return count($c);
	}

	function getJugadas(){
		$c = consulta("select * from participantes;");

		return count($c);
	}

	function getVisitas(){
		$c = consulta("select valor from config where ajuste='visitas';");

		return $c[0]["valor"];
	}

	function getPrimerosPremios(){
		$c = consulta("select p.nombre from participantes pa inner join premios p on pa.premio = p.id where p.nivel = 1;");
		return count($c);
	}

	function getSegundosPremios(){
		$c = consulta("select p.nombre from participantes pa inner join premios p on pa.premio = p.id where p.nivel != 1;");
		return count($c);
	}

	function listaMomentos(){
		$c = consulta("select * from momentos");

		foreach($c as $valor){
			extract($valor);
			echo '<li id-m="'.$id.'" class="list-group-item momento"><span id="fecha"><i class="material-icons">calendar_today</i> '.fecha($fecha).' </span> <span id="hora" class="ml-3"><i class="material-icons">access_time</i>'.$hora.'</span><span id="nivel" class="text-primary ml-3"><i class="material-icons">sort</i>Nivel '.$nivel.' </span><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button></li>';
		}


	}

	function insertarMomento($fecha,$hora,$nivel){
		$c = "insert into momentos (nivel, hora, fecha) values ($nivel, '$hora', '$fecha');";
		
		if(insert($c)!=1){
			echo "error";
		} else {
			$c2 = consulta("select id from momentos order by id desc limit 1");
			echo $c2[0]["id"];
		}
	}

	function eliminarMomento($id){
		$c = "delete from momentos where id=$id;";
		if(insert($c)!=1){
			echo "error";	
		} 
	}

	function fecha($fecha){
	  $divFecha = explode("-", $fecha);
	  return $divFecha[2].'/'.$divFecha[1].'/'.$divFecha[0];
	}


 ?>