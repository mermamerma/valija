<?php

/**
 * 
 * 
 * @author
 * @version 
 */	

class Valija extends Controller {

    function __construct() {
		parent::Controller();
		$this->load->model('valija_model');
		is_logged_in();
	}
	
    /*********************** Valija Despacho **************************/
	
    function frm_aperturar() {
		$id = $this->uri->segment(3);
		
		$data ['main_content'] 		= 'valija/frm_aperturar';    	
    	$rules[] = ('id_mision : { required:true }');
    	$rules[] = ('indice_valija : { digits:true }');
    	$rules[] = ('id_tipo_valija : { required:true }');
    	$rules[] = ('id_estatus_valija : { required:true }');
    	$rules[] = ('id_courrier : { required:true }');
    	$rules[] = ('num_guia : { required:true, digits:true }');
    	$rules[] = ('num_candado : {digits:true }');
    	$rules[] = ('id_contenido : { required:true }');
    	$rules[] = ('num_cajas : { required:true, digits:true }'); 
    	$rules[] = ('num_sacos : { required:true, digits:true }'); 
    	$rules[] = ('num_piezas : { required:true, digits:true }');
    	
    	$data['rules'] = $rules;   
		
    	// Para cargar la data a editar
		if ($id) {			
			$valija = $this->valija_model->get_valija_aperturada();
			if ($valija) {
				$script = "
				<script>
				$('#id').val('{$valija->id}');
				$('#id_mision').val('{$valija->id_mision}');
				$('#mision').val('{$valija->mision}');
				$('#indice_valija').val('{$valija->indice_valija}');
				$('#id_tipo_valija').val('{$valija->id_tipo_valija}');
				$('#id_estatus_valija').val('{$valija->id_estatus_valija}');
				$('#fecha_anuncio').val('{$valija->fecha_anuncio}');
				$('#fecha_recibido').val('{$valija->fecha_recibido}');
				$('#presilla').val('{$valija->presilla}');
				$('#peso').val('{$valija->peso}');
				$('#num_candado').val('{$valija->num_candado}');
				$('#id_courrier').val('{$valija->id_courrier}');
				$('#num_guia').val('{$valija->num_guia}');
				$('#id_tipo_contenido').val('{$valija->id_tipo_contenido}');
				$('#num_cajas').val('{$valija->num_cajas}');
				$('#num_sacos').val('{$valija->num_sacos}');
				$('#num_piezas').val('{$valija->num_piezas}');
				$('#observaciones').val('{$valija->observaciones}');
				$('#meta_data').show();
				$('#usuario').html('{$valija->usuario}');
				$('#fecha_c').html('{$valija->easydate_c}');
				$('#fecha_a').html('{$valija->easydate_a}');
				$('#fecha_c').attr('title', '".fecha_legible($valija->creacion)."');	
				$('#fecha_a').attr('title', '".fecha_legible($valija->actualizacion)."');
				mostrar_fechas(); 
				</script>";
				$data['momento'] = 'Editar Valija Aperturada';
				$data['script'] = $script; 
				register_log('Valija',"Acceso al formulario para editar una valija perturada con el ID => $id");
			}
			else 
				show_error("Valija aperturada con el ID $id no fue encontrada",404);
				
			
		}
		else {
			$data['momento'] = 'Aperturar Valija';  
			$data['script'] = '';  
			register_log('Valija',"Acceso al formulario para aperturar una valija");			
		}
		
		$this->load->view('sistema/template',$data);					
    }
		
    function aperturar() {
       if ($this->input->post('id') == '') {	
    		if ($query = $this->valija_model->aperturar()) {
    			$id   = $this->db->insert_id();
    			register_log('Valija',"Se aperturó una nueva valija con en ID => $id",1); 
   				$str  = dialog('Información','¡Valija Aperturada Exitosamente!',2);
   				$str .= "<script>$('#id').val('$id');</script>";   				 
   				echo  $str ;   			
    		}
    	}
    	elseif ($this->input->post('id') != '') {    		
    		if ($query = $this->valija_model->editar_apertura()) {
    			$id = $this->input->post('id');
    			register_log('Valija',"Se editó la valija aperturada con en ID => $id",1);    			    			
   				$str  = dialog('Valija','¡Valija Modificada Exitosamente!',2);
   				$str .= "<script> \$('#fecha_a').html('Justo ahora');	\$('#fecha_a').attr('title','Justo ahora');</script>";   				
   				echo  $str ;
    		}    		
    	}
    }
    
    function editar_apertura() {    	
    }
    
    function eliminar_apertura () {
    	$id = $this->uri->segment(3);
		$str = '';		
		if ($this->valija_model->eliminar_apertura()) { 
	   			register_log('Valija',"Se eliminó una valija aperturada con en ID => $id",1);    			    			
   				$str  = dialog('Información','¡Valija Eliminada Exitosamente!',2);
   				$str .= "<script>$('#tr_$id').remove();</script>";  				
    	}
    	else {    		
    		register_log('Valija',"Error al tratar de eliminar una valija aperturada con en ID => $id",1);    			    			
   			$str  = dialog('Atención','¡Error al eliminar el registro!',1); 				
   			
    	}
    	echo $str;
    }
    
    function listar_aperturadas(){
		$tabla = '<table cellspacing="1"  class="display" id="datatable">
	  	<thead>
	  	<tr>
	  		<th>ID</th><th>Tipo</th><th>Estatus</th><th># Candado</th><th>Presilla</th>
	  		<th>Indice Valija</th><th>Misión</th><th>Courrier</th><th>Guía</th>
	  		<th>Anunciada</th><th>Recibida</th><th>-</th>
	  	</tr>
	  	</thead>
	  	<tbody>';				
		$rows = $this->valija_model->listar_aperturadas()  ;		
    	foreach ($rows as $key=> $row) {			
			$tabla .= "	<tr id ='tr_{$row['id']}'>
							<td>{$row['id']}</td>
							<td>{$row['tipo']}</td>
							<td>{$row['estatus']}</td>
							<td>{$row['num_candado']}</td>
							<td>{$row['presilla']}</td>
							<td>{$row['indice_valija']}</td>							
							<td>{$row['nombre_mision']} EN {$row['nombre_ciudad']}, {$row['nombre_pais']}</td>
							<td>{$row['courrier']}</td>
							<td>{$row['num_guia']}</td>
							<td>{$row['fecha_anuncio']}</td>
							<td>{$row['fecha_recibido']}</td>
							<td>
								<a href='frm_aperturar/{$row['id']}'><img src='".base_url()."public/images/editar.png' align='absmiddle'/></a>
								<a href='#' onclick='javascript:eliminar({$row['id']})'><img src='".base_url()."public/images/delete.png' align='absmiddle'/></a>
							</td>
						</tr>";		
		}
		$tabla .= '</tbody></table>';
		$data ['tabla'] = $tabla;
        $data ['main_content'] 		= 'valija/listar_aperturadas';
        $this->load->view('sistema/template',$data);
        register_log('Valija',"Acceso a listar / buscar valijas aperturadas");  
	}

    /*********************** Valija Ingreso **************************/
    
    function frm_registrar_en_taquilla() {
		register_log('Valija',"Acceso al formulario para ingresar nuevo registra en taquilla");    	
    	$data ['main_content'] 		= 'valija/frm_registrar_en_taquilla'; 
		$this->load->view('sistema/template',$data);					
    }

    function frm_buscar_ingreso() {
		$data['script'] = '';  
		$rules[] = ('criterio : { required:true }');	
		$data['rules'] = $rules;   	    	
    	$data ['main_content'] 		= 'valija/frm_buscar_ingreso';
    	$options = array(''=>'[Seleccione...]',	'mision'=>'Misión', 'periodo'=>'Periodo','f_anuncio'=> 'Fecha de Anuncio','f_recepcion'=>'Fecha de Recepción','estatus'=>'Estatus');
        $data ['options'] = $options; 
        register_log('Valija',"Acceso al formulario para buscar valija registrada en taquilla");
		$this->load->view('sistema/template',$data);					
    }

    function buscar_ingreso(){
    	$response = '';
    	$tabla = "<table cellspacing=\"1\" class=\"display\" id=\"datatable\"> <thead><tr><th>ID</th><th>Misión</th><th># Guía</th><th># Ingreso</th><th>Destinatario</th><th>Estatus</th><th>Registrado</th><th>Usuario</th><th>Acción</th></tr>";
		$tabla .= "</thead><tbody>";				
		$rows = $this->valija_model->listar_en_taquilla()  ;		
    	foreach ($rows as $key=> $row) {
    		$opciones  = "<a href=\"".base_url()."valija/editar_en_taquilla/{$row['id']}\"><img title=\"Editar\" src=\"".base_url()."public/images/editar.png\" align=\"absmiddle\"/></a>   ";
			$opciones .= "<a href=\"#\" onclick=\"javascript:eliminar_en_taquilla({$row['id']})\"><img title=\"Eliminar\" src=\"".base_url()."public/images/delete.png\" align=\"absmiddle\"/></a>";
			#$opciones = '#';						
			$tabla .= '<tr>';
			$tabla .= "<td>{$row['id']}</td><td>{$row['nombre_mision']} EN {$row['nombre_ciudad']}, {$row['nombre_pais']}</td>";
			$tabla .= "<td>{$row['guia']}</td><td>{$row['ingreso']}</td><td>{$row['destinatario']}</td><td>{$row['estatus']}</td>";
			$tabla .= "<td>{$row['creado']}</td><td>{$row['usuario']}</td><td>$opciones</td>";
			$tabla .= '</tr>';		
		}
		$tabla .= '</tbody></table>'; 
    	//$rows = $this->valija_model->buscar_ingreso()  ;	
    	#echo "<script> $('#resultado_busqueda').html('<table id=\"documentostable\"  class=\"display\" cellspacing=\"0\"; width=\"100%\"><thead><tr><th align=\"left\" width=\"80%\">Documento</th><th align=\"left\">Tipo</th><th align=\"left\">Fecha de Carga</th></thead><tbody><tr><td>	<a href=\"#\">Cédula</a></td><td>XX YY ZZ</td><td>22-08-2011</td></tr></tbody></table>');	$('#documentostable').dataTable({'aaSorting': [[ 1, 'asc' ]],						'bAutoWidth':false,						'bStateSave': true,							'bJQueryUI': true,						'sPaginationType': 'full_numbers',						'iDisplayLength': 10,						'oLanguage': {									'sZeroRecords': 'No se encontraron registros!!!'																					}	 });</script>    	";
    	$response .= '<script>';
    	$response .= "$('#fieldset_resultado').show(\"blind\",500);";
    	$response .= "$('#div_resultado').html('$tabla');";
    	$response .= "$('#datatable').dataTable({'aaSorting': [[ 1, 'asc' ]],'bAutoWidth':false, 'bStateSave': true, 'bJQueryUI': true,'sPaginationType': 'full_numbers', 'iDisplayLength': 10,	'oLanguage': {'sZeroRecords': 'No se encontraron registros!!!'} });" ;
    	$response .= '</script>';
    	echo $response ;
    }
         
    function registrar_en_taquilla () {
    	$this->load->model('valija_model');
    	if ($this->input->post('id') == '') {	
    		if ($query = $this->valija_model->registrar_en_taquilla()) {
    			$id   = $this->db->insert_id();
    			register_log('Valija',"Se ingresó una nueva valija en taquilla con en ID => $id",1); 
   				$str  = dialog('Información','¡Valija Registrada Exitosamente!',2);
   				$str .= "<script>$('#id').val('$id');</script>";
   				echo  $str ;   			
    		}
    	}
    	elseif ($this->input->post('id') != '') {    		
    		if ($query = $this->valija_model->editar_en_taquilla()) {
    			$id = $this->input->post('id');
    			register_log('Valija',"Se editó una valija en taquilla con en ID => $id",1);    			    			
   				$str  = dialog('Información','¡Valija Modificada Exitosamente!',2);
   				$str .= "<script> \$('#easydate_a').html('Hece unos segundos');	\$('#easydate_a').attr('title','Hece unos segundos');</script>";   				
   				echo  $str ;
    		}    		
    	}
    }
	
    function listar_registros_en_taquilla (){    	
   		     	
		$tabla = '<table cellspacing="1"  class="display" id="datatable">
				  <thead>
				  <tr>
				  	<th>ID</th><th>Misión</th><th># Guía</th><th># Ingreso</th><th>Destinatario</th><th>Estatus</th><th>Registrado</th><th>Usuario</th><th>Acción</th>
				  </tr>
				  </thead>
				  <tbody>';				
		$rows = $this->valija_model->listar_en_taquilla()  ;		
    	foreach ($rows as $key=> $row) {			
			$tabla .= "	<tr id ='tr_{$row['id']}'>
							<td>{$row['id']}</td>
							<td>{$row['nombre_mision']} EN {$row['nombre_ciudad']}, {$row['nombre_pais']}</td>
							<td>{$row['guia']}</td>
							<td>{$row['ingreso']}</td>
							<td>{$row['destinatario']}</td>
							<td>{$row['estatus']}</td>
							<td>{$row['creado']}</td>
							<td>{$row['usuario']}</td>
							<td>
								<a href='".base_url()."valija/editar_en_taquilla/{$row['id']}'><img src='".base_url()."public/images/editar.png' align='absmiddle'/></a>
								<a href='#' onclick='javascript:eliminar_en_taquilla({$row['id']})'><img src='".base_url()."public/images/delete.png' align='absmiddle'/></a>
							</td>
						</tr>";		
		}
		$tabla .= '</tbody></table>';
		$data ['tabla'] = $tabla;
        $data ['main_content'] 		= 'valija/listar_registros_en_taquilla';
        $this->load->view('sistema/template',$data);
        register_log('Valija',"Acceso a listar / buscar Registro en Taquilla");   
    }
 
    function editar_en_taquilla() {
		if ($data['valija'] = $this->valija_model->get_registro_en_taquilla()) { 
			$id = $this->uri->segment(3);			
			$data ['main_content'] 		= 'valija/frm_editar_en_taquilla';
			$this->load->view('sistema/template',$data); 
			register_log('Acceso',"Acceso al formulario para editar registro en taquilla con el ID => $id");
		}
		else 
			show_404();
			
	}
         
    function eliminar_en_taquilla() {
		$id = $this->uri->segment(3);
		$str = '';		
		if ($this->valija_model->eliminar_en_taquilla()) { 
	   			register_log('Eliminación',"Se eliminó un registro en taquilla con en ID => $id",1);    			    			
   				$str  = dialog('Información','¡Valija Eliminada Exitosamente!',2);
   				$str .= "<script>$('#tr_$id').remove();</script>";  				
    	}
    	else {    		
    		register_log('Eliminación',"Error al tratar de eliminar un registro en taquilla con en ID => $id",1);    			    			
   			$str  = dialog('Atención','¡Error al eliminar el registro!',1); 				
   			
    	}
    	echo $str;
	}

    function generar_pdf(){    	    	
    	$this->load->library('pdf');
    	$this->load->model('usuario_model');
    	#$this->pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH_PORTRAIT);    	    	
        $this->pdf->AddPage('L');
        #$html  = "<h3>Reporte de Valija Registradas en Taquillas</h3>" ;
        $html  = "<h3>Reporte XXX</h3>" ;
		/*$html .= "<table border="1" cellpadding="2" cellspacing="2" nobr="true">
  				 	<tr>
    				<td>Usuario</td>
    				<td>Nombre</td>
    				<td>Cordinacion</td>
  				  	</tr>
  				  	<tr>
    				<td>Usuario</td>
    				<td>Nombre</td>
    				<td>Cordinacion</td>
  				  	</tr>
				  </table>";
		*/
		#$this->pdf->writeHTML($tittle, true, false, false, false, '');
        $html .= "<table border=\"1\" cellpadding=\"2\" cellspacing=\"2\" nobr=\"true\">
  				 	<tr  bgcolor=\"#CCCCCC\" >
    				<td>Usuario</td>
    				<td>Nombre</td>
    				<td>Cordinacion</td>
  				  	</tr>";
        for ($i = 0; $i< 130 ; $i++) {
        	$html .= "<tr><td>Usuario {$i}</td><td>Nombre {$i}</td><td>Cordinacion</td></tr>";
        }  			
		$html .= "</table>";
		$this->pdf->SetY(17);
		$this->pdf->writeHTML($html, true, false, false, false, '');      
		#$this->pdf->writeHTML($html, true, false, false, false, '');
		#$this->pdf->writeHTMLCell($w=0, $h=0, $x='', $y=18, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		$this->pdf->Output('reporte.pdf', 'I');       
		#$this->pdf->SetHeaderData(PDF_HEADER_LOGO, 100);
		#$this->pdf->footer_on = false;
		        
    }
	
}

