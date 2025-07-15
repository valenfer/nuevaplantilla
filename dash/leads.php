<html lang="es">
<?php
    require_once("php/header.php");
    require_once("php/footer.php");
    cabecera("leads");
    $estado = "EN CURSO";
    $claseEstado = "bg-success";
    if(!$valEstado){
      $estado = "TERMINADA";
      $claseEstado = "bg-danger";
    }
?>   <section id="carga" style="background-color:black;">
         
          <div class="pl-spinner">
                      <div class="pl-spinner-bubble"></div>
                      <div class="pl-spinner-bubble2"></div>
                  </div>
        </section>

  <div class="container-fluid mt-2">
    
  
    <div class="row">
      <!--ZONA CARD-->
      
        <div class="col-sm-12">

      <div class="card">
        <h5 class="card-header">Jugadas</h5>
        <div class="card-body">

          <table class="table table-responsive table-hover" id="tabla_leads"> 
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Premio</th>
                      <th scope="col">Teléfono</th>
                      <th scope="col">Email</th>
                      <th scope="col">Edad</th>
                      <th scope="col">Municipio</th>
                      <th scope="col">Dirección</th>
                      <th scope="col">Código Postal</th>
                      <th scope="col">Fecha Jugada</th>
                      <th scope="col">Canjeado</th>
                      <th scope="col">Código de Juego</th>
                      <th scope="col">Código de Canjeo</th>
                      <th scope="col">Mail Enviado</th>
                    </tr>
                  </thead>
                  <?php tablaDatos(); ?>
            </table>

          
        </div>
      </div>
    
    </div>

      <!--FINAL CONTAINER-->
    </div>
 
<?php
    footer();
?>
</body>
</html>