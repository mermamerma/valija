<script>
$('#id').val('<?= $valija->id ?>');
$('#id_mision').val('<?= $valija->id_mision ?>');
$('#mision').val('<?= $valija->mision ?>');
$('#indice_valija').val('<?= $valija->indice_valija ?>');
$('#id_tipo_valija').val('<?= $valija->id_tipo_valija ?>');
$('#id_estatus_valija').val('<?= $valija->id_estatus_valija ?>');
$('#fecha_anuncio').val('<?= $valija->fecha_anuncio ?>');
$('#fecha_recibido').val('<?= $valija->fecha_recibido ?>');
$('#presilla').val('<?= $valija->presilla ?>');
$('#peso').val('<?= $valija->peso ?>');
$('#num_candado').val('<?= $valija->num_candado ?>');
$('#id_courrier').val('<?= $valija->id_courrier ?>');
$('#num_guia').val('<?= $valija->num_guia ?>');
$('#id_tipo_contenido').val('<?= $valija->id_tipo_contenido ?>');
$('#num_cajas').val('<?= $valija->num_cajas ?>');
$('#num_sacos').val('<?= $valija->num_sacos ?>');
$('#num_piezas').val('<?= $valija->num_piezas ?>');
$('#observaciones').val('<?= $valija->observaciones ?>');
$('#meta_data').show();
$('#usuario').html('<?= $valija->usuario ?>');
$('#fecha_c').html('<?= $valija->easydate_c ?>');
$('#fecha_a').html('<?= $valija->easydate_a ?>');
$('#fecha_c').attr('title', '<?= fecha_legible($valija->creacion) ?>');	
$('#fecha_a').attr('title', '<?= fecha_legible($valija->actualizacion) ?>');
mostrar_fechas(); 
</script>
