<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
<div class="form_description">
<h2><?=$accion;?> <img src="<?= base_url() ?>/public/images/icons/chart_organisation.png" class="icon_accion" id="img_accion"></h2> 
<p>Formulario</p>
<?=form_hidden('id_estructura'); ?>	  
</div>
<fieldset>
<legend>Datos de la estructura </legend>
	<table width="755" border="0">
		<tr>
		<td>
		<table width="657" border="0">
        	<tr>
        	  <td>
				<li>
				<label class="description" for="element_2">Código Unidad Administrativa <span class="required">(*)</span></label>
				<?= form_input('cod_uni_admi','','class="element text extra_large"')?>
				</li>

			  </td>
      	  </tr>
        	<tr>
        	  <td>
			    <li>
				<label class="description" for="element_2">Código Unidad Adscripción <span class="required">(*)</span></label>
				<?= form_input('cod_uni_adsc','','class="element text extra_large"')?>
				</li>
			  </td>
      	  </tr>
        	<tr>
            <td>
				<li>
				<label class="description" for="element_2">Nombre de la Estructura <span class="required">(*)</span></label>
				<?= form_input('nombre_estructura','','class="element text extra_large"')?>
				</li>
			</td>
          	</tr>
        </table>
		</td>
		</tr>	     
	</table>
</fieldset>
<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>		       
<div id="cancelar" class="boton" onclick="location.href='<?=base_url().'maestro/estructuras/'?>';">Cancelar</div>		       
</form>
</div>
<?=ajaxifica('form1','maestro/procesar_estructura',$rules)?>
<?=$script;?>

