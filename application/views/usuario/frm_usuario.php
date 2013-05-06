<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" style="width:">
  <div class="form_description">
      <h2><?=$accion;?></h2> 
      <p>Formulario</p>
	<?=form_hidden('id'); ?>	  
    </div>
    <fieldset>
    <legend>Datos del Usuario </legend>
    <table width="755" border="0">
      
      <tr>
        <td>
		<table width="657" border="0">
                <tr>
                  <td width="411">
                  <li>
                	<label class="description" for="element_2">Nombre de Usuario <span class="required">(*)</span></label>
	                <?= form_input('usuario','','class="element text medium-form"')?>
              	</li>   
				  </td>
                  <td width="236">
					<label class="description" for="element_2">Estatus <span class="required">(*)</span></label>
	                <?= form_dropdown_db('id_estatus', 'sys_estatus');?>
				  </td>
                </tr>
              </table>
		</td>
      </tr>

      <tr>
        <td><table width="756" border="0">
            <tr>
              <td width="746" colspan="2">			  </td>
            </tr>
            <tr>
              <td colspan="2"><table width="657" border="0">
                <tr>
                  <td width="411"><li>
                      <label class="description" for="element_2">Nombres <span class="required">(*)</span></label>
                      <?= form_input('nombres','','class="element text medium-form"')?>
                  </li></td>
                  <td width="236"><label class="description" for="element_2">Apellidos <span class="required">(*)</span></label>
                      <?= form_input('apellidos','','class="element text medium-form"')?></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2"><table width="657" border="0">
                <tr>
                  <td width="411">
				  	<li>
						<label class="description" for="element_2">Coordinación Adscrita <span class="required">(*)</span></label>
		                <?= form_dropdown_db('id_coordinacion', 'coordinaciones');?>
		            </li>				  </td>
                  <td width="236">
				  		<label class="description" for="element_2">Acceso <span class="required">(*)</span></label>
		                <?= form_dropdown('id_acceso', $options);?>				  </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2"><table width="657" border="0">
                <tr>
                  <td width="411">
				  <li></li></td>
                  <td width="236">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            
            
            <tr>
              <td colspan="2">
			  <table id="meta_data" width="" border="0" style="display:none">                
                <tr>
                  <td width="278"><li id="li_tipo_registro">
                      <label class="description" for="element_2">Creado  por</label>
                      <div class="bg_amarillo" id="usuario">                      </div>
                  </li></td>
                  <td width="250"><label class="description" for="element_2">Creado</label>
                  <span class="easydate easydate_valija" title="" id="fecha_c">                  </span>				  </td>
                  <td width="210"><label class="description" for="element_2">Actualizado</label>
                    <span class="easydate easydate_valija" title="" id="fecha_a">                    </span>				  </td>
                </tr>
              </table>			  </td>
            </tr>            
          </table>
	    </td>
      </tr>
    </table>
    </fieldset>
	<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>		       
	<div id="cancelar" class="boton" onclick="javacript:history.go(-1);">Cancelar</div>		       
  </form>
</div>
<?=ajaxifica('form1','usuario/procesar',$rules)?>
<?=$script;?>

