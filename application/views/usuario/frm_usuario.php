<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
  <div class="form_description">
      <h2><?=$accion;?> <img src="<?= base_url() ?>/public/images/icons/usuario.png" class="icon_accion" id="img_accion"></h2> 
      <p>Formulario</p>
	<?=form_hidden('id'); ?>	
	<?=form_hidden('id_personal'); ?>  
    </div>
    <fieldset>
    <legend>Datos del Usuario </legend>
    <table width="755" border="0">
      
      <tr>
        <td>
		<table width="748" height="91" border="0">
                <tr>
                  <td>
				  	<li>
                    <label class="description" for="element_2">Cédula <span class="required">(*)</span></label>
                    <?= form_input('cedula','','class="element text medium-form"')?>
					<img id="img_buscar" src="<?=base_url().'public/images/lupa.png'?>" / onclick="javascript:consultar()" style="cursor:pointer;">
					</li>
				  </td>
                  <td>
				  	 	<label class="description" for="element_2">Nombre de Usuario <span class="required">(*)</span></label>
                    	<?= form_input('usuario','','class="element text medium-form"')?>
				  </td>
                </tr>
                <tr>
                  <td>
				  	<li>
                    <label class="description" for="element_2">Nombres</label>
                    <?= form_input('nombres','','class="element text_gris medium-form" readonly="" ')?>
					</li>
				  </td>
                  <td><label class="description" for="element_2">Apellidos</label>
                    <?= form_input('apellidos','','class="element text_gris medium-form" readonly="" ')?></td>
                </tr>
                <tr>
                  <td>
				  	<li>
                    <label class="description" for="element_2">Acceso <span class="required">(*)</span></label>
                    <?= form_dropdown('id_acceso', $options);?>
					</li>
				  </td>
                  <td>
				  	<label class="description" for="element_2">Estatus <span class="required">(*)</span></label>
                    <?= form_dropdown_db('id_estatus', 'sys_estatus');?>
				  </td>
                </tr>
                <tr>
                  <td width="431">&nbsp;</td>
                  <td width="307">&nbsp;</td>
                </tr>
              </table>
		</td>
      </tr>

      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    </fieldset>
	<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>		       
	<div id="cancelar" class="boton" onclick="javacript:history.go(-1);">Cancelar</div>		       
  </form>
</div>
<script>

function consultar() {	
	$('#resultado-ajax').hide();
	$('#cargando').show();

	$.ajax({
		url:'<?=base_url()?>usuario/buscar_sigefirrhh',
		type:'post',
		/*dataType: 'json',*/
		data:$('#form1').serialize(),
		success:function(data){
			$('#resultado-ajax').html(data);		
		}			
	});
	}


</script>
<?=ajaxifica('form1','usuario/procesar',$rules)?>
<?=$script;?>

