<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
<div class="form_description">
<h2><?=$accion;?>  <img src="<?= base_url() ?>/public/images/icons/picture.png" class="icon_accion" id="img_accion"></h2> 
<p>Formulario</p>
<?=form_hidden('id'); ?>	  
</div>
<fieldset>
<legend>Datos de la ciudad </legend>
	<table width="755" border="0">
		<tr>
		<td>
		<table width="657" border="0">
        	<tr>
            <td>
			<li>
            <label class="description" for="element_2">Nombre de la ciudad <span class="required">(*)</span></label>
	       	<?= form_hidden('id_ciudad', ''); ?>
	        <?= form_input('nombre_ciudad','','class="element text medium-form"')?>
            </li>
			</td>
          	</tr>
          	<tr>
            <td>
			<li>
	        <label class="description" for="element_2">País <span class="required">(*)</span></label>
        	<?=form_autocomplete('id_pais','nombre_pais',base_url(),'paises'); ?>
         	</li>
			</td>
			</tr>
        </table>
		</td>
		</tr>	     
	</table>
</fieldset>
<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>		       
<div id="cancelar" class="boton" onclick="location.href='<?=base_url().'maestro/ciudades/'?>';">Cancelar</div>		       
</form>
</div>
<?=ajaxifica('form1','maestro/procesar_ciudad',$rules)?>
<?=$script;?>

