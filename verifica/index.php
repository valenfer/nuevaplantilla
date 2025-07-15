<?php
	require_once("../php/conexion.php");
?>
<html>
<head>
	</head>
	<meta name="robots" content="noindex" />
	<title>Comprobar códigos ganadores</title>
	<body>
		<p>Introduce el código a comprobar</p>
		<form method="GET" action="index.php">
			<input type="text" name="codigo" required> <button type="submit">Consultar</button>
		</form>
		<?php
			if(!empty($_GET)){
				extract($_GET);
				
					$datos = consulta("select * from premiados where codigo = '$codigo' and canjeado=0");

					if(!empty($datos)){
						echo '<table border="1">
								<tr>
									<td><b>Nombre</b></td>
									<td><b>Premio</b></td>
									<td><b>Código</b></td>
								</tr>';
						echo '<tr>
									<td>'.$datos[0]["Nombre"].'</td>
									<td>'.$datos[0]["premio"].'</td>
									<td>'.$datos[0]["codigo"].'</td>
								</tr>';
						echo '</table>';
						?>
					</br>
					<a href="entregado.php?cod_ganador=<?php echo $codigo; ?>">Marcar como entregado</a>
						<?php
					} 
				
				 else {
					//consulta("update premiados set canjeado=1 where where codigo = '$cod_ganador';");
					echo '<p>El código introducido no ha sido premiado o ya ha sido entregado.</p>';
				}

				
				
			}

		?>
	</body>
</html>

			