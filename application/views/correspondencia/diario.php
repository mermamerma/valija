<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" target="_blank">
	<div class="form_description">
 		<h2>Correspondencias por <u><?= $modo ?></u> <img src="<?= base_url() ?>/public/images/icons/<?= $icon ?>.png" class="icon_accion" id="img_accion"></h2> 
      <p><?= $leyenda ?></p>	  
	</div>
		<fieldset>
	<legend>Criterio de Busqueda</legend>
	<table width="100%" border="0">
      <tr>
        <td width="418"><li>
            <label class="description" for="element_2"></label>
            <a onclick="javascript:pasar();"></a>
            <label class="description" for="element_2">Desde la Fecha de Ingreso </label>
            <?= form_date_picker('fecha_ingreso_desde','','class="element text medium-form"');?>
			</li></td>
        	<td width="297"><a onclick="javascript:pasar();"></a>
          	<label class="description" for="element_2">Hasta la Fecha de Ingreso </label>
          	<?= form_date_picker('fecha_ingreso_hasta','','class="element text medium-form"');?></td>
      </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
	  
	  <tr>
        <td><span id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</span>	</td>
        <td>&nbsp;</td>
      </tr>
    </table>
	</fieldset>		
	
	<?= $tabla ?>
	<br />	
</form>
</div>