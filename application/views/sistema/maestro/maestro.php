<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
	<form id="form1" class="appnitro" method="post" action="" style="width:">
		<div class="form_description">
			<h2>Maestros Principales <img src="<?= base_url() ?>/public/images/icons/table.png" class="icon_accion" id="img_accion"></h2> 
			<p>Lista de Tablas</p>
		</div>		
		<br />
		<?= $tabla?>         
	</form>
</div>
<script>
function detalle_maestro (maestro) {
	url = "<?=base_url()?>maestro/detalle/"+maestro;  
	$(location).attr('href',url);  
}
$(function(){
		$('#datatable').dataTable({
			"bAutoWidth":false,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"iDisplayLength": 20
			//"bScrollCollapse": true
		});

});
</script>