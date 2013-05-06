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
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">

	<thead>
		<tr>
			<th>Rendering engine</th>
			<th>Browser</th>
			<th>Platform(s)</th>
			<th>Engine version</th>
			<th>CSS grade</th>

			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<tr class="odd gradeX">
			<td>Trident</td>

			<td>Internet Explorer 4.0</td>
			<td>Win 95+</td>
			<td class="center"> 4</td>
			<td class="center">X</td>
			<td><a class="edit" href="">Edit</a></td>
			<td><a class="delete" href="">Delete</a></td>

		</tr>
		<tr class="even gradeC">
			<td>Trident</td>
			<td>Internet Explorer 5.0</td>
			<td>Win 95+</td>
			<td class="center">5</td>
			<td class="center">C</td>

			<td><a class="edit" href="">Edit</a></td>
			<td><a class="delete" href="">Delete</a></td>
		</tr>
		<tr class="odd gradeA">
			<td>Trident</td>
			<td>Internet Explorer 5.5</td>
			<td>Win 95+</td>

			<td class="center">5.5</td>
			<td class="center">A</td>
			<td><a class="edit" href="">Edit</a></td>
			<td><a class="delete" href="">Delete</a></td>
		</tr>
	</tbody>
</table>

		</fieldset>			
	</form>
</div>
<script type="text/javascript" charset="utf-8">
			function restoreRow ( oTable, nRow )
			{
				var aData = oTable.fnGetData(nRow);
				var jqTds = $('>td', nRow);
				
				for ( var i=0, iLen=jqTds.length ; i<iLen ; i++ ) {
					oTable.fnUpdate( aData[i], nRow, i, false );
				}
				
				oTable.fnDraw();
			}
			
			function editRow ( oTable, nRow )
			{
				var aData = oTable.fnGetData(nRow);
				var jqTds = $('>td', nRow);
				jqTds[0].innerHTML = '<input type="text" value="'+aData[0]+'">';
				jqTds[1].innerHTML = '<input type="text" value="'+aData[1]+'">';
				jqTds[2].innerHTML = '<input type="text" value="'+aData[2]+'">';
				jqTds[3].innerHTML = '<input type="text" value="'+aData[3]+'">';
				jqTds[4].innerHTML = '<input type="text" value="'+aData[4]+'">';
				jqTds[5].innerHTML = '<a class="edit" href="">Save</a>';
			}
			
			function saveRow ( oTable, nRow )
			{
				var jqInputs = $('input', nRow);
				oTable.fnUpdate( jqInputs[0].value, nRow, 0, false );
				oTable.fnUpdate( jqInputs[1].value, nRow, 1, false );
				oTable.fnUpdate( jqInputs[2].value, nRow, 2, false );
				oTable.fnUpdate( jqInputs[3].value, nRow, 3, false );
				oTable.fnUpdate( jqInputs[4].value, nRow, 4, false );
				oTable.fnUpdate( '<a class="edit" href="">Edit</a>', nRow, 5, false );
				oTable.fnDraw();
			}
			
			$(document).ready(function() {
				var oTable = $('#example').dataTable();
				var nEditing = null;
				
				$('#new').click( function (e) {
					e.preventDefault();
					
					var aiNew = oTable.fnAddData( [ '', '', '', '', '', 
						'<a class="edit" href="">Edit</a>', '<a class="delete" href="">Delete</a>' ] );
					var nRow = oTable.fnGetNodes( aiNew[0] );
					editRow( oTable, nRow );
					nEditing = nRow;
				} );
				
				$('#example a.delete').live('click', function (e) {
					e.preventDefault();
					
					var nRow = $(this).parents('tr')[0];
					oTable.fnDeleteRow( nRow );
				} );
				
				$('#example a.edit').live('click', function (e) {
					e.preventDefault();
					
					/* Get the row as a parent of the link that was clicked on */
					var nRow = $(this).parents('tr')[0];
					
					if ( nEditing !== null && nEditing != nRow ) {
						/* Currently editing - but not this row - restore the old before continuing to edit mode */
						restoreRow( oTable, nEditing );
						editRow( oTable, nRow );
						nEditing = nRow;
					}
					else if ( nEditing == nRow && this.innerHTML == "Save" ) {
						/* Editing this row and want to save it */
						saveRow( oTable, nEditing );
						nEditing = null;
					}
					else {
						/* No edit in progress - let's start one */
						editRow( oTable, nRow );
						nEditing = nRow;
					}
				} );
			} );
		</script>