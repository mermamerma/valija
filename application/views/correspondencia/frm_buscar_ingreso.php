
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="pdf_ingreso" target="_blank">
	<div class="form_description">
	<h2><?=$momento;?></h2> 
	<p>Formulario</p>
	<?=form_hidden('id') ?>	  
	</div>
	<br />
	<fieldset>
	<legend>Criterio de Busqueda</legend>
			<table width="760" border="0">
			
			<tr>
			  <td colspan="2">
			  		<table width="725" border="0">
					<tr>
					<td width="461">
					<li>
					<label class="description" for="element_2">Índice Interno <span class="required">(*)</span></label>
					<?= form_input('indice_interno','','class="element text medium-form" autofocus')?>
					</li>					</td>
					<td width="254">
					<a onclick="javascript:pasar();"></a>
					<label class="description" for="element_2">Fecha de Ingreso </label>
					<?= form_date_picker('fecha_ingreso','','class="element text medium-form"');?>					</td>
					</tr>
				</table>			  </td>
			  </tr>
			<tr>
				<td colspan="2"><li id="li_titulo" >
				<label class="description">Destinataro </label>
				<?=form_autocomplete('id_destinatario','destinatario',base_url(),'estructura_in'); ?>
				</li>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<li id="li_titulo" >
				<label class="description" for="element_2">Misi&oacute;n de Procedencia </label>
				<?=form_autocomplete('id_mision','mision',base_url(),'misiones'); ?>
				</li>
				</td>
			</tr>			
			<tr>
			  <td colspan="2">
			  <table width="672" border="0">
				<tr>
				<td width="458">
					<li>
					<label class="description">Asunto </label>
					<?=form_textarea('asunto','','class="element textarea custom_correspondencia" style="text-transform: uppercase;" onblur="this.value=this.value.toUpperCase();"')?>
					</li>				</td>
				<td width="204">
					<a onclick="javascript:pasar();"></a>
					<label class="description">Número de Documento</label>
					<?= form_input('numero_documento','','class="element text medium-form"')?>				</td>
			</tr>
						<tr>
				<td colspan="2">
				<li id="li_titulo" >
				<label class="description" for="element_2">Usuario Registrador</label>
				<?=form_autocomplete('id_usuario','usuario',base_url(),'usuarios'); ?>
				</li>
				</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
	</fieldset>
	<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>		       
	<div id="cancelar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>/correspondencia/frm_buscar_ingreso';">Buscar de Nuevo</div>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div id="imprimir_up" class="boton" onclick="javascript:imprimir();" style="visibility:hidden">Generar PDF</div>
	<?=img( array('src' => 'public/images/activityanimation.gif','alt'=>'Procesando','longdesc'=>'Buscando', 'id'=>'activityanimation', 'style'=>'display:none'));?>
	<div id="resultado-ajax">
	</div>	
	<br />		       	
	<div id="imprimir_down" class="boton" onclick="javascript:imprimir();" style="visibility:hidden">Generar PDF</div>
</form>
</div>
<?=ajaxifica('form1','correspondencia/do_buscar_ingreso', $rules, 'activityanimation.gif')?>
<?=$script;?>
<script type="text/javascript">
function imprimir(){
	$('#form1').submit();
}
</script>
