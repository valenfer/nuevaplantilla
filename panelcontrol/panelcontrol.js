document.addEventListener("DOMContentLoaded", function () {
  /*Visualizar formulario de generar codigos si se activa la opcion
  const codigoSi = document.getElementById("codigo_si");
  const codigoNo = document.getElementById("codigo_no");
  const cantidadDiv = document.getElementById("codigos");

  codigoSi.addEventListener("change", function () {
    if (this.checked) {
      cantidadDiv.style.display = "block";
    }
  });

  codigoNo.addEventListener("change", function () {
    if (this.checked) {
      cantidadDiv.style.display = "none";
    }
  });
********************** */
  const listaEmpresas = document.getElementById("listaEmpresas");
  //Cuando cambie el contenido del campo nombreEmpresa
  listaEmpresas.addEventListener("change", function () {
    const empresaSeleccionada = this.value;

    // Si se selecciona "Nueva empresa", limpiar el formulario
    if (empresaSeleccionada === "") {
      limpiarFormulario_empresa();
      return;
    }

    // Hacer la petición AJAX para obtener los datos de la empresa
    fetch(
      `./obtener_datos_empresa.php?empresa=${encodeURIComponent(
        empresaSeleccionada
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
          // Rellenar los campos del formulario
          document.getElementById("nombreEmpresa").value =
            data.nombreEmpresa || "";
          document.getElementById("correoEmpresa").value =
            data.correoEmpresa || "";
          document.getElementById("host").value = data.host || "";
          document.getElementById("username").value = data.username || "";
          document.getElementById("password").value = data.password || "";
          document.getElementById("port").value = data.port || "";

          document.getElementById("asuntoMail").value = data.asuntoMail || "";
          document.getElementById("txtMailGanador").value =
            data.txtMailGanador || "";
          document.getElementById("asuntoMailPerdedor").value =
            data.asuntoMailPerdedor || "";
          document.getElementById("txtMailPerdedor").value =
            data.txtMailPerdedor || "";
          document.getElementById("infoLegal").value = data.infoLegal || "";
          document.getElementById("basesLegales").value =
            data.basesLegales || "";
          document.getElementById("linkBasesLegales").value =
            data.linkBasesLegales || "";
          document.getElementById("linkTerminosUso").value =
            data.linkTerminosUso || "";
        } catch (e) {
          console.error("Error al parsear JSON:", text); // Mostramos el texto recibido
          console.error("Error:", e);
        }
      })
      .catch((error) => {
        console.error("Error en la petición:", error);
      });
  });

  //Cuando cambien nombrePromo

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
  function limpiarFormulario_empresa() {
    document.getElementById("nombreEmpresa").value = "";
    document.getElementById("correoEmpresa").value = "";
    document.getElementById("host").value = "";
    document.getElementById("username").value = "";
    document.getElementById("password").value = "";
    document.getElementById("port").value = "";

    document.getElementById("asuntoMail").value = "";
    document.getElementById("txtMailGanador").value = "";
    document.getElementById("asuntoMailPerdedor").value = "";
    document.getElementById("txtMailPerdedor").value = "";
    document.getElementById("infoLegal").value = "";
    document.getElementById("basesLegales").value = "";
  }

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

  //Borrar tabla premios
  const botonBorrarPremios = document.getElementById("borrarPremios");

  if (botonBorrarPremios) {
    botonBorrarPremios.addEventListener("click", function () {
      if (confirm("¿Estás seguro de que quieres borrar todos los premios?")) {
        fetch("", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "borrar_premios=1",
        })
          .then((response) => {
            if (response.ok) {
              // Recarga la página y desplaza la vista hasta el div #premios
              window.location.href =
                window.location.pathname + window.location.search + "#premios";
            } else {
              console.error("Error al borrar los premios.");
            }
          })
          .catch((error) => {
            console.error("Error de red:", error);
          });
      }
    });
  }

  function seleccionarImagen(nombreArchivo) {
    document.getElementById("imagenPremio").value = nombreArchivo;
  }

  function subirArchivo() {
    const archivoInput = document.getElementById("archivoSubida");
    const archivo = archivoInput.files[0];

    if (archivo) {
      const formData = new FormData();
      formData.append("archivoSubida", archivo);

      fetch("", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (response.ok) {
            actualizarCarrusel(); // Actualiza el carrusel después de la carga
          } else {
            console.error("Error al subir el archivo.");
          }
        })
        .catch((error) => {
          console.error("Error de red:", error);
        });
    }
  }
  function actualizarCarrusel() {
    fetch("", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: "actualizar_carrusel=1", // Envia una solicitud para actualizar el carrusel
    })
      .then((response) => response.text())
      .then((html) => {
        document.getElementById("carruselPremios").innerHTML = html;
      })
      .catch((error) => {
        console.error("Error al actualizar el carrusel:", error);
      });
  }
});

//Gestión del logo
function subirLogo() {
  const fileInput = document.getElementById("logoSubida");
  const file = fileInput.files[0];

  if (!file) {
    alert("Por favor, selecciona un archivo.");
    return;
  }

  // Validar que el archivo sea una imagen
  if (!file.type.startsWith("image/")) {
    alert("Por favor, selecciona un archivo de imagen válido.");
    return;
  }

  // Crear un FormData para enviar el archivo
  const formData = new FormData();
  formData.append("logo", file);

  // Enviar el archivo mediante AJAX
  $.ajax({
    url: "upload_logo.php", // Archivo PHP que manejará la subida
    type: "POST",
    data: formData,
    processData: false, // Evitar que jQuery procese los datos
    contentType: false, // Evitar que jQuery establezca el tipo de contenido
    success: function (response) {
      if (response.success) {
        // Actualizar la imagen en el div #imagenLogo
        $("#imagenLogo img").attr(
          "src",
          "../img/logo.png?t=" + new Date().getTime()
        );
        alert("Logo subido y actualizado correctamente.");
      } else {
        alert("Error al subir el logo: " + response.message);
      }
    },
    error: function () {
      alert("Error en la conexión con el servidor.");
    },
  });
}

function subirFooter() {
  const fileInput = document.getElementById("footerSubida");
  const file = fileInput.files[0];

  if (!file) {
    alert("Por favor, selecciona un archivo.");
    return;
  }

  // Validar que el archivo sea una imagen
  if (!file.type.startsWith("image/")) {
    alert("Por favor, selecciona un archivo de imagen válido.");
    return;
  }

  // Crear un FormData para enviar el archivo
  const formData = new FormData();
  formData.append("footer", file);

  // Enviar el archivo mediante AJAX
  $.ajax({
    url: "upload_footer.php", // Archivo PHP que manejará la subida
    type: "POST",
    data: formData,
    processData: false, // Evitar que jQuery procese los datos
    contentType: false, // Evitar que jQuery establezca el tipo de contenido
    success: function (response) {
      if (response.success) {
        // Actualizar la imagen en el div #imagenFooter
        $("#imagenFooter img").attr(
          "src",
          "../img/footer.png?t=" + new Date().getTime()
        );
        alert("Imagen de footer subida y actualizada correctamente.");
      } else {
        alert("Error al subir la imagen de footer: " + response.message);
      }
    },
    error: function () {
      alert("Error en la conexión con el servidor.");
    },
  });
}

function subirCabecera() {
  const fileInput = document.getElementById("cabeceraSubida");
  const file = fileInput.files[0];

  if (!file) {
    alert("Por favor, selecciona un archivo.");
    return;
  }

  // Validar que el archivo sea una imagen
  if (!file.type.startsWith("image/")) {
    alert("Por favor, selecciona un archivo de imagen válido.");
    return;
  }

  // Crear un FormData para enviar el archivo
  const formData = new FormData();
  formData.append("cabecera", file); // Cambia "logo" o "footer" por "cabecera"

  // Enviar el archivo mediante AJAX
  $.ajax({
    url: "upload_cabecera.php", // Archivo PHP que manejará la subida de la cabecera
    type: "POST",
    data: formData,
    processData: false, // Evitar que jQuery procese los datos
    contentType: false, // Evitar que jQuery establezca el tipo de contenido
    success: function (response) {
      if (response.success) {
        // Actualizar la imagen en el div #imagenCabecera
        $("#imagenCabecera img").attr(
          "src",
          "../img/cabecera.png?t=" + new Date().getTime()
        );
        alert("Cabecera subida y actualizada correctamente.");
      } else {
        alert("Error al subir la cabecera: " + response.message);
      }
    },
    error: function () {
      alert("Error en la conexión con el servidor.");
    },
  });
}

// Función JavaScript para manejar la subida del archivo del fondo del footer
// Función JavaScript para manejar la subida del archivo
function subirFondoFooter() {
  const fileInput = document.getElementById("inputFondoFooter");
  const file = fileInput.files[0];

  if (!file) {
    alert("Por favor, selecciona un archivo primero.");
    return;
  }

  // Verificar que sea una imagen
  if (!file.type.match("image.*")) {
    alert("Por favor, selecciona un archivo de imagen.");
    return;
  }

  // Crear un FormData para enviar el archivo
  const formData = new FormData();
  formData.append("fondoFooter", file);

  // Mostrar algún indicador de carga
  const imgContainer = document.getElementById("fondoFooterPreview");
  imgContainer.innerHTML = "<p>Subiendo...</p>";

  // Enviar el archivo usando fetch
  fetch("upload_fondofooter.php", {
    // Nombre actualizado del archivo PHP
    method: "POST",
    body: formData,
  })
    .then((response) => {
      // Añadir verificación para asegurarse de que la respuesta es JSON
      if (!response.ok) {
        throw new Error(
          "Error en la respuesta del servidor: " + response.status
        );
      }
      const contentType = response.headers.get("content-type");
      if (!contentType || !contentType.includes("application/json")) {
        // Si no es JSON, convertir a texto para ver el error
        return response.text().then((text) => {
          throw new Error(
            "Respuesta no es JSON: " + text.substring(0, 100) + "..."
          );
        });
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        // Actualizar la imagen con la recién subida (añadiendo timestamp para evitar caché)
        imgContainer.innerHTML =
          '<img src="../img/fondo-footer.png?t=' +
          new Date().getTime() +
          '" alt="">';

        // Mensaje de éxito
        alert("Imagen subida correctamente.");
      } else {
        // Mostrar error
        alert("Error al subir la imagen: " + data.message);
        // Restaurar la imagen original
        imgContainer.innerHTML = '<img src="../img/fondo-footer.png" alt="">';
      }
    })
    .catch((error) => {
      alert("Error en la subida: " + error);
      // Restaurar la imagen original
      imgContainer.innerHTML = '<img src="../img/fondo-footer.png" alt="">';
    });
}

function subirFondoCabecera() {
  const fileInput = document.getElementById("inputFondoCabecera");
  const file = fileInput.files[0];

  if (!file) {
    alert("Por favor, selecciona un archivo primero.");
    return;
  }

  // Verificar que sea una imagen
  if (!file.type.match("image.*")) {
    alert("Por favor, selecciona un archivo de imagen.");
    return;
  }

  // Crear un FormData para enviar el archivo
  const formData = new FormData();
  formData.append("fondoCabecera", file);

  // Mostrar algún indicador de carga
  const imgContainer = document.getElementById("fondoCabeceraPreview");
  imgContainer.innerHTML = "<p>Subiendo...</p>";

  // Enviar el archivo usando fetch
  fetch("upload_fondoCabecera.php", {
    // Nombre actualizado del archivo PHP
    method: "POST",
    body: formData,
  })
    .then((response) => {
      // Añadir verificación para asegurarse de que la respuesta es JSON
      if (!response.ok) {
        throw new Error(
          "Error en la respuesta del servidor: " + response.status
        );
      }
      const contentType = response.headers.get("content-type");
      if (!contentType || !contentType.includes("application/json")) {
        // Si no es JSON, convertir a texto para ver el error
        return response.text().then((text) => {
          throw new Error(
            "Respuesta no es JSON: " + text.substring(0, 100) + "..."
          );
        });
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        // Actualizar la imagen con la recién subida (añadiendo timestamp para evitar caché)
        imgContainer.innerHTML =
          '<img src="../img/bg.png?t=' +
          new Date().getTime() +
          '" alt="">';

        // Mensaje de éxito
        alert("Imagen subida correctamente.");
      } else {
        // Mostrar error
        alert("Error al subir la imagen: " + data.message);
        // Restaurar la imagen original
        imgContainer.innerHTML = '<img src="../img/bg.png" alt="">';
      }
    })
    .catch((error) => {
      alert("Error en la subida: " + error);
      // Restaurar la imagen original
      imgContainer.innerHTML = '<img src="../img/bg.png" alt="">';
    });
}

// Función JavaScript para manejar la subida del favicon
function subirFavicon() {
  const inputFavicon = document.getElementById("inputFavicon");
  const file = inputFavicon.files[0];

  if (file) {
    const formData = new FormData();
    formData.append("favicon", file);

    fetch("upload_favicon.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Favicon subido con éxito.");
          // Actualizar la vista previa del favicon
          document.querySelector("#faviconPreview img").src =
            "../img/favicon.png?" + new Date().getTime(); // Agregar timestamp para evitar caché
        } else {
          alert("Error al subir el favicon: " + data.error);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Ocurrió un error inesperado.");
      });
  } else {
    alert("Por favor, selecciona un archivo.");
  }
}
