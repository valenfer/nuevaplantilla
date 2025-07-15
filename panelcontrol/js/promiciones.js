const listaPromos = document.getElementById("listaPromos");
  //Cuando cambie el contenido del campo nombreEmpresa
  listaPromos.addEventListener("change", function () {
    const promoSeleccionada = this.value;

    // Si se selecciona "Nueva promociona", limpiar el formulario
    if (promoSeleccionada === "") {
      limpiarFormulario_promocion();
      return;
    }

    // Hacer la petición AJAX para obtener los datos de la promocion
    fetch(
      `./obtener_datos_promocion.php?promocion=${encodeURIComponent(
        promoSeleccionada
      )}`
    )
      .then((response) => {
        console.log(response);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text(); // Primero obtenemos el texto
      })
      .then((text) => {
        try {
          const data = JSON.parse(text); // Intentamos parsearlo como JSON
          if (data.error) {
            console.error("Error del servidor:", data.error);
            return;
          }

          // Rellenar los campos del formulario
          document.getElementById("nombrePromo").value = data.nombrePromo || "";
          document.getElementById("color").value = data.color || "";
          //document.getElementById("codigo").value = data.codigo || "";
          //document.getElementById("multiParticipacion").value =data.multiParticipacion || "";
          //gestionamos que los campo radio salgan checkeados en funcion de los almacenado en config
          const codigoSi = document.getElementById("codigo_si");
          const codigoNo = document.getElementById("codigo_no");
          if (data.codigo === 1) {
            codigoSi.checked = true;
            codigoNo.checked = false;
          } else {
            codigoSi.checked = false;
            codigoNo.checked = true;
          }

          //Gestion de inputs radio de multiparticipacion
          const multiSi = document.getElementById("multi_si");
          const multiNo = document.getElementById("multi_no");
          if (data.multiParticipacion === 1) {
            multiSi.checked = true;
            multiNo.checked = false;
          } else {
            multiSi.checked = false;
            multiNo.checked = true;
          }

          document.getElementById("fin_promo").value = data.fin_promo || "";
          document.getElementById("horaAp").value = data.horaAp || "";
          document.getElementById("horaC").value = data.horaC || "";
          document.getElementById("link").value = data.link;
          data.txtMailGanador || "";
        } catch (e) {
          console.error("Error al parsear JSON:", text); // Mostramos el texto recibido
          console.error("Error:", e);
        }
      })
      .catch((error) => {
        console.error("Error en la petición:", error);
      });
  });

  //Limpiar formulario
  function limpiarFormulario_promocion() {
    document.getElementById("nombrePromo").value = "";
    document.getElementById("link").value = "";
    document.getElementById("codigo_si").checked = false;
    document.getElementById("codigo_no").checked = false;
    document.getElementById("multi_si").checked = false;
    document.getElementById("multi_no").checked = false;

    document.getElementById("fin_promo").value = "";
    document.getElementById("horaAp").value = "";
    document.getElementById("horaC").value = "";
    document.getElementById("txtMailPerdedor").value = "";
    document.getElementById("infoLegal").value = "";
    document.getElementById("basesLegales").value = "";
  }