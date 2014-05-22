<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
	<div class="form_description">
	<h2 id="momento"><?=$momento;?> <img src="<?= base_url() ?>/public/images/icons/email_open.png" class="icon_accion" id="img_accion"></h2> 
	<p>Formulario</p>
	<?=form_hidden('id'); ?>	  
	</div>
	<br />
	<fieldset>
	<legend>Datos de la Relación </legend>
			<table width="760" border="0">
			<tr>
			<td colspan="2"><table width="749" border="0">
			<tr>
			<td width="459">
			<li>
			<label class="description" for="element_2">Índice Interno <span class="required">(*)</span></label>
			<?= form_input('indice_interno','','class="element text medium-form" autofocus')?>
			</li>
			</td>
			<td width="280">
			<a onclick="javascript:pasar();"></a>
			<label class="description" for="element_2">Fecha de Ingreso <span class="required">(*)</span></label>
			<?= form_date_picker('fecha_ingreso','','class="element text medium-form"');?>
			</td>
			</tr>
			</table></td>
			</tr>
			<tr>
			<td colspan="2"></td>
			</tr>
			</table>
	</fieldset>
	<fieldset>
	<legend>Datos de la Correspondencia </legend>
			<table width="760" border="0">
			<tr>
			<td colspan="2">
				<li id="li_titulo" >
				<label class="description" for="element_2">Misi&oacute;n de Procedencia <span class="required">(*)</span></label>
				<?=form_autocomplete('id_mision','mision',base_url(),'misiones'); ?>
			</li>			</td>
			</tr>
			
			<tr>
			  <td colspan="2">
			  <table width="672" border="0">
				<tr>
				<td width="458">
					<li>
					<label class="description">Asunto <span class="required">(*)</span></label>
					<?=form_textarea('asunto','','class="element textarea custom_correspondencia" style="text-transform: uppercase;" onblur="this.value=this.value.toUpperCase();"')?>
					</li>				</td>
				<td width="204">
					<a onclick="javascript:pasar();"></a>
					<label class="description">Número Ingreso <span class="required">(*)</span></label>
					<?= form_input('numero_ingreso','','class="element text medium-form"')?>				</td>
			</tr>
			</table>			</td>
			</tr>		
			<tr>
			<td colspan="2"><li id="li_titulo" >
			<label class="description">Destinataro <span class="required">(*)</span></label>
			<?=form_autocomplete('id_destinatario','destinatario',base_url(),'estructura_in'); ?>
			</li></td>
			</tr>
			<tr>
			  <td><table width="753" border="0">
                <tr>
                  <td width="458"><li id="li_tipo_registro" >
                      <label class="description">Índice del Remitente <span class="required">(*)</span></label>
                      <?= form_input('indice_remitente','','class="element text medium-form"')?>
                  </li></td>
                  <td width="285"><label class="description">Fecha Correspondencia </label>
                      <?= form_date_picker('fecha_correspondencia');?>                  </td>
                </tr>
              </table></td>
			  </tr>
			<tr>
			<td><table width="753" border="0">
              <tr>
                <td width="458">
					<li id="li_tipo_registro" >
					<label class="description">Tipo de Documento <span class="required">(*)</span></label>
                    <?= form_dropdown_db('id_tipo_documento', 'tipo_documento');?>
					</li>
				</td>
                <td width="285">
					<label class="description">Numero de Documento</label>
					<?= form_input('numero_documento','','class="element text medium-form"')?>	
				</td>
              </tr>
            </table></td>
			</tr>
			<tr>
			<td>
			<table width="753" border="0">
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			<td width="263">
				<li>
				<label class="description">Entrada</label>
				<span>
				<input type="radio" value="T" class="element radio" name="entrada" id="entrada_t">
				<label class="choice">Taquilla </label>
				<input type="radio" value="V" class="element radio" name="entrada" id="entrada_v">
				<label class="choice">Valija </label>
				</span></li>			</td>
			<td width="240">			
				<li>
				<label class="description">Anexo</label>
				<span>
				<input type="radio" value="S" class="element radio" name="anexo" id="anexo_si">
				<label class="choice">Si </label>
				<input type="radio" value="N" class="element radio" name="anexo" id="anexo_no">
				<label class="choice">No </label>
				</span></li>				</td>
			<td width="236">
				<label class="description">Observaciones &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="javascript:setAnexoConforme();">Anexo Conforme
				<img src="<?=base_url();?>/public/images/conforme.png" alt="Anexo Conforme" style="vertical-align:middle" /></a>				</label> 
				<?=form_textarea('observaciones','','class="element textarea medium" style="width:450px; text-transform: uppercase;" onblur="this.value=this.value.toUpperCase();"')?>			</td>
			</tr>
			</table></td>
			</tr>
			</table>
			<table id="meta_data" width="758" border="0" style="display:none">     
				<br />           
				<tr>
				<td width="278"><li id="li_tipo_registro">
				<label class="description">Creado  por</label>
				<div class="bg_amarillo" id="usuario"></div>
				</li></td>
				<td width="250"><label class="description">Creado</label>
				<span class="easydate easydate_valija" title="" id="fecha_c"></span>
				</td>
				<td width="210"><label class="description">Actualizado</label>
				<span class="easydate easydate_valija" title="" id="fecha_a"></span>
				</td>
				</tr>
			</table>
	</fieldset>
	<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>
	&nbsp;&nbsp;&nbsp;
	<div id="cancelar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>';">Cancelar</div>
	&nbsp;&nbsp;&nbsp;
	<div id="nuevo" class="boton" onclick="javacript:restablecer();">Nuevo</div>
</form>
</div>
<?=ajaxifica('form1','correspondencia/guardar',$rules)?>
<?=$script;?>
<script>
function restablecer () {
	fecha_ingreso = $('#fecha_ingreso').val();
	$('#form1').each (function(){
		this.reset();
	});
	$(document).ready(function (){
		$('input:radio[name=entrada]').filter('[value=V]').attr('checked', true);
		$('input:radio[name=anexo]').filter('[value=S]').attr('checked', true);
	});
	$('#fecha_ingreso').val(fecha_ingreso);
	$('#id').val('');
	$('#meta_data').hide();
	$('#momento').html('Registrar Correspondencia');	
}
function setAnexoConforme () {
	if ($('#observaciones').val() == '')
		$('#observaciones').val('ANEXO CONFORME') ;
	else if ($('#observaciones').val() != 'ANEXO CONFORME')
		$('#observaciones').val('ANEXO CONFORME\n'+$('#observaciones').val());
	
}
</script>


