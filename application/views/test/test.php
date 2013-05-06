<script>
$(function() {

});
</script>
<form id="form_130956" class="appnitro" enctype="multipart/form-data" method="post" action="">
					<div class="form_description">
			<h2>Bienvenido al Sistema de Valija Diplomática</h2>
			<div id="msj_login" class="" style=""></div>
		</div>						
<!--<ul style="border-left-width: 0px; padding-left: 220px;">-->
<ul>

<br />
<?php 
$rules = array();
$rules[] = ('numero : { required:true }');
$rules[] = ('fecha_correspondencia : { required:true, dateDE: true}');
$rules[] = ('fecha_ingreso : { required:true, dateDE: true}');
$rules[] = ('asunto : { required:true }');
$rules_js = '';
$num_rules = count($rules);

if ($num_rules > 1) {
	for ($i=0; $i < count($rules) -1 ; $i++) {
		$rules_js .= $rules[$i].',';
	}
	$rules_js = $rules_js.$rules[count($rules)-1];
	$rules_js;
}
elseif ($num_rules == 1) 
	$rules_js .= $rules[0]		;
return $rules_js;
?>
</ul>
<script>

</script>

</form>	