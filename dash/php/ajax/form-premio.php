<?php
	require_once("../conexion.php");
	extract($_POST);

	$c = consulta("select * from premios where id = $id");

	extract($c[0]);
?>
<form id="form_e_premio" method="POST" action="./funciones.php">
	<input name="id" class="d-none" value="<?php echo $id; ?>">
	<input name="form_e_premio" class="d-none">
	<img src="../img/premios/<?php echo $img; ?>" class="rounded img-fluid mb-4">
	<div class="form-group row">
	    <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Nombre</label>
	    <div class="col-sm-9">
	      <input type="text" class="form-control" name="nombre" placeholder="Nombre del premio" value="<?php echo $nombre; ?>" required>
	    </div>
	  </div>
	  <div class="form-group row">
	      <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Stock</label>
	      <div class="col-sm-9">
	        <input type="number" min="0" class="form-control" name="cantidad" placeholder="Stock del premio" value="<?php echo $cantidad; ?>" required>
	      </div>
	    </div>
	    <div class="form-group row">
	        <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Nivel</label>
	        <div class="col-sm-9">
	          <input type="number" class="form-control" name="nivel" placeholder="Nivel del premio" value="<?php echo $nivel; ?>" required>
	        </div>
	      </div>
	
	<button type="submit" class="btn btn-primary btn-block">Guardar cambios</button>

</form>


<script type="text/javascript">
	    $("#form_e_premio").on("submit", function(e){

    	e.preventDefault();
    	
    	$.post("./php/funciones.php",$("#form_e_premio").serialize(),function(res){
    	
    	        if(res==""){
    	        	$("#modalEditarPremio").removeClass("zoomIn").addClass("zoomOut");
    	        	mostrarCarga();
    	        	setTimeout(function(){
    	        		window.location.href = "premios.php?s";
    	        	},500);
    	        } else {
    	        	console.log(res);
    	        }
    	});



    });

</script>