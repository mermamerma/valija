<form id="form_130956" class="appnitro" enctype="multipart/form-data" method="post" action="<?=base_url().'login/validar_usuario'?>">
			<div class="form_description">
			<h2>Acceder al Sistema de Valija Diplomática </h2>
			<p> <br /></p>
			<?=validation_errors() ?>
			<?php if (isset($msj)) echo $msj;?>	
			</div>	
<ul><li id="li_1" name="li_1">
		<label class="description" for="element_1">Usuario</label>
		<div>
			<input placeholder="Usuario del Correo Institucional" type="text" id="usuario" name="usuario" class="element text medium-medium" maxlength="50" value="<?=set_value('usuario')?>" style="text-transform: none;" /> 
		</div>
		</li><li id="li_2">
		<label class="description" for="element_2">Contraseña </label>
		<div>
			<input placeholder="Contraseña del Correo Institucional" type="password" id="password" name="password" class="element text medium-medium" maxlength="50" value="" style="text-transform: none;" /> 
		</div>
		</li><li class="buttons">
		  <input type="submit" name="aceptar" id="aceptar" class="boton" value="Aceptar"/>
		  <input type="reset" id="cancelForm" class="boton" name="Cancelar" value="Cancelar" style="margin-left:25px;"/>
	  </li><br /><br /><li class="buttons" style="margin-left: 150px; text-align: center;">
	  <?=img($help_png = array('src' => 'public/images/help.png','alt'=>'Ayuda','longdesc'=>'Ayuda', 'width'=>'16', 'height'=>'16'));?>
		Si desean obtener ayuda o presentan problemas para acceder al sistema contactenos por el correo: <a href="mailto:jesus.rodriguez937@mppre.gob.ve">jesus.rodriguez937@mppre.gob.ve</a> <br />
	  	</li><br />
		<li class="buttons" style="margin-left: 250px;">
		</li>
		</ul>
  	  	<br/>
  </form>
<script>
$(document).ready(function(){				
	$(".boton").button(); 
	$('#usuario').focus(); 
});	
</script>
