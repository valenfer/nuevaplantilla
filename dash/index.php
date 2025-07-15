<html lang="es">
<?php
    require_once("php/header.php");
    require_once("php/footer.php");
    cabecera("inicio");
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

    <div class="container">
      
   
      <div class="row mt-3">
        <div class="col-sm-6 row no-gutters mb-3">
          <div class="col-sm-6">
            <div class="list-group ">
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start sombra">
                              <div class="d-flex w-100 justify-content-left p-1">
                                <i class="material-icons md-48">
                                  stars
                                  </i>
                                  <h5 class="mt-2 ml-3">Información</h5>
                                
                              </div>
                             
                             
                            </a>
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start sombra">
                              <div class="d-flex w-100 justify-content-left p-1">
                                <i class="material-icons md-48 text-success">
                                                                 stars
                                                                 </i>
                              <span class="clear ml-3">
                                <h3 class="mb-0 text-success"><?php echo getLeads(); ?></h3>
                                <small class="text-muted text-u-c">Leads</small>
                              </span>
                              </div>
                             
                            </a>
               </div>
          </div>
          <div class="col-sm-6">
            <div class="list-group">
                                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start sombra">
                              <div class="d-flex w-100 justify-content-left p-1">
                                <i class="material-icons md-48 text-danger">
                                                                 stars
                                                                 </i>
                              <span class="clear ml-3">
                                <h3 class="mb-0 text-danger"><?php echo getJugadas(); ?></h3>
                                <small class="text-muted text-u-c">Jugadas</small>
                              </span>
                              </div>
                             
                            </a>
                                  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start sombra">
                              <div class="d-flex w-100 justify-content-left p-1">
                                <i class="material-icons md-48 text-info">
                                                                 stars
                                                                 </i>
                              <span class="clear ml-3">
                                <h3 class="mb-0 text-info"><?php echo getVisitas(); ?></h3>
                                <small class="text-muted text-u-c">Visitas</small>
                              </span>
                              </div>
                             
                            </a>
                          </div>
          </div>
          
        </div>
        <div class="col-md-4 col-sm-8 row no-gutters mb-3">
            <div class="col-sm-12 flex-column text-center bg-warning text-white pt-3 sombra">
                <i class="material-icons md-48 op-7">
                card_giftcard
                </i>
                <h6 class="text-white mb-4 op-7">PREMIOS</h6>
            </div>
            <div class="col-sm-4 text-center bg-white pt-3 pb-2 border-right sombra">
              <span class="clear">
                <h3 class="mb-0 text-primary"><?php echo getPrimerosPremios(); ?></h3>
                <small class="text-muted text-u-c">Primeros</small>
             </span>
            </div>
            <div class="col-sm-4 text-center bg-white pt-3 border-right sombra">
              <span class="clear">
                <h3 class="mb-0 text-primary"><?php echo getSegundosPremios(); ?></h3>
                <small class="text-muted text-u-c">Segundos</small>
             </span>
            </div>
            <div class="col-sm-4 text-center bg-white pt-3 sombra">
             <span class="clear">
                <h3 class="mb-0 text-primary"><?php echo getPrimerosPremios()+getSegundosPremios(); ?></h3>
                <small class="text-muted text-u-c">Totales</small>
             </span>
            </div>
               
            </div>
        <div class="col-sm-2 row no-gutters  mb-3">
          <div class="col-sm-12 flex-column text-center <?php echo $claseEstado; ?> text-white pt-3 sombra">
              <i class="material-icons md-48 op-7">
              flag
              </i>
              <h6 class="text-white mb-2 op-7">ESTADO</h6>
          </div>
          <div class="col-sm-12 text-center bg-white pt-3 border-right sombra">
            <span class="clear">
             <h5><?php echo $estado; ?></h5>
           </span>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    
  
    <div class="row">
      <!--ZONA CARD-->
      
        <div class="col-sm-12">

      <div class="card">
        <h5 class="card-header">Jugadas</h5>
        <div class="card-body">

          <table class="table table-responsive table-hover" style="width:100% !important;" id="tabla_leads_gan"> 
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nombre</th>
                      <th scope="col">Premio</th>
                      <th scope="col">Código de Juego</th>                     
                    </tr>
                  </thead>
                  <?php tablaDatosGanadores(); ?>
            </table>

          
        </div>
      </div>
    
    </div>

      <!--FINAL CONTAINER-->
    </div>
 <script type="text/javascript">
  $('#tabla_leads_gan').DataTable();
 </script>
<?php
    footer();
?>
</body>
</html>