<script>
$('#id').val('<?= $row->id ?>');
$('#indice_interno').val('<?= $row->indice_interno?>');
$('#fecha_ingreso').val('<?= $row->fecha_ingreso?>');
$('#id_mision').val('<?= $row->id_mision?>');
$('#mision').val('<?= $row->mision?>');
$('#asunto').val('<?= $row->asunto?>');
$('#numero_ingreso').val('<?= $row->numero_ingreso?>');
$('#id_destinatario').val('<?= $row->id_destinatario?>');
$('#destinatario').val('<?= $row->destinatario?>');
$('#indice_remitente').val('<?= $row->indice_remitente?>');
$('#fecha_correspondencia').val('<?= $row->fecha_correspondencia?>');
$('#id_tipo_documento').val('<?= $row->id_tipo_documento?>');
$('#numero_documento').val('<?= $row->numero_documento?>');
$('input:radio[name=entrada]').filter('[value=<?= $row->entrada?>]').attr('checked', true); 
$('input:radio[name=anexo]').filter('[value=<?= $row->anexo?>]').attr('checked', true);
$('#observaciones').val('<?= $row->observaciones?>');
$('#meta_data').show();
$('#usuario').html('<?= $row->usuario?>');
$('#fecha_c').html('<?= $row->easydate_c?>');
$('#fecha_a').html('<?= $row->easydate_a?>');
$('#fecha_c').attr('title','<?= fecha_legible($row->creacion)?>');	
$('#fecha_a').attr('title','<?= fecha_legible($row->actualizacion)?>');	
</script>
