<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
	<div class="form_description">
 		<h2>Listar Correspondencias</h2> 
      <p>Lista de las correspondencias registradas</p>	  
	</div>
	<?php echo $this->table->generate($results); ?>
	<br />	
	<div class="" id="" style="font-weight:bold">Mostrando <?=$inicio?> de un total de <?=$total_rows?> registros</div>
	<br />
	<?php echo $this->pagination->create_links(); ?>
</form>
</div>

<script>
var oTable = $('#datatable').dataTable({ 
	"bRetrieve" :true,
	"bPaginate": false,
	"bJQueryUI": true,
	"sPaginationType": "full_numbers",
	"iDisplayLength": 10,
	"sScrollX": "80%",
	"bDestroy": true,
	"aaSorting": [[ 0, "desc" ]],
	"bScrollCollapse": true
});



function eliminar(id, pos) {
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
					url:'<?=base_url().'correspondencia/eliminar/'?>'+id,
					type:'get',
					//data:$('#form1').serialize(),
					success:function(data){ $('#resultado-ajax').html(data); }
				});
			},
			"Cancelar": function() {
				$( this ).dialog( "close" );				
			}
		}
	});
	$('#dialog').html("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span> Este registro sera elimiando permanentemente y no podrá ser recuperado. ¿Esta Ud. Seguro?	</p>");
}

$(document).ready(function() {
  // Instrucciones a ejecutar al terminar la carga
  //alert ('¡Ejecuto cunado cargo!');
});
</script>

	
	