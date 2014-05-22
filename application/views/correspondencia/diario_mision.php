<div id="resultado-ajax">
<table id="dataTable"  cellspacing="1"  class="display">
	<thead>
		<tr  bgcolor="#999999;" style="font-weight:bold" >
		<th>Misión de Procedencia</th>
		<th>Cantidad</th>		
		</tr>
	</thead>
	<tbody>
	{diario}
	<tr>
		<td>{mision}</td>
		<td>{cantidad}</td>		
	</tr>
	{/diario}
	</tbody>
</table>
	<br />
	<span id="aceptar" class="boton" onclick="javacript:pdf_diario_mision();">Generar PDF</span>
<script>
$(function() {	
	$('#form1').validate({
		rules:{				
			// fecha_ingreso_desde : { required:true, dateDE: true  }, fecha_ingreso_hasta : { required:true, dateDE: true  }
			fecha_ingreso_desde : { dateDE: true  }, fecha_ingreso_hasta : { dateDE: true  }
		}}
	);	
});
var oTable = $('#dataTable').dataTable({ 
	"bAutoWidth":false,
	"bJQueryUI": true,
	"sPaginationType": "full_numbers",
	"iDisplayLength": 20	
});
function enviar (){
	$('#boton_buscar').hide();
	$('#boton_restablecer').hide();
	$('#tr_titulo_reporte').hide();
	$('#resultado-ajax').html('');
	$('#modo').val('');
	$('#botones_hay').css("visibility","hidden");
	if($('#form1').valid()){		
		$("#progress_bar").show('slide');
		$.ajax({
				url:'<?=base_url()?>correspondencia/buscar_diario_mision',
				type:'post',
				data:$('#form1').serialize(),
				success:function(data){ 
					$('#boton_buscar').show();
					$('#boton_restablecer').show();
					$("#progress_bar").hide();
					$('#resultado-ajax').html(data);					
					
				}
		});
	}
	else {
	$('#boton_buscar').show();
	$('#boton_restablecer').show();
	msj_invalido() ;
	}
	
}

function pdf_diario_mision() {
	//$('#modo').val('XLS');
	$('#form1').attr("action",'<?=base_url()?>correspondencia/pdf_diario_mision'); 
	$('#form1').submit();
}

$(".boton").button(); 
</script>
</div>


	
	