<html lang="es">
<?php
    require_once("php/header.php");
    require_once("php/footer.php");
    cabecera("premios");
    $estado = "EN CURSO";
    $claseEstado = "bg-success";
    if(!$valEstado){
      $estado = "TERMINADA";
      $claseEstado = "bg-danger";
    }

    $checked1 ="";
    $checked2 ="";
    $checked3 ="";
    $checked4 ="";

    if($codigo){
      $checked1="checked";
    } else {
      $checked2="checked";
    }

    if($variasParticipaciones){
      $checked3="checked";
    } else {
      $checked4="checked";
    }

?>
<section id="carga" style="background-color:black;">
 
  <div class="pl-spinner">
              <div class="pl-spinner-bubble"></div>
              <div class="pl-spinner-bubble2"></div>
          </div>
</section>


<!-- Modal -->
<div class="modal animated zoomIn" id="modalEditarPremio" tabindex="-1" role="dialog" aria-labelledby="modalEditarPremioTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar premio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <center class="cargando"><img src="img/cargando.svg"></center>
      <div class="modal-body d-none">
      
        
      </div>

    </div>
  </div>
</div>
    <div class="container">
      <h4 class="mt-5">Momentos ganadores</h4>
      <div class="row">
        <div class="col-12">
            <div class="list-group">
              <ul class="list-group list-group-flush" id="lista-momentos">
                  <?php listaMomentos(); ?>
               
              </ul>
              <button type="button" class="list-group-item list-group-item-action text-center" id="a-momento"> <i class="material-icons">add</i> Añadir</button>
            </div>

        </div>
      </div>
      <h4 class="mt-5">Premios</h4>
      <div class="row">
        <div class="col-sm-3">
          <div class="fondo-segundo rounded bloque text-center">
            <div class="contenido">
               <i class="material-icons icono-grande">
                            add

              </i>
              <p>AÑADIR</p>
            </div>
           
          </div>
        
        </div>
        <?php
          $c = consulta("select * from premios");
          if(!empty($c)){
            foreach($c as $valor){
              extract($valor);
              echo ' <div class="col-sm-3">';
                echo '<div class="premio bloque rounded p-3" idp="'.$id.'">';
                echo '<div class="imagen-premio rounded" style="background-image:url(../img/premios/'.$img.')"></div>';
                echo '<h6 class="mt-2">'.$nombre.'</h6>';
                echo $cantidad.' UNIDADES';
                echo '<p><small>Nivel '.$nivel.'</small></p>';
                echo '</div>';

              echo '</div>';
            }
          }

        ?>
      </div>
      
   
    
    </div>
    <?php
      $cmensaje="d-none";
      if(isset($_GET["s"])){
        $cmensaje="";
      }

    ?>
    <div class="mensaje animated fadeInRight fast bg-success text-white <?php echo $cmensaje; ?>">
        Los cambios han sido guardados.
      </div>

<?php
    footer();
?>
</body>
</html>
