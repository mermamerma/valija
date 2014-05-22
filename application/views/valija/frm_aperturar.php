<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
  <div class="form_description">
      <h2><?=$momento;?> <img src="<?= base_url() ?>/public/images/icons/box_down.png" class="icon_accion" id="img_accion"></h2> 
      <p>Formulario</p>
	<?=form_hidden('id'); ?>	  
    </div>
    <fieldset>
    <legend>Datos de la Valija </legend>
    <table width="755" border="0">
      
      <tr>
        <td>
		<li id="li_titulo" >
            <label class="description" for="element_2">Misión <span class="required">(*)</span></label>
            <?=form_autocomplete('id_mision','mision',base_url(),'misiones'); ?>
        </li>		</td>
      </tr>

      <tr>
        <td><table width="756" border="0">
            <tr>
              <td width="407">
			  	<li>
                	<label class="description" for="element_2">Indice <span class="required">(*)</span></label>
	                <?= form_input('indice_valija','','class="element text medium-form"')?>
              </li>				</td>
           	  <td width="328">
			  	<label class="description" for="element_2">Tipo de Valija <span class="required">(*)</span></label>
              <?= form_dropdown_db('id_tipo_valija', 'tipo_valija');?>			  </td>
   	        </tr>           
            <tr>
              <td>
			  	<li>
              		<label class="description" for="element_2">Estatus <span class="required">(*)</span></label>
		            <?= form_dropdown_db('id_estatus_valija', 'estatus_valija','onchange=javacript:cambio_estatus();');?>
		 	    </li>			  </td>
			  <td>
			  <div id="div_fecha_anuncio" style="display:none">
			  	<label class="description" for="element_2">Fecha de Anuncio <span class="required">(*)</span></label>
                <?= form_date_picker('fecha_anuncio','','class="element text medium"');?></div>
			  <div id="div_fecha_recibido" style="display:none">
			  	<label class="description" for="element_2">Fecha de Recibido <span class="required">(*)</span></label>
                <?= form_date_picker('fecha_recibido','','class="element text medium"');?>
			  </div>			  </td>
            </tr>
            
            <tr>
              <td colspan="2">			  </td>
            </tr>
            <tr>
              <td colspan="2"><table width="657" border="0">
                <tr>
                  <td width="411"><li>
                      <label class="description" for="element_2">Presilla </label>
                      <?= form_input('presilla','','class="element text medium-form"')?>
                  </li></td>
                  <td width="236"><label class="description" for="element_2">Peso </label>
                      <?= form_input('peso','','class="element text medium-form"')?></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2"><table width="657" border="0">
                <tr>
                  <td width="411"><li>
                      <label class="description" for="element_2">Número de Candado </label>
                      <?= form_input('num_candado','','class="element text medium-form"')?>
                  </li></td>
                  <td width="236"><label class="description" for="element_2">Courrier <span class="required">(*)</span></label>
                  <?= form_dropdown_db('id_courrier', 'courriers');?>				  </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2"><table width="657" border="0">
                <tr>
                  <td width="411"><li>
                      <label class="description" for="element_2">Guía <span class="required">(*)</span></label>
                      <?= form_input('num_guia','','class="element text medium-form"')?>
                  </li></td>
                  <td width="236"><label class="description" for="element_2">Contenido <span class="required">(*)</span></label>
                      <?= form_dropdown_db('id_tipo_contenido', 'tipo_contenido');?>                  </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2"><table width="657" border="0">
                <tr>
                  <td width="411"><li>
                      <label class="description" for="element_2">Número de Caja(s) <span class="required">(*)</span></label>
                      <?= form_input('num_cajas','','class="element text medium-form"')?>
                  </li></td>
                  <td width="236"><label class="description" for="element_2">Número de Saco(s) <span class="required">(*)</span></label>
                      <?= form_input('num_sacos','','class="element text medium-form"')?>                  </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2"><table width="657" border="0">
                <tr>
                  <td width="412">
					<li>
						<label class="description" for="element_2">Piezas <span class="required">(*)</span></label>
						<?= form_input('num_piezas','','class="element text medium-form"')?>
					</li>				  </td>
                  <td width="235">&nbsp;</td>
                </tr>
              </table>			  </td>
            </tr>
            
            <tr>
              <td colspan="2"><table width="659" border="0">
                <tr>
                  <td>
				  	  <li>
                      <label class="description" for="element_2">Observaciones</label>
                      <?=form_textarea('observaciones','','class="element textarea medium" style="width:450px"')?>
                  	  </li>
				  </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2">
			  <table id="meta_data" width="" border="0" style="display:none">                
                <tr>
                  <td width="278"><li id="li_tipo_registro">
                      <label class="description" for="element_2">Creado  por</label>
                      <div class="bg_amarillo" id="usuario">
                        
                      </div>
                  </li></td>
                  <td width="250"><label class="description" for="element_2">Creado</label>
                  <span class="easydate easydate_valija" title="" id="fecha_c">
     				
                  </span>
				  </td>
                  <td width="210"><label class="description" for="element_2">Actualizado</label>
                    <span class="easydate easydate_valija" title="" id="fecha_a">
                       
                    </span>
				  </td>
                </tr>
              </table>
			  </td>
            </tr>            
          </table>
	    </td>
      </tr>
    </table>
    </fieldset>
	<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>		       
	<div id="cancelar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>';">Cancelar</div>		       
  </form>
</div>
<?=ajaxifica('form1','valija/aperturar',$rules)?>
<script>
function mostrar_fechas () {
	fecha_a = $('#fecha_anuncio').val( );
	fecha_r = $('#fecha_recibido').val( );
	if (fecha_a != '')
		$('#div_fecha_anuncio').show(); 

	if (fecha_r != '')
		$('#div_fecha_recibido').show(); 
	 
}
function cambio_estatus () {
	valor = $('#id_estatus_valija').val( );
	if (valor == 1 || valor == 3 ) {
		$('#fecha_recibido').val('');		
		$('#div_fecha_recibido').hide('blind',500); 	
		$('#div_fecha_anuncio').show('blind',500); 
	}
	else if (valor == 2) {	
		$('#fecha_anuncio').val('');	
		$('#div_fecha_anuncio').hide('blind',500); 		
		$('#div_fecha_recibido').show('blind',500); 		
	}
	else if (valor == '') {	
		$('#fecha_anuncio').val('');
		$('#fecha_recibido').val('');
		$('#div_fecha_anuncio').hide('blind',500); 		
		$('#div_fecha_recibido').hide('blind',500);	
	}
	
}
</script>
<?=$script;?>

