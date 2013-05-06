<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
	<form id="form1" class="appnitro" method="post" action="" >
		<div class="form_description">
			<h2>Listar / Buscar Registros en Taquilla</h2> 
		</div>
		<fieldset>
			<legend>Valijas Registradas en Taquilla</legend>
			<?= $tabla?>
		</fieldset>			
	</form>
</div>
<script>

function eliminar_en_taquilla(id) {
	$("#dialog:ui-dialog").dialog("destroy");
	$("#dialog").dialog({
		//resizable: true,
		resizable: false,
		//height:180,
		//height:'auto',
		title: 'Atención',
		//width:'auto',
		modal: true,
		buttons: {
			"Borrar el registro": function() {
				$( this ).dialog( "close" );
				//$(row).destroy();
				//$('#tr_'+id).remove();
				$.ajax({
					url:'<?=base_url().'valija/eliminar_en_taquilla/'?>'+id,
					type:'get',
					//data:$('#form1').serialize(),
					success:function(data){ $('#resultado-ajax').html(data) }
				});
			},
			"Cancelar": function() {
				$( this ).dialog( "close" );				
			}
		}
	});
	$('#dialog').html("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span> Este registro será elimiando permanentemente y no podrá ser recuperado. ¿Esta Ud. Seguro?	</p>");
}
	
$(function(){
		$('#datatable').dataTable({
			"bAutoWidth":false,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"iDisplayLength": 10
		});
});
</script>