
<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
  <div class="form_description">
      <h2>Editar correspondencia </h2> 
      <p>Formulario</p>
	<?=form_hidden('id',$correspondencia->id); ?>	  
    </div>
	<br />
    <fieldset>
    <legend>Datos de la correspondencia </legend>
    <table width="755" border="0">
      <tr>
        <td>
			<li>
				<label class="description" for="element_2">Procedencia <span class="required">(*)</span></label>
				<?=form_autocomplete('id_remitente','remitente',base_url(),'procedencia',$correspondencia->id_remitente,$correspondencia->remitente); ?>                       			
			</li>		
		</td>
      </tr>

      <tr>
        <td><table width="" border="0">
            <tr>
              <td width="411">
			  	<li>
                	<label class="description" for="element_2">Número <span class="required">(*)</span></label>
	               <?= form_input('numero',$correspondencia->numero,'class="element text medium-form"')?>
    	          </li>
				</td>
              	<td width="250"><label class="description" for="element_2">Fecha de la Correspondencia <span class="required">(*)</span></label>
	                <?= form_date_picker('fecha_correspondencia',$correspondencia->f_correspondencia,'class="element text medium-form"');?>
    	        </tr>           
            <tr>
              <td colspan="2"><table width="663" border="0">
                <tr>
                  <td width="331"><li>
                      <label class="description" for="element_2">Asunto <span class="required">(*)</span></label>
                     <?=form_textarea('asunto',$correspondencia->asunto,'class="element textarea medium"')?>
                  </li></td>
                  <td width="197"><label class="description" for="element_2">Anexos</label>
                      <?=form_textarea('anexos',$correspondencia->anexos,'class="element textarea medium"')?>
                  </td>
                </tr>
              </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
    </fieldset>
    <fieldset>
    <legend>Datos de Ingreso </legend>
    <table width="755" border="0">
      <tr>
        <td colspan="2"><table width="670" border="0">
          <tr>
            <td width="413">
				<li>
					<label class="description" for="element_2">Asignación <span class="required">(*)</span></label>
					<?= form_input('asignacion',$correspondencia->asignacion,'class="element text medium-form"')?>
				</li>
			</td>
            <td width="247"><label class="description" for="element_2">Fecha de Ingreso <span class="required">(*)</span></label>
              <?= form_date_picker('fecha_ingreso',$correspondencia->f_ingreso,'class="element text medium-form"');?>            
			</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="2"><table border="0">
          <tr>
            <td width="412">
				<li><label class="description" for="element_2">Observaciones</label>
				<?=form_textarea('observaciones',$correspondencia->observaciones,'class="element textarea medium"')?>
				</li>			
			</td>
			<td width="250">
			<table width="247" border="0">
              <tr>
                <td><label class="description" for="element_2">Creado  por</label>
                  <div class="bg_amarillo">
                    <?=$correspondencia->usuario?>
                  </div></td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label class="description" for="element_2"> Creado </label>
                  <span class="easydate easydate_valija" title="<?=fecha_legible($correspondencia->creacion)?>">
                  <?=$correspondencia->easydate_c?>
                  </span> </td>
                <td><label class="description" for="element_2">Actualizado</label>
                  <span id="easydate_a" class="easydate easydate_valija" title="<?=fecha_legible($correspondencia->actualizacion)?>">
                  <?=$correspondencia->easydate_a?>
                  </span> </td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
<?=ajaxifica('form1','correspondencia/guardar',$rules)?>
<script>
</script>


