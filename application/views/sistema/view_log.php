<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
	<div class="form_description">
 		<h2>Bitácora del Sistema <img src="<?= base_url() ?>/public/images/icons/bug.png" class="icon_accion" id="img_accion"></h2> 
      <p>Lista de las actividades diarias en el sistema</p>	  
	</div>
	<?php echo $this->table->generate($results); ?>
	<br />	
	<div class="" id="" style="font-weight:bold">Mostrando <?=$inicio?> de un total de <?=$total_rows?> registros</div>
	<br /> 
	<?php echo $this->pagination->create_links(); ?>  	
</form>
</div>
<script>
$(function(){
		$('#datatable').dataTable({
		"bAutoWidth":false,
		"bJQueryUI": true,
		//"bProcessing": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 15,
		"bScrollCollapse": true
		});
});
</script>

