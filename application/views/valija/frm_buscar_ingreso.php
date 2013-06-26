<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" >
    <div class="form_description">
      <h2>Buscar Valija Registrada en Taquilla</h2> 
      <p>Formulario      </p>	  
    </div>
    <fieldset>
    <legend>Críterio de Busqueda </legend>
    <table width="752" border="0">
      <tr>
        <td>
		<li id="li_titulo" >
            <label class="description" for="element_2">Buscar Por </label>
			<?=form_dropdown('criterio', $options,'','onchange=javacript:cambio_criterio();'); ?>	           
        </li>		</td>
      </tr>
    </table>
    </fieldset>
    <fieldset id="contenedor" style="display:none">
    <legend>Que contenga</legend>
	 <table width="747" border="0">
      <tr id="tr_estatus" style="display:none">
         <td>
			  	<li id="li_tipo_registro" >
				<label class="description" for="element_2">Estatus</label>
				<?= form_dropdown_db('id_estatus_valija', 'estatus_valija');?>           
				</li>
			</td>
      </tr>
      
      <tr id="tr_fecha_anuncio" style="display:none">
        <td>
		  		<li id="li_tipo_registro" >
           <label class="description" for="element_2">Fecha de Anuncio </label>
           <?= form_date_picker('fecha_anuncio');?>            
           </li>			
			</td>
      </tr>
		      <tr id="tr_fecha_recepcion"  style="display:none">
        <td>
		  		<li id="li_tipo_registro" >
           <label class="description" for="element_2">Fecha de Recibido </label>
           <?= form_date_picker('fecha_recepcion');?>            
           </li>			
			</td>
      </tr>
      <tr id="tr_mision"  style="display:none">
        <td><li id="li_titulo" >
            <label class="description" for="element_2">Misión </label>
            <?=form_autocomplete('id_mision','mision',base_url(),'misiones'); ?>
        </li>		</td>
      </tr>
      <tr id="tr_fecha_desde_hasta"  style="display:none">
        <td><table width="741" border="0">
          <tr>
            <td width="364">
					<li id="li_tipo_registro" >
					<label class="description" for="element_2">Desde la Fecha</label>
					<?= form_date_picker('fecha_desde');?>            
					</li>				</td>
            <td width="367">
					<li id="li_tipo_registro" >
					<label class="description" for="element_2">Hasta la Fecha</label>
					<?= form_date_picker('fecha_hasta');?>            
					</li>				</td>
          </tr>
        </table></td>
      </tr>
    </table>
    </fieldset>  
	 <div id="resultado">
	 </div> 	
	<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  	
	<div id="cancelar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>';">Cancelar</div>	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<div id="cancelar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>valija/generar_pdf';">Generar PDF</div>	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<br /><br />  
	<fieldset id="fieldset_resultado" style="display:none">
		<legend>Resultados de la Busqueda</legend>
		<br>
		<div id="div_resultado"></div>
	</fieldset>
	</form>
</div>
<script type="text/javascript">
function cambio_criterio () {
	criterio = $('#criterio').val();	
	$('#tr_mision').hide();
	$('#tr_fecha_anuncio').hide();
	$('#tr_fecha_recepcion').hide();
	$('#tr_fecha_desde_hasta').hide();
	$('#tr_estatus').hide();
	$('#form1').each(function(){this.reset();});
	$('#criterio').val(criterio);	
	switch (criterio) {
		case '': 
			$('#contenedor').hide('blind',500);
			break 	
		case 'mision': 
			$('#contenedor').show('blind',500);
			$('#tr_mision').show('blind',500);
			$('#tr_fecha_desde_hasta').show('blind',500);
			$("#id_mision").rules("add", "required");
			break
		case 'periodo': 
			$('#contenedor').show('blind',500);
			$('#tr_fecha_desde_hasta').show('blind',500);
			break
		case 'f_anuncio': 
			$('#contenedor').show('blind',500);
			$('#tr_fecha_anuncio').show('blind',500);
			break
		case 'f_recepcion': 
			$('#contenedor').show('blind',500);
			$('#tr_fecha_recepcion').show('blind',500);
			break
		case 'estatus': 
			$('#contenedor').show('blind',500);
			$('#tr_estatus').show('blind',500);
			$('#tr_fecha_desde_hasta').show('blind',500);
			break
	}	
}
</script>
<?=ajaxifica('form1','valija/buscar_ingreso',$rules)?>
<?=$script;?>
