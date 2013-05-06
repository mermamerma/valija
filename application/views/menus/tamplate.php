
<style>
<!--
	
	.fg-button { float:left; padding: .4em 1em; text-decoration:none !important; cursor:pointer; position: relative; text-align: center; zoom: 1; }
	.fg-button .ui-icon { position: absolute; top: 50%; margin-top: -8px; left: 50%; margin-left: -8px; }
		
	button.fg-button { width:auto; overflow:visible; } /* removes extra button width in IE */
	
	.fg-button-icon-left { padding-left: 2.1em; }
	.fg-button-icon-right { padding-right: 2.1em; }
	.fg-button-icon-left .ui-icon { right: auto; left: .2em; margin-left: 0; }
	.fg-button-icon-right .ui-icon { left: auto; right: .2em; margin-left: 0; }
	.fg-button-icon-solo { display:block; width:8px; text-indent: -9999px; }	 /* solo icon buttons must have block properties for the text-indent to work */	
	.hidden{display:none;}
-->
</style>


<script type="text/javascript">

$(function(){		
	
	$('.fg-button').hover(
		function(){ $(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
		function(){ $(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
	);

	$('#mnuAdministracion').fgmenu({content:$('#mnuAdministracion').next().html(), flyOut:true});
	$('#mnuanalista').fgmenu({content:$('#mnuanalista').next().html(), flyOut:true});
	$('#mnutramites').fgmenu({content:$('#mnutramites').next().html(), flyOut:true});
	$('#mnuprueba').fgmenu({content:$('#mnuprueba').next().html(), flyOut:true});
});


</script>

<div id="fgmenu" class="ui-widget-header ui-corner-bottom" style="margin-bottom:1px;float:left;display:block; width:825px;">

<a tabindex="1" href="#administracion" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnuAdministracion"><span class="ui-icon ui-icon-triangle-1-s"></span>Administración</a>
<div id="administracion" class="hidden">
	<ul>
		<li><a href="<?=base_url()?>">Inicio</a></li>
		<li><a href="#">Solicitudes</a></li>
		<li><a href="#">Formatos</a>
			<ul>
				<li><a href="<?=base_url()?>index.php/admin/formatoConstancia">Constancia mensual</a>
				<li><a href="#">Constancia anual</a>
				<li><a href="#">Constancia otro</a>
				
			</ul>
		</li>
		
		<li><a href="#">Usuarios</a></li>
	</ul>
</div>



<a tabindex="2" href="#analista" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnuanalista">
<span class="ui-icon ui-icon-triangle-1-s"></span>Valija</a>
<div id="analista" class="hidden">
	<ul>
		<li><a href="<?=base_url()."valija/frm_aperturar_en_taquilla"?>">Aperturar en taquilla</a></li>
		<li><a href="<?=base_url()."main/misImagenes.html"?>">Mis Im&aacute;genes</a></li>
		<li><a href="<?=base_url()."imagenes/busqueda.html"?>">B&uacute;squeda</a></li>
		
	</ul>
</div>
<a tabindex="3" href="#tramites" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnutramites"><span class="ui-icon ui-icon-triangle-1-s"></span>Trámites</a>
<div id="analista" class="hidden">
	<ul>
		<!-- <li><a href="<?=base_url()."index.php/main/solicitud/"?>">Solicitud</a>
			<ul>
				<li><a href="#">kjsdalfbaslkdf</a></li>
				<li><a href="#">kjsdalfbaslkdf</a></li>
				<li><a href="#">kjsdalfbaslkdf</a></li>
				<li><a href="#">kjsdalfbaslkdflkjnr </a></li>
				
			</ul>
		</li>
		 -->
		<li><a href="<?=base_url()."index.php/main/solicitud2/"?>">Solicitud</a></li>
		<li><a href="<?=base_url()."index.php/main/consultatramite/"?>">Consulta de Solicitudes</a></li>
		
	</ul>
</div>



<a tabindex="4" href="#desarrollo" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnuprueba">
<span class="ui-icon ui-icon-triangle-1-s"></span>Desarrollo</a>
<div id="desarrollo" class="hidden">
	<ul>
		<li><a href="<?=base_url()."index.php/prueba/"?>">Prueba 1</a></li>
		<li><a href="#">Prueba 2</a></li>
		<li><a href="<?=base_url()."index.php/prueba/prueba4"?>">Prueba 4</a></li>
		<li><a href="<?=base_url()."index.php/prueba/pdf"?>">Prueba PDF</a></li>
		<li><a href="<?=base_url()."index.php/prueba/tcpdf"?>">Prueba TCPDF</a></li>
		<li><a href="<?=base_url()."index.php/prueba/prueba5"?>">Prueba 5</a></li>
		<li><a href="<?=base_url()."index.php/prueba/prueba6"?>">Prueba 6</a></li>
	</ul>
</div>

<a style="" href="<?=base_url()."login/logoff"?>">
<div class="fg-button ui-widget ui-state-default ui-corner-br" style="float:right;height:15px;display:block;">Salir</div></a>


</div>

<div style="float:right;margin-right: 10px; margin-top: 5px;"><a><?= $this->session->userdata('usuario')?></a></div>