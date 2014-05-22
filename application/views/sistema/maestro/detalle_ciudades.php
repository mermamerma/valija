<div id="resultado-ajax">
</div>
<div id="form_container">
	<form id="form1" class="appnitro" method="post" action="">
		<div class="form_description">
			<h2>Maestro  <img src="<?= base_url() ?>/public/images/icons/picture.png" class="icon_accion" id="img_accion"></h2> 
			<p>Lista de Ciudades</p>
		</div>	
		<div id="tabla_pintada">
		</div>	
		<div id="datatable_container">
		<?= $tabla?>
		</div>
	<br />
	<div id="boton_agregar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>maestro/frm_ciudad';">Agregar (+)</div>	         		
	<div id="boton_volver" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>maestro/ciudades/';">Recargar Tabla</div>		
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   		
	</form>
</div>
<script>

	

$(function() {
	var oTable = $('#datatable').dataTable({
		"bAutoWidth":false,
		"bJQueryUI": true,
		//"bProcessing": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 20,
		"bScrollCollapse": true
	});
	$(".boton").button();
});
</script>
