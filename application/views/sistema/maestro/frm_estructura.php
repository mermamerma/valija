<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
<div class="form_description">
<h2><?=$accion;?></h2> 
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
            <label class="description" for="element_2">Nombre de la estructura <span class="required">(*)</span></label>
	        <?= form_input('nombre_estructura','','class="element text extra_large"')?>
            </li>
			</td>
          	</tr>
          	<tr>
            <td>
			<li>
	        <label class="description" for="element_2">Ubicación <span class="required">(*)</span></label>
	        	<?= form_dropdown_db('id_ubicacion', 'ubicaciones');?>
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

