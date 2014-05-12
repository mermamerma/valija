<?php

/**
 * 
 * 
 * @author Jesús Rodríguez
 * @version 
 */	

class Usuario extends Controller {

	function __construct() {
		parent::Controller();
		is_logged_in();
		$this->load->model('usuario_model');		
	}
    
	function index() {	
		#die('=>'.$this->session->userdata('id_acceso'));			
		$data ['main_content'] 	= 'usuario/listar_usuarios';		
		$data ['tabla'] 		= $this->listar_usuarios();	
		$this->load->view('sistema/template',$data);		
    }
    
    function listar_usuarios (){
    	$base_url = base_url();	
    	$tabla_html = "	<table cellspacing='1'  class='display' id='datatable'>
    					<thead>
    						<tr>
    							<th>Usuario</th>
    							<th>Nombres</th>
    							<th>coordinación</th>
    							<th>Acceso</th>
    							<th>Estatus</th>
    							<th>Acciones</th>
    						</tr>
    					</thead>";    	
    	$rows = $this->usuario_model->listar_usaurios()  ;    	    	 	
    	foreach ($rows as $key=> $row) {
    				$id 		= $row['id'];
    				$nombres 	= $row['nombres'].' '.$row['apellidos'];
    				$img 		= "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
    				$link		= "<a href='#' onclick=javascript:frm_maestro($id);>$img</a>";
    		    	$tabla_html .= "<tr id='row_{$row['id']}'>
    		    						<td>{$row['usuario']}</td>
    		    						<td>{$row['nombres']} {$row['apellidos']}</td>
    		    						<td>{$row['coordinacion']}</td>
    		    						<td>{$row['acceso']}</td>
    		    						<td><img src='".$base_url."public/images/{$row['img']}' title='Estatus: {$row['estatus']}' align='absmiddle'/></td>
    		    						<td>
    		    						    <a href='".$base_url."usuario/frm_usuario/{$row['id']}'> <img title='Editar Usuario' src='$base_url/public/images/editar.png' align='absmiddle'/></a>
    		    						    <a href='".$base_url."log/usuario/{$row['id']}'> <img title='Ver Bitacora del Usuario'src='$base_url/public/images/log.png' align='absmiddle'/></a>
    		    						</td>    		    						
    		    					</tr>";
    	}		
		$tabla_html .= "</table>";
		return $tabla_html;
    }
    
    function frm_usuario () {
    	
    	$id = $this->uri->segment(3);
    	$options = array(
    	''	=> array(''  => '[Seleccione...]'),
    	'Ingreso'	=> array(1 => 'Coordinación', 	2 => 'Registro', 	3 => 'Taquilla', 4 => 'Apertura'),
    	'Despacho'	=> array(5 => 'Coordinación', 	6 => 'Registro', 	7 => 'Taquilla'),
    	'Sistema'	=> array(8  => 'Administrador')
    	);                 
        
        $data['options'] = $options;    	
    	
    	$rules[] = ('usuario : { required:true }');
		$rules[] = ('id_estatus : { required:true }');
		$rules[] = ('nombres : { required:true }');
		$rules[] = ('apellidos : { required:true }');
		$rules[] = ('id_coordinacion : { required:true }');
		$rules[] = ('id_acceso : { required:true }');
		$data['rules'] = $rules;  	

    	// Para editar
		if (is_numeric($id)) {
			$usuario = $this->usuario_model->get_usuario_by_id($id);
			
			if ($usuario) {
				$script  = '<script>';										
				$script .= "\n$('#id').val('{$usuario->id}');\n";
				$script .= "$('#usuario').val('{$usuario->usuario}');\n";
				$script .= "$('#id_estatus').val('{$usuario->id_estatus}');\n";
				$script .= "$('#nombres').val('{$usuario->nombres}');\n";
				$script .= "$('#apellidos').val('{$usuario->apellidos}');\n";
				$script .= "$('#id_coordinacion').val('{$usuario->id_coordinacion}');\n";
				$script .= "$('#id_acceso').val('{$usuario->id_acceso}');\n";				
				$script .= '</script>';
				$data['accion'] = 'Editar Usuario';			
				$data['script'] = $script;
				$nombre_usuario = $this->usuario_model->get_nombre_usuario($id);
				register_log('Usuario',"Acceso al formulario para modificar el usuario $nombre_usuario");
			}			
			
		}
		// Para cargar cargar el formulario y agregar
		else {			
			$data['accion'] = 'Agregar Usuario';			
			$data['script'] = '';
			register_log('Usuario',"Acceso al formulario para agregar un usuario");	
		}
		$data ['main_content'] 		= 'usuario/frm_usuario';  
		$this->load->view('sistema/template',$data);  	
    }

	function procesar () {
		$duplicado 	= $this->usuario_model->duplicado()	;
		$id 		= $this->input->post('id')	;
		$usuario 	= $this->input->post('usuario')	;
		$str		=	'';	
		if (($id == '') AND (!$duplicado)) {		
			$id = $this->usuario_model->agregar() ;
			register_log('Usuario',"Se agregó el usuario \"$usuario\" bajo el ID => $id",1);    	 	
			$str  	= dialog('Información','¡Usuario Agregado Satisfactoriamente!',2);   						  	
		}
		elseif (($id == '') AND ($duplicado)) {			
			register_log('Usuario',"Se intentó agregar el usaurio \"$usuario\" que ya estaba registrado",1);    	 	
			$str  	= dialog('Error',"¡Usuario \"$usuario\" ya esta registrado en el sistema!",1);	  		
		}		
		elseif ($id != '') {
			$this->usuario_model->editar() ;
			register_log('Usuario',"Se editó el usuario \"$usuario\"",1);    	 	
			$str  	= dialog('Información','¡Usuario Modificado Satisfactoriamente!',2);	  	
		}
		echo $str;
	}
}