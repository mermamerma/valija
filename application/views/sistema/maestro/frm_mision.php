<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
<div class="form_description">
<h2><?=$accion;?></h2> 
<p>Formulario</p>
<?=form_hidden('id_mision'); ?>	  
</div>
<fieldset>
<legend>Datos de la misión </legend>
	<table width="755" border="0">
		<tr>
		<td>
		<table width="657" border="0">
        	<tr>
        	  <td colspan="2">
			  		<li>
					<label class="description" for="element_2">País / Ciudad <span class="required">(*)</span></label>
	            <?=form_autocomplete('id_ciudad','nombre_ciudad',base_url(),'ciudades'); ?>
					</li>				</td>
        	  </tr>
        	<tr>
        	  <td>&nbsp;</td>
        	  <td>&nbsp;</td>
      	  </tr>
        	<tr>
        	  <td width="363"><li><label class="description" for="element_2">Tipo de Misión <span class="required">(*)</span></label>
             <?= form_dropdown_db('id_tipo_mision', 'tipo_mision');?>
				 </li>				 </td>
        	  <td width="284">
			  		<li>
			  		<label class="description" for="element_2">Número de Expediente </label>
             	<?= form_input('nro_expediente','','class="element text medium-form"')?>
					</li>				</td>				
      	  </tr>
        	<tr>
        	  <td>&nbsp;			  </td>
        	  <td>&nbsp;</td>
      	  </tr>
        </table>
		</td>
		</tr>	     
	</table>
</fieldset>
<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>		       
<div id="cancelar" class="boton"  onclick="location.href='<?=base_url().'maestro/misiones/'?>';">Cancelar</div>		       
</form>
</div>
<?=ajaxifica('form1','maestro/procesar_mision',$rules)?>
<?=$script;?>

