
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

	$('#mnuSistema').fgmenu({content:$('#mnuSistema').next().html(), flyOut:true});
	$('#mnuValija').fgmenu({content:$('#mnuValija').next().html(), flyOut:true});		
	$('#mnuCorrespondencia').fgmenu({content:$('#mnuCorrespondencia').next().html(), flyOut:true});	
});


</script>

<div id="fgmenu" class="ui-widget-header ui-corner-bottom" style="margin-bottom:1px;float:left;display:block; width:825px;">
<?php $a = $this->session->userdata('acceso'); ?>	
	
<?php if ($a == 'admin' OR $a == 'valija_coord' OR $a == 'corresp_coord' ): ?>
<a tabindex="1" href="#sistema" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnuSistema">
<span class="ui-icon ui-icon-triangle-1-s"></span>Sistema</a>
<div id="sistema" class="hidden">
	<ul>
		<li><a href="<?=base_url()?>">Inicio</a></li>
		<li><a href="<?=base_url()."usuario"?>">Usuarios</a></li>		
		<li><a href="#">Maestros</a>
			<ul>
				<li><a href="<?=base_url()."maestro"?>">Principales</a></li>
				<li><a href="<?=base_url()."maestro/ciudades"?>">Ciudades</a></li>
				<li><a href="<?=base_url()."maestro/misiones"?>">Misiones</a></li>
				<li><a href="<?=base_url()."maestro/estructuras"?>">Estructuras</a></li>
			</ul>
		</li>
		<li><a href="<?=base_url()."log/listar"?>">Bitacorara</a></li>
	</ul>
</div>
 <?php endif; ?>

<?php if ($a == 'admin' OR $a == 'valija_coord' OR $a == 'valija_ingreso' OR $a == 'valija_despacho' OR $a == 'mixto'): ?>
<a tabindex="2" href="#valija" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnuValija">
<span class="ui-icon ui-icon-triangle-1-s"></span>Valija</a>
<div id="valija" class="hidden">
	<ul>
		<?php if ($a == 'admin' OR $a == 'valija_coord' OR $a == 'valija_ingreso' OR $a == 'mixto'): ?>
		<li><a href="#">Ingreso</a>
			<ul>
				<li><a href="<?=base_url()."valija/frm_registrar_en_taquilla"?>">Registrar en Taquilla</a></li>
				<li><a href="<?=base_url()."valija/listar_registros_en_taquilla"?>">Listar</a></li>
				<li><a href="<?=base_url()."valija/frm_buscar_ingreso"?>">Buscar</a></li>		
			</ul>		
		</li>
		<?php endif; ?>
		<?php if ($a == 'admin' OR $a == 'valija_coord' OR $a == 'valija_despacho' OR $a == 'mixto'): ?>
		<li><a href="#">Despacho</a>
				<ul>
					<li><a href="<?=base_url()."valija/frm_aperturar"?>">Aperturar</a></li>
					<li><a href="<?=base_url()."valija/listar_aperturadas"?>">Listar</a></li>
				</ul>
		</li>
		<?php endif; ?>
	</ul>
</div>
 <?php endif; ?>
	
<?php if ($a == 'admin' OR $a == 'corresp_coord' OR $a == 'corresp_ingreso' OR $a == 'mixto'): ?>
<a tabindex="2" href="#correspondencia" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-bottom" id="mnuCorrespondencia">
<span class="ui-icon ui-icon-triangle-1-s"></span>Correspondencia</a>
<div id="correspondencia" class="hidden">
	<ul>
		<?php if ($a == 'admin' OR $a == 'corresp_coord' OR $a == 'corresp_ingreso' OR $a == 'mixto'): ?>
		<li><a href="#">Ingreso</a>
			<ul>
				<li><a href="<?=base_url()."correspondencia/formulario"?>">Registrar</a></li>				
				<li><a href="<?=base_url()."correspondencia/frm_buscar_ingreso"?>">Buscar</a></li>
				<li><a href="<?=base_url()."correspondencia/listar"?>">Listar</a></li>
			</ul>
		</li>
		<li><a href="#">Diario</a>
			<ul>
				<li><a href="<?=base_url()."correspondencia/diario_destinatario"?>">Por Destinatario</a></li>
				<li><a href="<?=base_url()."correspondencia/diario_mision"?>">Por Misión</a></li>				
			</ul>
		</li>
		 <?php endif; ?>
	</ul>
</div>
 <?php endif; ?>

<a style="" href="<?=base_url()."login/logoff"?>">
<div class="fg-button ui-widget ui-state-default ui-corner-br" style="float:right;height:15px;display:block;">Salir</div></a>


</div>

<div style="float:right;margin-right: 10px; margin-top: 5px;">
<a><?= $this->session->userdata('usuario')?></a>
</div>