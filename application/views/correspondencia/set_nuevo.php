<script>
$(document).ready(function(){
$('#fecha_ingreso').datepicker('setDate', 'today');
$('input:radio[name=anexo]').filter('[value=S]').attr('checked', true);
$('input:radio[name=entrada]').filter('[value=V]').attr('checked', true);
});
</script>
