<?php

/**
 * 
 * 
 * @author Jesús Rodríguez
 * @version 
 */	

class Correspondencia extends Controller {
    
	function __construct() {
		parent::Controller();
		$this->load->model('correspondencia_model');
		is_logged_in();
	}
    
    public function index() {

    }    
    
	function formulario() {
        #$this->firephp->setEnabled(FALSE);
       
    	$id = (int) $this->uri->segment(3);       
        $this->firephp->log($id, '$id');
        $script = '';    	
    	$data ['main_content'] = 'correspondencia/frm_correspondencia';    
    	
    	# Agrego las reglas para validar el formulario para un nuevo ingreso
    	$rules[] = ('indice_interno : { required:true, digits:true }');
        $rules[] = ('fecha_ingreso : { required:true, dateDE: true  }');				
        $rules[] = ('id_mision : { required:true }'); 
        $rules[] = ('asunto : { required:true }');    	
        $rules[] = ('numero_ingreso : { required:true, digits:true }');							    	
        $rules[] = ('id_destinatario : { required:true }');
        $rules[] = ('indice_remitente : { required:true, digits:true }');
        $rules[] = ('fecha_correspondencia : { dateDE: true  }');  
        $rules[] = ('id_tipo_documento : { required:true }');
        $rules[] = ('numero_docuemento : { digits:true }');	    	
        $data['rules'] = $rules;    	
    	// Para cargar el registro por el ID pasado en el GET y mostrar el formulario con sus valores para editarlo 
    	if ($id > 0) { 
			$row = $this->correspondencia_model->get_correspondencia($id) ;	
			$data['row'] = $row ;
			$data['script'] = $this->load->view('correspondencia/set_editar', $data, TRUE);
			$algo = $this->load->view('correspondencia/set_editar', $data, TRUE);
	    	$data['momento'] = 'Editar Correspondencia';			
			register_log('Acceso',"Acceso al formulario para editar la correspondencia con ID => $id");	    	
    	}
    	// Cargar el formulario para agregar
    	else {
    		$data['momento'] = 'Registrar Correspondencia';
			$data['script'] = $this->load->view('correspondencia/set_nuevo', $data, TRUE);    		    	
	    	register_log('Acceso',"Acceso al formulario para registrar nueva correspondencia");			
		}		
		$this->load->view('sistema/template',$data);
    }
	
    function guardar() {
    	if ($this->input->post('id') == '') {	
    		if ($query = $this->correspondencia_model->registrar()) {
    			$id   = $this->db->insert_id();
    			register_log('Inserción',"Se ingresó nueva correspondencia con en ID => $id",1); 
   				$str  = dialog('Información','¡Correspondencia Registrada Exitosamente!',2);
   				$str .= "<script>$('#id').val('$id');</script>";   				 
   				echo  $str ;   		
    		}
    	}
    	elseif ($this->input->post('id') != '') {    		
    		if ($query = $this->correspondencia_model->editar()) {
    			$id = $this->input->post('id');
    			register_log('Modificación',"Se modificó la correspondencia con en ID => $id",1);    			    			
   				$str  = dialog('Correspondencia','¡Correspondencia Modificada Exitosamente!',2);
   				$str .= "<script> \$('#fecha_a').html('Justo ahora'); $('#fecha_a').attr('title','Justo ahora');</script>";   				
   				echo  $str ;
    		} 	
    	}
    }

    function listar() {
		// load pagination and table  class
    	$this->load->library('pagination');
    	$this->load->library('table');
    	$config['base_url'] 		= base_url().'/correspondencia/listar/';
        $total_rows 				= $this->utils->count_all_condition('correspondencias', 'estatus = 1' );

        $this->config->set_item('enable_query_strings',FALSE);

        $config['total_rows'] 		= $total_rows;
        $config['per_page'] 		= 10;
        $data['results']			= array();
        $data['total_rows']			= $total_rows;		
        $data['inicio']				= $config['per_page'];	
        $data['fin']				= $this->uri->segment(3);
        $this->pagination->initialize($config);    	
	
		
		$correspondencias = $this->correspondencia_model->get_correspondencias($config['per_page'],$this->uri->segment(3));    			
		
		$this->table->set_tr_id(TRUE);
		$this->table->set_heading('ID', 'Misión', 'Asunto', 'Destinatario', 'Indice Interno', 'Fecha Ingreso', 'Indice Remitente', 
									'Fecha Correspondencia', 'Tipo Documento', '# Documento', 'Entrada por', 'Anexo', 
									'Fecha Elaboración' , 'Creado por', 'Opciones');
		#$this->table->set_heading('1', '2', '3', '4', '5','7','8','9','10','11','12');				
		$tmpl = array ('table_open'=>'<table border="0" width="100%" cellpadding="1" cellspacing="0"  class="display" id="datatable">');		
		
		if ($correspondencias > 0) {				
			foreach ($correspondencias as $row) {								
				$opciones  = "<a href='".base_url()."correspondencia/formulario/{$row->id}'><img title='Editar' src='".base_url()."public/images/editar.png' align='absmiddle'/></a>   ";
				$opciones .= "<a href='#' onclick='javascript:eliminar({$row->id})'><img title='Eliminar' src='".base_url()."public/images/delete.png' align='absmiddle'/></a>";				
				$this->table->add_row($row->id, $row->mision, $row->asunto, $row->destinatario, $row->indice_interno,
									  $row->fecha_ingreso, $row->indice_remitente, $row->fecha_correspondencia,
									  $row->tipo_documento, $row->numero_documento,$row->entrada, $row->anexo, 
									  $row->fecha_creacion, $row->usuario, $opciones  );
			}
		}
		
		$this->table->set_template($tmpl); 	

		register_log('Consulta',"Acceso a la listar Correspondencia");  
		$data ['main_content'] 		= 'correspondencia/listar';  
		$this->load->view('sistema/template',$data); 
    }
	
    function frm_editar () {    	    	        
		if ($data['correspondencia'] = $this->correspondencia_model->get_registro()) {    			 
			$id = $this->uri->segment(3);

			#$data ['main_content'] 		= 'correspondencia/frm_editar';

			$rules[] = ('remitente : { required:true }');
			$rules[] = ('numero : { required:true }');
			$rules[] = ('fecha_correspondencia : { required:true, dateDE: true}');		
			$rules[] = ('fecha_ingreso : { required:true, dateDE: true}');
			$rules[] = ('asunto : { required:true }');    	
			$rules[] = ('asignacion : { required:true }');
			$rules[] = ('fecha_ingreso : { required:true }');

			$data['rules'] = $rules;    	 
			$data ['main_content'] 		= 'correspondencia/frm_editar';

			$this->load->view('sistema/template',$data); 
			register_log('Correspondencia',"Acceso al formulario para editar la correspondencia con el ID => $id");
        }
        else 
			show_404();
	}
	
    function eliminar() {
    	$id = $this->uri->segment(3);
		$str = '';		
		if ($this->correspondencia_model->eliminar($id)) { 
	   			register_log('Eliminación',"Se eliminó una correspondencia con en ID => $id",1);    			    			
   				$str  = dialog('Información','¡Correspondencia Eliminada Exitosamente!',2);
   				$str .= "<script>$('#tr_$id').remove();$('#imprimir_up').css('visibility','hidden'); $('#imprimir_down').css('visibility','hidden');</script>";  				
    	}
    	else {    		
    		register_log('Eliminación',"Error al tratar de eliminar una correspondencia con en ID => $id",1);    			    			
   			$str  = dialog('Atención','¡Error al eliminar el registro!',1); 				
   			
    	}
    	echo $str;
    }

    function frm_buscar_ingreso () {
    	$script = '';
    	$data ['main_content'] = 'correspondencia/frm_buscar_ingreso';    
    	$data['momento'] = 'Buscar Ingreso de Correspondencia';    	
    	#$rules[] = ('indice_interno : { required:true, digits:true }');    	
		$rules[] = ('fecha_ingreso : { dateDE: true  }');		    	
		$data['rules'] = $rules;
    	register_log('Acceso',"Acceso al formulario para Buscar el Ingreso de Correspondencia");	
		$data['script'] = $script;
		$this->load->view('sistema/template',$data);
    }
    
    function do_buscar_ingreso () {
    	sleep(1);
    	$result = $this->correspondencia_model->buscar_ingreso();
		register_log('Consulta',"Se generó una Busqueda en el Ingreso",1);	
     	$this->load->library('table');
    	$this->table->set_tr_id(TRUE);
		$this->table->set_heading('ID', 'Misión', 'Asunto', 'Destinatario', 'Indice Interno', 'Fecha Ingreso', 'Indice Remitente', 
									'Fecha Correspondencia', 'Tipo Documento', '# Documento', 'Entrada por', 'Anexo', 
									'Fecha Elaboración' , 'Creado por', 'Opciones');
		$tmpl = array ('table_open'=>'<table border="0" width="100%" cellpadding="1" cellspacing="0"  class="display" id="datatable">');
   		if ($result) {				
			foreach ($result as $row) {								
				$opciones  = "<a href='".base_url()."correspondencia/formulario/{$row->id}'><img title='Editar' src='".base_url()."public/images/editar.png' align='absmiddle'/></a>   ";
				$opciones .= "<a href='#' onclick='javascript:eliminar({$row->id})'><img title='Eliminar' src='".base_url()."public/images/delete.png' align='absmiddle'/></a>";				
				$this->table->add_row($row->id, $row->mision, $row->asunto, $row->destinatario, $row->indice_interno,
									  $row->fecha_ingreso, $row->indice_remitente, $row->fecha_correspondencia,
									  $row->tipo_documento, $row->numero_documento,$row->entrada, $row->anexo, 
									  $row->fecha_creacion, $row->usuario, $opciones  );
			}
		}
		$bonotes = ($result != 0) ? "$('#imprimir_up').css('visibility','visible'); $('#imprimir_down').css('visibility','visible');":"$('#imprimir_up').css('visibility','hidden'); $('#imprimir_down').css('visibility','hidden');";
		$this->table->set_template($tmpl);
		$out  = '</br>';
		$out .= $this->table->generate();
		$out .= "
				<script>
					var oTable = $('#datatable').dataTable({ 
						'bRetrieve' :true,
						'bJQueryUI': true,
						'sPaginationType': 'full_numbers',
						'iDisplayLength': 10,
						'sScrollX': '80%',
						'bDestroy': true,
						'bScrollCollapse': true
   					});
   				$bonotes;
   				</script> ";
		echo $out ;
    }

    function pdf_ingreso () {
    	$this->load->library('pdf');
		$this->pdf->SetKeywords('');
    	$this->pdf->SetFontSize(7);
        $this->pdf->AddPage('L','LEGAL');              
        $html  = "" ;
        $anio = date('Y');
        $indice_interno = $this->input->post('indice_interno');
        $mision = $this->input->post('mision');
		$titulo = ($this->input->post('titulo') == '')? '' : to_mayuscula($this->input->post('titulo')).'<br/>' ;
        $destinatario = ($this->input->post('destinatario')!= '')? ' - '.$this->input->post('destinatario'):'';
        $fecha_ingreso = $this->input->post('fecha_ingreso');
        $salto1 = str_repeat('<br/>', 3);
        #$salto2 = str_repeat('<br/>', 1);
        $salto2 = '<span style="font-size: 25px;">'.str_repeat('&nbsp;<br/>', 2).'</span>';
        $salto3 = '<span style="font-size: 25px;">'.str_repeat('&nbsp;<br/>', 1).'</span>';
        $salto4 = '<span style="font-size: 25px;">'.str_repeat('&nbsp;<br/>', 4).'</span>';


        $html .= "
		<table  border=\"1\">
		<thead>
			<tr align=\"center\">
				<th colspan=\"12\"  bgcolor=\"#E5E5E5\"><h2  align=\"center\">$titulo RELACIÓN DE CORRESPONDENCIA $anio $destinatario</h2></th>
			</tr>
				<tr align=\"center\" bgcolor=\"#E5E5E5\" style=\"font-weight:bold\">
				<th rowspan=\"3\"><h3>Procedencia</h3></th>
				<th rowspan=\"3\"><h3>Asunto</h3></th>
				<th colspan=\"2\" rowspan=\"2\"><h3>Datos de Ingreso</h3></th>
				<th colspan=\"6\" rowspan=\"2\"><h3>Datos de la Correspondencia</h3></th>
				<th><h3>Indice:</h3> $indice_interno</th>
				<th><h3>Fecha:</h3> $fecha_ingreso</th>
			</tr>
			<tr align=\"center\" bgcolor=\"#E5E5E5\" style=\"font-weight:bold\">
				<th rowspan=\"2\"><h3>Observaciones</h3></th>
				<th rowspan=\"2\"><h3>Creado por</h3></th>
			</tr>
			<tr align=\"center\" bgcolor=\"#E5E5E5\" style=\"font-weight:bold\">
				<th><h3>Número</h3></th>
				<th><h3>Fecha</h3></th>
				<th><h3>Destinatario</h3></th>
				<th><h3>Tipo Documento</h3></th>
				<th><h3>Fecha</h3></th>
				<th><h3>Número</h3></th>
				<th><h3>Indice Valija</h3></th>
				<th><h3>Anexo</h3></th>
			</tr>
		</thead> ";
    	$result = $this->correspondencia_model->buscar_ingreso();
		register_log('Generación',"Se generó un Reporte PDF en el Ingreso",1);	
    	$pos = 1 ;    	    
    	$estiloFila = '';
    	$total_rows = 0 ;
		foreach ($result as $row) {	
			$html .= "<tr align=\"center\" $estiloFila>" ;
			$html .= "<td>{$row->mision}</td>"; 		
			$html .= "<td>{$row->asunto}</td>";
			$html .= "<td>$salto3 {$row->numero_ingreso}</td>";
			$html .= "<td>$salto3 {$row->fecha_ingreso}</td>";
			$html .= "<td>{$row->destinatario}</td>";
			$html .= "<td>$salto3 {$row->tipo_documento}</td>";
			$html .= "<td>$salto3 {$row->fecha_correspondencia}</td>";
			$html .= "<td>$salto3 {$row->numero_documento}</td>";
			$html .= "<td>$salto3 {$row->indice_remitente}</td>";
			$html .= "<td>$salto3 {$row->anexo}</td>";
			$html .= "<td>{$row->observaciones}</td>";			
			$html .= "<td>{$row->usuario}</td>";
			$html .= '</tr>';
			$estiloFila = ($estiloFila=='') ? 'bgcolor="#EEEEFF"' : '';
			$total_rows ++;
		}      
		$html .= "</table>";
		#echo  $html ;
		#echo 'Margen Break: '.$this->pdf->getBreakMargin();
		#die() ;
		#$this->pdf->SetY(17);
		$this->pdf->setFooterText('Relizado por: '.$this->session->userdata('usuario').' el '.date('d-m-Y').' a las '.date('h:i A'));   
		$this->pdf->writeHTML($html, true, false, false, false, ''); 
		$this->pdf->writeHTML("<p><h2>Total Registros: $total_rows</h2></p>", true, false, false, false, '');			
		$this->pdf->Output('reporte.pdf', 'I');		
    }
	
	function diario_destinatario() {
		$this->load->library('parser');
		register_log('Consulta',"Acceso a Diario por Destinatario");  		
		$data ['main_content'] 		= 'correspondencia/diario'; 
		$data['icon'] 		= 'email_go'; 
		$data ['diario']	= $this->correspondencia_model->get_diario_destinatario();
		$data['tabla']		= $this->parser->parse('correspondencia/diario_destinatario', $data, TRUE);
		$data['modo']		= 'Destinatario' ;
		$data['leyenda']		= 'Lista del total correspondencias registradas a cada Destinatario';
		$this->load->view('sistema/template',$data); 
	}
	
	function buscar_diario_destinatario() {
		$this->load->library('parser');
		register_log('Consulta',"Acceso a Diario por Destinatario Buscando por Fechas de Ingreso");  				
		$data ['diario']	= $this->correspondencia_model->get_diario_destinatario();		
		$tabla		= $this->parser->parse('correspondencia/diario_destinatario', $data, TRUE);
		echo $tabla ;
	}
	
	function pdf_diario_destinatario () {
		$data ['diario']	= $this->correspondencia_model->get_diario_destinatario();		
		register_log('Generación',"Se generó PDF del total correspondencia registradas por Destinatario",1); 
		$fecha = date('d-m-Y') ;
		$fecha_ingreso_desde = dateDB($this->input->post('fecha_ingreso_desde') );
		$fecha_ingreso_hasta = dateDB($this->input->post('fecha_ingreso_hasta') );	
		$f_ingreso_desde = $this->input->post('fecha_ingreso_desde') ;
		$f_ingreso_hasta = $this->input->post('fecha_ingreso_hasta') ;	
		
		$titulo = 'CORRESPONDENCIAS REGISTRADAS POR DESTINATARIO' ; 		
		if ($fecha_ingreso_desde == '' AND $fecha_ingreso_hasta == '') 
			$titulo = $titulo.' EL '.$fecha ;
		elseif ($fecha_ingreso_desde != '' AND $fecha_ingreso_hasta != '')
			$titulo = "$titulo DESDE $f_ingreso_desde HASTA EL $f_ingreso_hasta " ;
		elseif ($fecha_ingreso_desde == '' AND $fecha_ingreso_hasta != '') 
			$titulo = "$titulo HASTA EL $f_ingreso_hasta " ;
		elseif ($fecha_ingreso_desde != '' AND $fecha_ingreso_hasta == '') 
			$titulo = "$titulo DESDE EL $f_ingreso_desde " ;
		$data ['titulo']	= $titulo ;
		
		$tabla		= $this->load->view('correspondencia/pdf_diario_destinatario', $data, TRUE);
		$this->load->library('pdf');    	
    	$this->pdf->SetFontSize(7);
        $this->pdf->AddPage('P','LEGAL'); 		
		$this->pdf->setFooterText('Relizado por: '.$this->session->userdata('usuario').' el '.date('d-m-Y').' a las '.date('h:i A'));   
		$this->pdf->writeHTML($tabla, true, false, false, false, ''); 		
		$this->pdf->Output('reporte.pdf', 'I');	
	}
	
	function diario_mision() {
		$this->load->library('parser');
		register_log('Consulta',"Acceso a Diario por Misión");  		
		$data['main_content'] 		= 'correspondencia/diario'; 
		$data['icon'] 		= 'email_web'; 
		$data['diario']	= $this->correspondencia_model->get_diario_mision();
		$data['leyenda']		= 'Lista del total correspondencias enviadas por cada Misión ';
		$data['tabla']		= $this->parser->parse('correspondencia/diario_mision', $data, TRUE); 
		$data['modo']		= 'Misión' ;				
		$this->load->view('sistema/template',$data); 
	}
	
	function buscar_diario_mision() {
		$this->load->library('parser');
		register_log('Consulta',"Acceso a Diario por Misión Buscando por Fechas de Ingreso");  				
		$data ['diario']	= $this->correspondencia_model->get_diario_mision();		
		$tabla		= $this->parser->parse('correspondencia/diario_mision', $data, TRUE);
		echo $tabla ;
	}
	
	function pdf_diario_mision () {
		$data ['diario']	= $this->correspondencia_model->get_diario_mision();		
		register_log('Generación',"Se generó PDF del total correspondencia registradas por Misión",1); 
		$fecha = date('d-m-Y') ;
		$fecha_ingreso_desde = dateDB($this->input->post('fecha_ingreso_desde') );
		$fecha_ingreso_hasta = dateDB($this->input->post('fecha_ingreso_hasta') );	
		$f_ingreso_desde = $this->input->post('fecha_ingreso_desde') ;
		$f_ingreso_hasta = $this->input->post('fecha_ingreso_hasta') ;
		
		$titulo = 'CORRESPONDENCIAS REGISTRADAS POR MISION' ; 		
		if ($fecha_ingreso_desde == '' AND $fecha_ingreso_hasta == '') 
			$titulo = $titulo.' EL '.$fecha ;
		elseif ($fecha_ingreso_desde != '' AND $fecha_ingreso_hasta != '')
			$titulo = "$titulo DESDE $f_ingreso_desde HASTA EL $f_ingreso_hasta " ;
		elseif ($fecha_ingreso_desde == '' AND $fecha_ingreso_hasta != '') 
			$titulo = "$titulo HASTA EL $f_ingreso_hasta " ;
		elseif ($fecha_ingreso_desde != '' AND $fecha_ingreso_hasta == '') 
			$titulo = "$titulo DESDE EL $f_ingreso_desde " ;
		$data ['titulo']	= $titulo ;
		
		$tabla		= $this->load->view('correspondencia/pdf_diario_mision', $data, TRUE);
		$this->load->library('pdf');    	
    	$this->pdf->SetFontSize(7);
        $this->pdf->AddPage('P','LEGAL'); 		
		$this->pdf->setFooterText('Relizado por: '.$this->session->userdata('usuario').' el '.date('d-m-Y').' a las '.date('h:i A'));   
		$this->pdf->writeHTML($tabla, true, false, false, false, ''); 		
		$this->pdf->Output('reporte.pdf', 'I');	
	}
	
}


