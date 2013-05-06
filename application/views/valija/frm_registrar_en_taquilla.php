<script type="text/javascript">
//$("#id_tipo_registro option").eq(1).attr("selected", "selected");
//alert(id_tipo_valija);
//alert($('#id_tipo_valija option:selected').html( ));
function cambio_tipo_valija ( ) {
	estatus_courrier 		= $('#td_id_courrier').css('display');	
	valor = $('#id_tipo_valija').val( );
	// Si el tipo de valija seleccionada es ESPECIAL valor 2
	if (valor == 2 ) {			
		$('#td_numero_guia').show('blind',500); 
		$('#td_id_courrier').show('blind',500); 
		//$('#numero_guia').attr('disabled',''); 
		//$('#id_courrier').attr('disabled',''); 
		$("#id_courrier").rules("add", "required");
		$("#numero_guia").rules("add", "required");
	}
	// Si el tipo de valija seleccionada es PROGRAMADA valor 1
	else if (valor ==1 && estatus_courrier!='none' ) {
		$("#id_courrier option").eq(0).attr("selected", "selected");	
		$('#numero_guia').val('');
		$('#td_numero_guia').hide('blind',500); 
		$('#td_id_courrier').hide('blind',500); 
		$("#id_courrier").rules("remove", "required");
		$("#numero_guia").rules("remove", "required");
		//$('#id_courrier').attr('disabled','disabled'); 	
		//$('#numero_guia').attr('disabled','disabled'); 
	}
	else if (valor == '' && estatus_courrier!='none' ) {
		$('#numero_guia').val('');
		$("#id_courrier option").eq(0).attr("selected", "selected");
		$('#td_numero_guia').hide('blind',500); 
		$('#td_id_courrier').hide('blind',500); 
		//$('#numero_guia').attr('disabled','disabled'); 	
		//$('#id_courrier').attr('disabled','disabled'); 	
	}	
}

function cambio_tipo_registro ( ) {
	estatus_numero_nota 			= $('#td_numero_nota').css('display');
	estatus_tipo_correspondencia = $('#td_tipo_correspondencia').css('display');
	valor = $('#id_tipo_registro').val();	
	if (valor == 1 ) { // es NOTA
		$("#id_tipo_correspondencia option").eq(0).attr("selected", "selected");	
		$('#td_tipo_correspondencia').hide('blind',500); 	
		$('#td_numero_nota').show('blind',500); 
		$("#numero_nota").rules("add", "required");	
		$("#id_tipo_correspondencia").rules("remove", "required");		
	}	
	else if (valor == 2 ) {		// Es una CORRESPONDENCIA			
		$('#numero_nota').val('');
		$('#td_numero_nota').hide('blind',500); 		
		$('#td_tipo_correspondencia').show('blind',500);
		$("#id_tipo_correspondencia").rules("add", "required");	
		$("#numero_nota").rules("remove", "required");	 	
		//$('#td_numero_nota').css('visible',);
		//$('#numero_nota').attr('disabled','disabled'); 	
		//$('#id_tipo_correspondencia').attr('disabled',''); 		
		//$('#td_numero_nota').show('blind',500); 		
	}
	else if (valor == '') {
		$('#td_numero_nota').hide('blind',500); 		
		$('#td_tipo_correspondencia').hide('blind',500); 	
		$('#numero_nota').val('');
		$("#id_tipo_correspondencia option").eq(0).attr("selected", "selected");
		$("#id_tipo_correspondencia").rules("remove", "required");		
		$("#numero_nota").rules("remove", "required");		
		//$('#numero_nota').attr('disabled','disabled'); 	
		//$('#id_tipo_correspondencia').attr('disabled','disabled'); 	
	}
}
</script>
<div id="resultado-ajax">
</div>
<div id="dialog">
</div>
<div id="form_container">
<form id="form1" class="appnitro" method="post" action="" >
    <div class="form_description">
      <h2>Registrar Valija en Taquilla</h2> 
      <p>Formulario</p>	  
    </div>
    <fieldset>
    <legend>Procedencia  </legend>
	<?=form_hidden('id')?>
    <table width="" border="0">
      <tr>
        <td><li id="li_titulo" >
            <label class="description" for="element_2">Misión <span class="required">(*)</span></label>
            <?=form_autocomplete('id_mision','mision',base_url(),'misiones'); ?>
        </li>
		</td>
      </tr>
      <tr>
        <td><table width="" border="0">
            <tr>
              <td width="272"><li id="li_tipo_registro">
                  <label class="description" for="element_2">Tipo de Valija <span class="required">(*)</span></label>
                  <?= form_dropdown_db('id_tipo_valija','tipo_valija','onchange=javacript:cambio_tipo_valija();') ?>
              </li></td>
              <td width="256" id="td_id_courrier" style="display:none;">
			  <label class="description" for="element_2">Courrier <span class="required">(*)</span></label>
              </label>
			  <labe for="id_courrier" generated="true" class="error"></label>
			  <?= form_dropdown_db('id_courrier','courriers') ?></td>
              <td width="210" id="td_numero_guia" style="display:none;"><label class="description" for="element_2">Número de Guía <span class="required">(*)</span></label>
                <?php echo form_input($p=array('name'=>'numero_guia', 'id' => 'numero_guia') )?></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>
		<table width="750" border="0">
            <tr>
              <td width="277"><li id="li_tipo_registro" >
                  <label class="description" for="element_2">Tipo de Registro <span class="required">(*)</span></label>
                  <?=  form_dropdown_db('id_tipo_registro', 'tipo_registro', 'onchange=javacript:cambio_tipo_registro();');?>
                </li></td>
              <td width="" id="td_numero_nota" style="display:none"><label class="description" for="element_2">Número de Nota <span class="required">(*)</span></label>
                <?= form_input('numero_nota')?></td>
              <td width="" id="td_tipo_correspondencia" style="display:none">
			  	<label class="description" for="element_2">Tipo de Correspondencia <span class="required">(*)</span></label>
                <?= form_dropdown_db('id_tipo_correspondencia', 'tipo_correspondencia');?>
			  </td>
            </tr>
          </table>
		</td>
      </tr>
      <tr>
        <td><table width="" border="0">
            
            <tr>
              <td width="274"><li id="li_tipo_registro" >
                  <label class="description" for="element_2">Número de Ingreso</label>
                  <?= form_input('numero_ingreso')?>
              </li></td>
              <td width="255"><label class="description" for="element_2">Indice de Valija</label>
              <?= form_input('indice_valija')?>				</td>
              <td width="207"><label class="description" for="element_2">Fecha <span class="required">(*)</span></label>               
              <?= form_date_picker('fecha');?>
			  </td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td><table width="0%" border="0">
            
            <tr>
              <td width="274"><li id="li_tipo_registro">
                  <label class="description" for="element_2">Tipo de Asunto </label>
				  <?php echo form_error('id_tipo_asunto'); ?>
                  <?= form_dropdown_db('id_tipo_asunto', 'tipo_asunto');?>
              </li></td>
            </tr>
          </table>        </td>
      </tr>
      <tr>
        <td width=""><table width="663" border="0">
            <tr>
              <td width="331"><li id="li_tipo_registro">
                  <label class="description" for="element_2">Asunto</label>
				    <?php echo form_error('asunto'); ?>
                  <?=form_textarea('asunto','','class="element textarea medium"')?>
                  </li>				  </td>
              <td width="197"><label class="description" for="element_2">Otros</label>
			  	<?=form_textarea('otros',set_value('otros'),'class="element textarea medium"')?>              </td>
            </tr>
          </table></td>
      </tr>
    </table>
    </fieldset>
    <fieldset>
    <legend>Datos del destino </legend>
    <table width="" border="0">
      <tr>
        <td>
			<li id="li_titulo" >
            <label class="description" for="element_2">Destinataro <span class="required">(*)</span></label>
			<?=form_autocomplete('id_destinatario','destinatario',base_url(),'estructura'); ?>
			</li>
		</td>
      </tr>
      <tr>
        <td><table width="" border="0">
            <tr>
              <td width="281"><li id="li_tipo_registro">
                <label class="description" for="element_2">Anexos</label>
                <?= form_input('anexos')?>
              </li></td>
              <td width="380"><label class="description" for="element_2">Fecha de Ingreso <span class="required">(*)</span></label>
                <?= form_date_picker('fecha_ingreso');?></td>
            </tr>
            
            <tr>
              <td colspan="2"><table width="663" border="0">
                  
                  <tr>
                    <td width="331"><li id="li_tipo_registro">
                        <label class="description" for="element_2">Observaciones</label>
						<?=form_textarea('observaciones','','class="element textarea medium" style="width:450px"')?>                        
                      </li></td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
    </table>
    </fieldset>
    <fieldset>
    <legend>Relación</legend>
    <table width="755" border="0">
      <tr>
        <td colspan="2"><table width="" border="0">
            <tr>
              <td width="283"><li id="li_tipo_registro">
                  <label class="description" for="element_2">Indice diario <span class="required">(*)</span></label>				  
                  <?= form_input('indice_diario')?>
              </li></td>
              <td width="242"><label class="description" for="element_2">Entregado por</label>
              <?= form_input('entregado_por')?></td>
              <td width="210"><label class="description" for="element_2">Estatus de Taquilla <span class="required">(*)</span></label>
                <?= form_dropdown_db('id_estatus_taquilla', 'estatus_taquilla');?>
              </td>
            </tr>
          </table></td>
      </tr>
    </table>
    </fieldset> 
	<div id="aceptar" class="boton" onclick="javacript:enviar();">Aceptar</div>	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
	<div id="cancelar" class="boton" onclick="javacript:window.location.href = '<?=base_url()?>';">Cancelar</div>	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
  </form>
</div>
<script>

function test1  ( ) {
	$("#aceptar").button( "option", "disabled", true );
	//alert($('#td_id_courrier').css('display'));
	//alert($('#id_tipo_valija option:selected').html( ));
	//alert($('#id_tipo_valija').text());
}


function test2  ( ) {
	$("#aceptar").button( "option", "disabled", false );
	//alert($('#td_id_courrier').css('display'));
	//alert($('#id_tipo_valija option:selected').html( ));
	//alert($('#id_tipo_valija').text());
}

function enviar (){
	if($('#form1').valid()){
		$.ajax({
			url:'<?=base_url().'valija/registrar_en_taquilla'?>',
			type:'post',
			data:$('#form1').serialize(),
			success:function(data){ $('#resultado-ajax').html(data) }
		});
	}
	else
	msj_invalido() ;
	
}

function msj_invalido () {
	$('#dialog').dialog
	({
		autoOpen: true, modal:true, title: 'Atención',
		buttons: {	Aceptar: function() { $( this ).dialog( 'close' );	} }
	
	});
	$('#dialog').html("<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>¡Error, verifique, hay campos invalidos!</p>");
}

$(document).ready(function(){			
$('#form1').validate({
	rules:{
		
		id_mision : { required:true }, id_tipo_valija : { required:true } , id_tipo_registro : { required:true } ,
		id_destinatario : { required:true } , fecha : {  dateDE: true , required: true } , 
		fecha_ingreso : { required:true, dateDE: true},
		indice_diario : { required:true } , id_estatus_taquilla : { required:true }
		
			
		}}
	);
;
		})

$(function() {
$( '#dialog' ).dialog({autoOpen: false, modal:true});
$(".boton").button(); 
//$('input[type=submit]', this).attr('disabled', 'disabled');
});

function RecorrerForm() {
	var sAux="";
	var frm = document.getElementById("form1");
	for (i=0;i<frm.elements.length;i++)
	{
		//$(document.getElementById("form1").elements[i].id).attr('disabled', 'disabled');
		elemento = frm.elements[i].id ;
		//$("#mision").attr('disabled','disabled');
		//alert(elemento);
		if (elemento != '')	{
			elemento = elemento ;		
			$('#'+elemento).attr('disabled','disabled');
			//sAux += "NOMBRE: " + frm.elements[i].name + " ";
			sAux += "ID :  " + frm.elements[i].id + "\n"; ;
			//sAux += "TIPO :  " + frm.elements[i].type + " "; ;
			//sAux += "VALOR: " + frm.elements[i].value + "\n" ;*/
		}
	}
	//alert(sAux);
}

</script>

