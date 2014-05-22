<h2 align="center" ><?= $titulo ?> </h2>
<table border="0" bordercolor="" cellspacing="5" cellpadding ="10">
<thead>
<tr  align="center" style="font-weight:bold" bgcolor="#E5E5E5">
<th>DESTINATARIO</th>
<th>CANTIDAD</th>		
</tr>
</thead>
<tbody>
<?php $estiloFila = ''; $total = 0 ; ?>
<?php foreach ($diario as $row): ?>
	<tr  <?= $estiloFila?> >
	<td> <?= $row['destinatario'] ?></td>
	<td style="text-align: center" ><?= $row['cantidad'] ?></td>		
	</tr>
<?php $total = $total + (int) $row['cantidad'] ; ?>	
<?php $estiloFila = ($estiloFila=='') ? 'bgcolor="#EEEEFF"' : ''; ?>
<?php endforeach; ?>
</tbody>
</table>
<br/><br/>
<h3>Total Correspondencias: <?= $total?></h3>