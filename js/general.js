mostrarCarga();
$(document).ready(function () {
  ocultarCarga();
  $("#phone").intlTelInput({
    utilsScript: "js/utils.js",
    initialCountry: "es",
  });
});

$(".edad #btn-si").on("click", function () {
  mostrarCarga();
  $(".edad").removeClass("zoomIn").addClass("zoomOut");
  setTimeout(mostrarTelefono, 500);
});
$("#btn-salir").on("click", function () {
  mostrarCarga();
  setTimeout(function () {
    window.location.href = linkFromPHP;
    //window.location.href = "http://localhost:8080/puentegenil/"; //local
    //window.location.href = "https://cashdiazcadenas.com/genil/";
  }),
    500;
});
$("#btn-siguiente").on("click", function (e) {
  e.preventDefault();  
  if (validarImgTicket === 0) {
    alert("Por favor, sube una imagen del ticket antes de continuar.");
    return; // Detener la ejecución si no se ha subido el archivo y es obligatorio
  }
  $(this).attr("disabled", "disabled");
  setTimeout(function () {
    $("#btn-siguiente").prop("disabled", false);
  }, 1000);
  //	var prefijo =
  $("#phone").intlTelInput("getSelectedCountryData").dialCode;
  var tel =
    "+" +
    $("#phone").intlTelInput("getSelectedCountryData").dialCode +
    $("#phone").val();
  /*
	var codigo = false;
	if ( $("#codigo").length > 0 ) {
		if(valTel(tel) && valCod()){
		if(existeTel(tel)){
			mostrarRegalo(1);
		} else {
			mostrarForm();
		}
		}
	} else {
		if(valTel(tel)){
			if(existeTel(tel)){
				mostrarRegalo(1)
			} else {
				mostrarForm();
			}
		}
	}
*/

  var valCodigo = valCod();
  var valTelefono = valTel();
  if (valCodigo && valTelefono) {
    mostrarCarga();
    
    comprobarTelefono(tel).done(function (datos) {
      console.log("Datos dentro de comprobar telefono: " + datos);
      var codigo = false;
      if ($("#codigo").length > 0) {
        codigo = true;
      }
      //Si pide foto ticket y no se ha subido da error
      if (datos == "existe") {
        var repetir = $("#phone").attr("repetir");
        if (repetir == "si") {
          document.cookie = "tel=" + tel;
          if (codigo) {
            var datoCodigo = $("#codigo").val();
            comprobarCodigo(datoCodigo).done(function (resultado) {
              if (resultado == "valido") {
                mostrarRegalo(1);
              } else {
                errorDeCodigo(resultado);
              }
            });
          } else {
            mostrarRegalo(1);
          }
        } else {
          alert("Ya has participado en esta promoción");
          //irAInicio();
          //Daba error al recargar la pagina
          $("input").val("");
          window.location.href = linkFromPHP;
        }
      } else if (datos == "no-existe") {
        var telefono =
          "+" +
          $("#phone").intlTelInput("getSelectedCountryData").dialCode +
          $("#phone").val();
        document.cookie = "tel=" + telefono;
        if (codigo) {
          var datoCodigo = $("#codigo").val();
          comprobarCodigo(datoCodigo).done(function (resultado) {
            if (resultado == "valido") {
              mostrarForm();
            } else {
              errorDeCodigo(resultado);
            }
          });
        } else {
          mostrarForm();
        }
      }
    });
  }
});

$(".formulario #btn-participar").on("click", function () {
  var validado = validarForm();
  $(this).attr("disabled", "disabled");
  setTimeout(function () {
    $(".formulario #btn-participar").prop("disabled", false);
  }, 1000);
  if (validado) {
    mostrarCarga();
    $(".formulario").removeClass("zoomIn").addClass("zoomOut");
    setTimeout(function () {
      mostrarRegalo("");
    }, 500);
  }
});

function mostrarTelefono() {
  $(".edad").hide();
  mostrarCarga();
  setTimeout(function () {
    $(".telefono").addClass("animated zoomIn").removeClass("d-none");
  }, 500);
}

function mostrarForm() {
  $(".telefono").hide();
  ocultarCarga();
  setTimeout(function () {
    $(".formulario").addClass("animated zoomIn").removeClass("d-none");
  }, 500);
}

function mostrarRegalo(tipo) {
  if (tipo == 1) {
    $(".telefono").hide();
    registrarParticipacion();
  } else {
    $(".formulario").hide();
    registrarDatos();
  }
  ocultarCarga();
  setTimeout(function () {
    $(".buscando").addClass("animated zoomIn").removeClass("d-none");
    setTimeout(function () {
      $(".buscando").removeClass("zoomIn").addClass("rubberBand");
    }, 1500);
    setTimeout(function () {
      $(".buscando").removeClass("rubberBand").addClass("pulse");
    }, 2500);
    setTimeout(function () {
      $(".lupa").addClass("animated wobble");
    }, 1000);
    setTimeout(function () {
      $(".lupa").removeClass("wobble").addClass("wobble");
    }, 2000);
    setTimeout(function () {
      $(".lupa").removeClass("wobble").addClass("animated bounceOut");
    }, 2600);
    setTimeout(function () {
      $(".regalo").addClass("animated bounceOut");
    }, 2800);
  }, 500);
}

function comprobarTelefono(num) {
  return $.post(
    "php/conexion.php",
    { funcion: "comprobarNum", num: num },
    function (result) {
      resultado = result;
    }
  );
}

/************** Comprobación de si ha participado el día en curso ****************/
function comprobarParticipacion(num) {
  return $.post(
    "php/conexion.php",
    { funcion: "comprobarParticipacionDiraria", num: num },
    function (result) {
      resultado = result;
    }
  );
}
/*************************************************************************************/

function comprobarCodigo(cod) {
  return $.post(
    "php/conexion.php",
    { funcion: "comprobarCodigo", cod: cod },
    function (result) {
      resultado = result;
    }
  );
}

function mostrarPremio() {
  $(".buscando").removeClass("zoomIn").addClass("zoomOut");
  setTimeout(function () {
    $(".buscando").hide();
    $(".zona-premio").addClass("animated jackInTheBox").removeClass("d-none");
  }, 500);
  setTimeout(function () {
    $("#carga").fadeIn("500");
  }, 29000);
  setTimeout(function () {
    //location.reload();
    window.location.href = linkFromPHP;
    //window.location.href = "http://localhost:8080/puentegenil/";
    //window.location.href = "https://cashdiazcadenas.com/genil/";
  }, 30000);
}

function irAInicio() {
  window.location.href = linkFromPHP;
  //window.location.href = "http://localhost:8080/puentegenil/";
  //ocultarCarga();
  //$("input").val("");
}

function ocultarCarga() {
  $("#carga").fadeOut("500");
}

function errorDeCodigo(tipo) {
  $("#carga").fadeOut("500");
  if (tipo == "no-existe") {
    alert("El código introducido no es válido");
  } else if (tipo == "utilizado") {
    alert("El código introducido ya ha sido utilizado");
  } else {
    alert("Ha ocurrido un error");
    console.log(tipo);
  }
  $("#codigo").val("");
  $("#phone").val("");
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

//VALIDACIONES

function valTel() {
  var valido = true;
  $("#phone").removeClass("is-invalid");
  $(".invalid-feedback.tel").fadeOut();
  var exp = new RegExp("^[0-9]*$");
  if ($("#phone").val().length != 9 || !exp.test($("#phone").val())) {
    $("#phone").addClass("is-invalid");
    $(".invalid-feedback.tel").fadeIn();
    valido = false;
  }
  return valido;
}

function valCod() {
  var valido = true;
  if ($("#codigo").length > 0) {
    $("#codigo").removeClass("is-invalid");
    $(".invalid-feedback.cod").fadeOut();
    if ($("#codigo").val().length <= 4) {
      $("#codigo").addClass("is-invalid");
      $(".invalid-feedback.cod").fadeIn();
      valido = false;
    }
    $("#carga").fadeOut("500");
  }
  return valido;
}

function registrarDatos() {
  //var aDatos = [];

  var tmp = {};
  tmp["telefono"] =
    "+" +
    $("#phone").intlTelInput("getSelectedCountryData").dialCode +
    $("#phone").val();

  if ($("#codigo").length != 0) {
    tmp["codigo"] = $("#codigo").val().toUpperCase();
  }

  tmp["nombre"] = $("#nombre").val();

  tmp["edad"] = $("#edad").val();

  tmp["municipio"] = $("#municipio").val();

  tmp["direccion"] = $("#direccion").val();

  tmp["email"] = $("#email").val().toLowerCase();

  tmp["cod_postal"] = $("#codp").val();
  tmp["ticketImagen"] = $("#ticketImagen").val();
  //Añadimos campos auxiliares
  tmp["ticket"] = $("#ticket").val();
  tmp["auxiliar1"] = $("#auxiliar1").val();
  tmp["auxiliar2"] = $("#auxiliar2").val();
  tmp["auxiliar3"] = $("#auxiliar3").val();
  tmp["auxiliar4"] = $("#auxiliar4").val();

  //aDatos.push(tmp);

  var jDatos = JSON.stringify(tmp);

  console.log("jDatos." + jDatos);

  postRegistrarDatos(jDatos).done(function (result) {
    console.log("Resultado de registrar datos: (result)" + result);
    if (isJSON(result)) {
      var premio = JSON.parse(result);
      console.log(premio);

      if (premio[0] != "-") {
        $("#n-premio").html(premio[1]);
        $(".ganador").removeClass("d-none");
        // Mostrar la imagen del premio directamente usando el nombre recibido
        if (premio[2]) {
          $("#img-premio").attr("src", "img/premios/" + premio[2]);
        } else {
          $("#img-premio").attr("src", "img/premios/regalo.png"); // Imagen por defecto
        }
        if ($("#codigo").val()) {
          $("#cod-usado").text($("#codigo").val().toUpperCase());
        } else {
          $("#cod-usado").text("-");
        }
        setTimeout(mostrarGlobos, 3000);
      } else {
        $(".perdedor").removeClass("d-none");
      }
      //setTimeout(mostrarPremio, 3000);
      mostrarPremio();
    } else if (result == "error-codigo") {
      alert("Has intentado participar con un código inválido.");
      //window.location.href = "../";
    } else {
      //window.location.href = "../";
      console.log("Ha ocurrido un error");
      console.log(result);
    }
  });
}

function registrarParticipacion() {
  var telefono =
    "+" +
    $("#phone").intlTelInput("getSelectedCountryData").dialCode +
    $("#phone").val();
  postGetDatos(telefono).done(function (result) {
    if (result != "error") {
      var datos = JSON.parse(result);
      console.log(datos);
      $("#nombre").val(datos[0]["nombre"]);

      $("#edad").val(datos[0]["edad"]);

      $("#municipio").val(datos[0]["municipio"]);

      $("#direccion").val(datos[0]["direccion"]);

      $("#email").val(datos[0]["email"]);

      $("#codp").val(datos[0]["cod_postal"]);

      //Datosa de campos auxiliares
      $("#ticket").val(datos[0]["ticket"]);
      $("#auxiliar1").val(datos[0]["auxiliar1"]);
      $("#auxiliar2").val(datos[0]["auxiliar2"]);
      $("#auxiliar3").val(datos[0]["auxiliar3"]);
      $("#auxiliar4").val(datos[0]["auxiliar4"]);
      $("#auxiliar4").val(datos[0]["auxiliar4"]);
      $("#ticketImagen").val(datos[0]["ticketImagen"]);

      registrarDatos();
      /*$("#carga").fadeOut("500", function(){
						$(".buscando").addClass("animated zoomIn").removeClass("d-none");
						setTimeout(function(){
							$(".buscando").removeClass("zoomIn").addClass("rubberBand");
						
						},1500);
						setTimeout(function(){
							$(".buscando").removeClass("rubberBand").addClass("pulse");
						
						},2500);
							setTimeout(function(){
								
								$(".lupa").addClass("animated wobble");
							},1000);
							setTimeout(function(){
								
								$(".lupa").removeClass("wobble").addClass("wobble");
							},2000);
							setTimeout(function(){
								
								$(".lupa").removeClass("wobble").addClass("bounceOut");
							},2600);
							setTimeout(function(){
								
								$(".regalo").addClass("animated bounceOut");
							},2800);
						
					});*/
    }
  });
}

function validarForm() {
  var valido = true;
  // Detectar dinámicamente los campos visibles en el formulario
  $(".formulario input:visible").each(function () {
    var $el = $(this);
    var id = $el.attr("id");
    var val = $el.val();
    var placeholder = $el.attr("placeholder");
    var errorMsg = "Introduce " + (placeholder ? placeholder : id) + " válido";
    var $feedback = $el.siblings('.invalid-feedback');
    if (id === "nombre") {
      if (!val || val.length < 1) {
        $el.addClass("is-invalid");
        if ($feedback.length) $feedback.text(errorMsg);
        valido = false;
      } else {
        $el.removeClass("is-invalid");
      }
    } else if (id === "edad") {
      var eEdad = new RegExp("^[0-9]*$");
      if (!val || !eEdad.test(val) || parseInt(val, 10) < 18) {
        $el.addClass("is-invalid");
        if ($feedback.length) $feedback.text(errorMsg);
        valido = false;
      } else {
        $el.removeClass("is-invalid");
      }
    } else if (id === "municipio") {
      if (!val || val.length < 4) {
        $el.addClass("is-invalid");
        if ($feedback.length) $feedback.text(errorMsg);
        valido = false;
      } else {
        $el.removeClass("is-invalid");
      }
    } else if (id === "direccion") {
      if (!val || val.length < 4) {
        $el.addClass("is-invalid");
        if ($feedback.length) $feedback.text(errorMsg);
        valido = false;
      } else {
        $el.removeClass("is-invalid");
      }
    } else if (id === "auxiliar1" || id === "auxiliar2") {
      if (!val || val.length < 2) {
        $el.addClass("is-invalid");
        if ($feedback.length) $feedback.text(errorMsg);
        valido = false;
      } else {
        $el.removeClass("is-invalid");
      }
    } else if (id === "auxiliar3" || id === "auxiliar4") {
      var eAux = new RegExp("^[0-9]+$");
      if (!val || !eAux.test(val) || val.length < 1) {
        $el.addClass("is-invalid");
        if ($feedback.length) $feedback.text(errorMsg);
        valido = false;
      } else {
        $el.removeClass("is-invalid");
      }
    } else if (id === "email") {
      var eMail = new RegExp(
        /^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      );
      if (!eMail.test(val.toLowerCase())) {
        $el.addClass("is-invalid");
        if ($feedback.length) $feedback.text(errorMsg);
        valido = false;
      } else {
        $el.removeClass("is-invalid");
      }
    } else if (id === "codp") {
      var eCodp = new RegExp("^[0-9]{5,}$");
      if (!val || !eCodp.test(val)) {
        $el.addClass("is-invalid");
        if ($feedback.length) $feedback.text(errorMsg);
        valido = false;
      } else {
        $el.removeClass("is-invalid");
      }
    } else if (id === "ticket") {
      if (!val || val.length < 2) {
        $el.addClass("is-invalid");
        if ($feedback.length) $feedback.text(errorMsg);
        valido = false;
      } else {
        $el.removeClass("is-invalid");
      }
    }
    // Puedes añadir más validaciones para otros campos si lo necesitas
  });
  if (!$("#check1").prop("checked") || !$("#check2").prop("checked")) {
    valido = false;
    $("#error-checks").fadeIn().removeClass("d-none");
  }
  return valido;
}

function postRegistrarDatos(datos) {
  console.log("datos en postregistrarDatos.js: " + datos);
  return $.post(
    "php/conexion.php",
    { funcion: "registrarDatos", datos: datos },
    function (result) {
      resultado = result;
    }
  );
}

function postGetDatos(telefono) {
  return $.post(
    "php/conexion.php",
    { funcion: "getDatos", telefono: telefono },
    function (result) {
      resultado = result;
    }
  );
}
function mostrarCarga() {
  $("#carga").fadeIn();
  $("html, body").css({
    overflow: "hidden",
    height: "100%",
  });
}

function ocultarCarga() {
  $("html, body").css({
    overflow: "auto",
    height: "auto",
  });
  $("#carga").fadeOut();
}

function isJSON(str) {
  if (typeof str !== "string") {
    return false;
  }
  try {
    JSON.parse(str);
    return true;
  } catch (e) {
    return false;
  }
}

function mostrarGlobos() {
  $(".g1, .g2, .g3").hide().removeClass("d-none").fadeIn();
  setTimeout(function () {
    $(".g1, .g2, .g3").fadeOut().addClass("d-none");
  }, 4000);
}

/*
function existeTel(tel){
	var existe = false;

	comprobarTelefono(tel).done(function(datos){
		if(datos=="existe"){
			existe = true;
			document.cookie="tel="+tel;

		}
		return "Hola";
	});

	return existe;
}*/
