<div id="resultado-ajax">
</div>
<div id="form_container">
	<form id="form1" class="appnitro" method="post" action="">
		<div class="form_description">
			<h2>Usuarios <img src="<?= base_url() ?>/public/images/icons/group.png" class="icon_accion" id="img_accion"></h2>
			<p>Lista de los usuarios registrados en el sistema</p>
		</div>	
		<div id="tabla_pintada">
		</div>	
		<div id="datatable_container">
		<?= $tabla?>
		</div>
	<br />
	<div id="boton_agregar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>usuario/formulario/' ">Agregar (+)</div>	
	</form>
</div>
<script>

$(function() {
	var oTable = $('#datatable').dataTable({
		"bAutoWidth":false,
		"bJQueryUI": true,
		//"bProcessing": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 15,
		"bScrollCollapse": true
	});
}); 
$(".boton").button(); 
</script>