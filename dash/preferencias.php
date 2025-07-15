<html lang="es">
<?php
    require_once("php/header.php");
    require_once("php/footer.php");
    cabecera("preferencias");
    /*$estado = "EN CURSO";
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
*/
   
 

?>
  <div class="modal fade" id="modalVisual" tabindex="-1" role="dialog" aria-labelledby="modalVisualTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalVisualTitle">Previsualización</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cerrar</button>
          
        </div>
      </div>
    </div>
  </div>
    <div class="container">
      
      
      <div class="card mt-3">
        <div class="card-body p-5">

          <h4>Ajustes de la promoción</h4>
          <form method="POST" action="./preferencias.php" id="form_cliente">
          <input name="form_cliente" class="d-none">
          <div class="form-group row">
              <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Cliente</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="cliente" name="n_empresa" placeholder="Nombre del cliente" value="<?php echo $nombreEmpresa; ?>" required>
              </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Nombre Promo</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nombre-promo" name="n_promo" placeholder="Nombre de la promoción" value="<?php echo $nombrePromo; ?>" required>
                </div>
              </div>

              <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Fin de la promo</label>
                  <div class="col-sm-9">
                    <input type="date" class="form-control" id="fechaFin" placeholder="Fecha fin" name="f_promo" value="<?php echo $fechaFin; ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Minutos entre premios</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="minutos" placeholder="Minutos premio" name="minutos" value="<?php echo $minutos; ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Apertura de la promoción</label>
                      <div class="col-sm-9">
                        <input type="time" class="form-control" id="horaAp" placeholder="Minutos premio" name="horaAp" value="<?php echo $horaAp; ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Cierre de la promoción</label>
                        <div class="col-sm-9">
                          <input type="time" class="form-control" id="horac" placeholder="Minutos premio" name="horac" value="<?php echo $horaC; ?>" required>
                        </div>
                      </div>
                <div class="row">
                  <div class="col-sm-3"></div>
                  <div class="col-sm-9">
                    <button type="submit" class="btn btn-outline-primary"><i class="material-icons">save</i>Guardar cambios</button>
                  </div>
                </div>
              </form>
              
              <form method="POST" action="./preferencias.php" id="form_mail">
                <input name="form_mail" class="d-none">
              <h4 class="mt-5">Ajustes de Correos Electrónicos</h4>
              <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Remitente</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="remitente" id="remitente" placeholder="Correo que aparecerá en el remitente al contactar con el ganador" value="<?php echo $mailEmpresa; ?>">
                  </div>
                </div>
                <h5 class="mt-5">Correo Ganador</h5>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Asunto del correo ganador</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="asunto_mail" id="asunto-mail" placeholder="Asunto del correo ganador" value="<?php echo $asuntoMail; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Texto correo ganador<button type="button" class="btn btn-secondary btn-block previsual" idc="text-mail-ganador">Previsualizar</button></label>

                      <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="text_ganador" id="text-mail-ganador" placeholder="Texto para el correo ganador" ><?php echo $txtMailGanador; ?></textarea>
                      </div>
                    </div>
                    <h5 class="mt-5">Correo no Ganador</h5>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Asunto del correo no ganador</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="asunto_perdedor" id="asunto-mail-p" placeholder="Asunto del correo no ganador" value="<?php echo $asuntoMailPerdedor; ?>">
                        </div>
                      </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Texto correo no ganador<button type="button" class="btn btn-secondary btn-block previsual" idc="text-mail-p">Previsualizar</button></label>
                        <div class="col-sm-9">
                          <textarea type="text" class="form-control" id="text-mail-p" name="text_perdedor" placeholder="Texto para el correo no ganador" ><?php echo $txtMailPerdedor; ?></textarea>
                        </div>
                      </div>
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Texto de LGPD</label>
                      <div class="col-sm-9">
                        <textarea type="text" class="form-control" id="info-lgpd" name="lgpd" placeholder="Texto para la LGPD al final del correo" ><?php echo $infoLegal; ?></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3"></div>
                      <div class="col-sm-9">
                        <button type="submit" class="btn btn-outline-primary"><i class="material-icons">save</i>Guardar cambios</button>
                      </div>
                    </div>
                  </form>
                  <form>
                  <h4 class="mt-5">Otros ajustes</h4>
              <fieldset class="form-group">
                  <div class="row">
                    <legend class="col-form-label col-sm-3 pt-0 text-uppercase">Activar códigos</legend>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioCodigo" id="radioCodigo" value="1" <?php echo $checked1;?>>
                        <label class="form-check-label" for="gridRadios1">
                          Si
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioCodigo" id="radioCodigo2" value="0" <?php echo $checked2;?>>
                        <label class="form-check-label" for="radioCodigo2">
                         No
                        </label>
                      </div>
                      
                    </div>
                  </div>
                </fieldset>

                <fieldset class="form-group">
                    <div class="row">
                      <legend class="col-form-label col-sm-3 pt-0 text-uppercase">Repetir participación</legend>
                      <div class="col-sm-9">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gridRadios" id="radioMulti" value="1" <?php echo $checked3;?>>
                          <label class="form-check-label" for="radioMulti">
                            Si
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="gridRadios" id="radioMulti2" value="0" <?php echo $checked4;?>>
                          <label class="form-check-label" for="radioMulti2">
                           No
                          </label>
                        </div>
                        
                      </div>
                    </div>
                  </fieldset>
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label font-weight-bold text-uppercase">Color principal</label>
                      <div class="col-sm-9">
                        <input type="color" id="color" value="<?php echo $color;?>">

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3"></div>
                      <div class="col-sm-9">
                        <button type="submit" class="btn btn-outline-primary"><i class="material-icons">save</i>Guardar cambios</button>
                      </div>
                    </div>
                  </form>
                  
                 
        </div>
      </div>
    </div>
    <section id="carga" style="background-color:black;">
     
      <div class="pl-spinner">
                  <div class="pl-spinner-bubble"></div>
                  <div class="pl-spinner-bubble2"></div>
              </div>
    </section>
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
