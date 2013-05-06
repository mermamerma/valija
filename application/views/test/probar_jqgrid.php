<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
	<form id="form1" class="appnitro" method="post" action="" >
		<div class="form_description">
			<h2>Listar / Buscar valijas aperturadas</h2> 
		</div>
		<fieldset>
			<legend>Valijas Aperturadas</legend>
			<br />
			<?= $tabla?>
			<table id="list2"></table> <div id="pager2"></div>
		</fieldset>			
	</form>
</div>	
<script>
jQuery("#list2").jqGrid({ 
	url:'server.php?q=2', datatype: "json", 
	colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'], 
	colModel:[ 
		{name:'id',index:'id', width:55}, 
		{name:'invdate',index:'invdate', width:90}, 
		{name:'name',index:'name asc, invdate', width:100}, 
		{name:'amount',index:'amount', width:80, align:"right"}, 
		{name:'tax',index:'tax', width:80, align:"right"}, 
		{name:'total',index:'total', width:80,align:"right"}, 
		{name:'note',index:'note', width:150, sortable:false} 
	], 
	rowNum:10, 
	rowList:[10,20,30], 
	pager: '#pager2', 
	sortname: 'id', 
	viewrecords: true, 
	sortorder: "desc", 
	caption:"JSON Example" 
}); 
jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
</script>

</form>	