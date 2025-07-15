<?php
	require_once("../php/conexion.php");
	if(!empty($_GET)){
		extract($_GET);
		
		insert("update premiados set canjeado=1 where codigo = '$cod_ganador';");	
		echo '<p style="color:green;">El código ha sido marcado como entregado correctamente.</p>';
		echo 'Serás redirigido en 5 segundos';
	}


?>
<script type="text/javascript">
		function redireccionarPagina() {
	  window.location = "index.php";
	}
	setTimeout("redireccionarPagina()", 5000);

</script>