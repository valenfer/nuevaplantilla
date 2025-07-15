mostrarCarga();
$('#tabla_leads').DataTable();
/*

{
        "processing": true,
        "serverSide": true,
        "ajax": "php/tablaDatos.php"
    }

    */
$(document).ready( function () {
	$("a").on("click",function(e){
		if(!$(this).hasClass("paginate_button")){
			e.preventDefault();
			var e = $(this).attr("href");
			if(e!="#"){
				mostrarCarga();
				
				setTimeout(function(){
					window.location.href = e;
				},500);
			}
			
		}
		
	});
	ocultarMensaje();
	ocultarCarga();
   
	$(".premio").on("click", editarPremio);

    $("#a-momento").on("click", anadirMomento);



    $("#form_cliente").on("submit", function(e){

    	e.preventDefault();
    	$.post("./php/funciones.php",$("#form_cliente").serialize(),function(res){
    	        if(res==""){
    	        	mostrarCarga();
    	        	setTimeout(function(){
    	        		window.location.href = "preferencias.php?s";
    	        	},500);
    	        } else {
    	        	console.log(res);
    	        }
    	});



    });

    $("#btn-exportar").on("click", function(e){
    	mostrarCarga();
    	postExportar().done(function(html){
    		ocultarCarga();
    	});



    });



    $("#form_mail").on("submit", function(e){

    		e.preventDefault();
    		
    		
    		$.post("./php/funciones.php",$("#form_mail").serialize(),function(res){
    		        if(res==""){
    		        	mostrarCarga();
    		        	setTimeout(function(){
    		        		
    		        		window.location.href = "preferencias.php?s";
    		        	},500);
    		        } else {
    		        	console.log(res);
    		        }
    		});

    	});	


    $("li .close").on("click", eliminarMomento);

    $(".previsual").on("click", cargarModal);

} );


function anadirMomento(){
	var cod = '<li class="animated fadeIn list-group-item momento"><span id="fecha"><i class="material-icons">calendar_today</i> <input type="date" class="f campo-m"> </span> <span id="hora" class="ml-3"><i class="material-icons">access_time</i><input type="time" class="h campo-m"></span><span id="nivel" class="text-primary ml-3"><i class="material-icons">sort</i>Nivel <input type="number" min="1" max="5" class="n campo-m"></span><button class="btn btn-success btn-guardar"><i class="material-icons">save</i>Guardar</li> </button>'
	$("#lista-momentos").append(cod);
	$(".btn-guardar").unbind().on("click", guardarMomento);
}


function guardarMomento(){
	//console.log($(this).parent().html());
	var fecha = $(this).parent().find('.f').val();
	var hora = $(this).parent().find('.h').val();
	var nivel = $(this).parent().find('.n').val();
	var li = $(this).parent();
	
	if(fecha!="" && hora !="" && nivel!=""){
		postMomento(fecha,hora,nivel).done(function(result){

			if(result!="error"){
				li.removeClass("fadeIn");
				var html = '<span id="fecha"><i class="material-icons">calendar_today</i> '+fechaF(fecha)+' </span> <span id="hora" class="ml-3"><i class="material-icons">access_time</i>'+hora+':00</span><span id="nivel" class="text-primary ml-3"><i class="material-icons">sort</i>Nivel '+nivel+'</span> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
				li.attr("id-m",result);

				li.fadeOut("500").html(html).fadeIn();
				$("li .close").unbind().on("click", eliminarMomento);
				mostrarMensaje("El momento ha sido guardado");
			} else {
				console.log(result);
			}
		});
	}

}

function eliminarMomento(){
	var id = $(this).parent().attr("id-m");
	var li = $(this).parent();
	console.log(id);
	postEliminarMomento(id).done(function(result){
		console.log(result);
		if(result==""){
			li.fadeOut();
			mostrarMensaje("El momento ha sido eliminado");
		}
	});
}

function postEliminarMomento(id){
	return $.post("./php/funciones.php", {funcion:"eliminarMomento", id:id}, function(result){
		resultado = result;
	});
}

function postMomento(fecha, hora, nivel){
	return $.post("./php/funciones.php", {funcion:"insertarMomento", fecha:fecha, hora:hora, nivel:nivel}, function(result){
		resultado = result;
	});
}

function fechaF(fecha){
	var f = fecha.split("-");
	return f[2]+"/"+f[1]+"/"+f[0];
}

function mostrarCarga(){
	$("#carga").fadeIn();
	$('html, body').css({
		    'overflow': 'hidden',
		    'height': '100%'
		});
}

function ocultarCarga(){
	$('html, body').css({
	    'overflow': 'auto',
	    'height': 'auto'
	});
	$("#carga").fadeOut();
}

function mostrarMensaje($mensaje){
	$(".mensaje").text($mensaje);
	$(".mensaje").hide().removeClass('fadeOutRight fadeInRight d-none').addClass('fadeInRight').show();
	ocultarMensaje();
}

function ocultarMensaje(){
	setTimeout(function(){
		$(".mensaje").removeClass("fadeInRight").addClass("fadeOutRight");
	},3000);
}

function cargarModal(){
	var idc = $("#"+$(this).attr("idc")).val();
	$("#modalVisual .modal-body").html(idc);
	$("#modalVisual").modal("show");
}

function editarPremio(){
	$("#modalEditarPremio .modal-body").html("").removeClass("animated fadeIn").addClass("d-none");
	$(".cargando").fadeIn();
	$("#modalEditarPremio").modal("show");
	var id = $(this).attr("idp");
	console.log(id);
	postEditPremio(id).done(function(html){
		$(".cargando").fadeOut(function(){
			$("#modalEditarPremio .modal-body").html(html);
			$("#modalEditarPremio .modal-body").addClass("animated fadeIn").removeClass("d-none");
		});
	});

}

function postEditPremio(id){
	return $.post("php/ajax/form-premio.php", {id:id}, function(result){
		resultado = result;
	});
}

function postExportar(){
	return $.post("php/funciones.php", {funcion:"exportar"}, function(result){
		resultado = result;
	});
}



