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
		register_log('Acceso',"Lista de Los Usuarios en el Sistema",1);			
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
    							<th>Rol</th>
    							<th>Estatus</th>
    							<th>Acciones</th>
    						</tr>
    					</thead>";    	
    	$rows = $this->usuario_model->listar_usaurios()  ;    	    	 	
    	foreach ($rows as $key=> $row) {
    				$id 		= $row['id'];    				
    				$img 		= "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
    				$link		= "<a href='#' onclick=javascript:frm_maestro($id);>$img</a>";
    		    	$tabla_html .= "<tr id='row_{$row['id']}'>
    		    						<td>{$row['usuario']}</td> 						
    		    						<td>{$row['acceso']}</td>
    		    						<td><img src='".$base_url."public/images/{$row['img']}' title='Estatus: {$row['estatus']}' align='absmiddle'/></td>
    		    						<td>
    		    						    <a href='".$base_url."usuario/formulario/{$row['id']}'> <img title='Editar Usuario' src='$base_url/public/images/editar.png' align='absmiddle'/></a>
    		    						    <a href='".$base_url."log/usuario/{$row['id']}'> <img title='Ver Bitacora del Usuario'src='$base_url/public/images/log.png' align='absmiddle'/></a>
    		    						</td>    		    						
    		    					</tr>";
    	}		
		$tabla_html .= "</table>";
		return $tabla_html;
    }
    
    function formulario () {
    	
    	$id = $this->uri->segment(3);
    	$options = array(
    	''	=> array(''		=> '[Seleccione...]'),
    	'Valija'			=> array(2  => 'Coordinación', 	3 => 'Ingreso', 	4 => 'Despacho', 9=> 'Ingreso-Despacho'),
    	'Correspondencia'	=> array(5 => 'Coordinación', 	6 => 'Ingreso'),
		'Mixto'				=> array(7 => 'Valija - Correspondencia'),
    	'Sistema'	=> array(1  => 'Administrador')
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
				#var_dump($usuario);exit;
				$personal = $this->usuario_model->get_personal($usuario->cedula) ;
				$script  = '<script>';										
				$script .= "\n$('#id').val('{$usuario->id}');\n";
				$script .= "$('#id_personal').val('{$usuario->id_personal}');\n";
				$script .= "$('#cedula').val('{$usuario->cedula}');\n";
				$script .= "$('#usuario').val('{$usuario->usuario}');\n";
				$script .= "$('#id_estatus').val('{$usuario->id_estatus}');\n";
				$script .= "$('#nombres').val('{$personal->primer_nombre} {$personal->segundo_nombre}');\n";
				$script .= "$('#apellidos').val('{$personal->primer_apellido} {$personal->segundo_apellido}');\n";
				$script .= "$('#id_acceso').val('{$usuario->id_acceso}');\n";	
				$script .= "$('#cedula').attr('readonly',true);\n";
				$script .= "$('#cedula').removeClass();\n";
				$script .= "$('#cedula').addClass('element text_gris medium-form');\n";
				$script .= "$('#img_buscar').hide();\n";		
				$script .= '</script>';
				$data['accion'] = 'Editar Usuario';			
				$data['script'] = $script;
				$nombre_usuario = $this->usuario_model->get_nombre_usuario($id);
				register_log('Acceso',"Formulario para modificar el usuario $nombre_usuario");
			}			
			
		}
		// Para cargar cargar el formulario y agregar
		else {			
			$data['accion'] = 'Agregar Usuario';			
			$data['script'] = '';
			register_log('Acceso',"Formulario para agregar un usuario");	
		}
		$data ['main_content'] 		= 'usuario/frm_usuario';  
		$this->load->view('sistema/template',$data);  	
    }

	function procesar () {
		$id 		= $this->input->post('id') ;
		$usuario 	= $this->input->post('usuario')	;
		$duplicado 	= $this->usuario_model->duplicado()	;
		$ldap		= $this->usuario_model->existe_en_ldap($usuario) ;
		
		$str		=	'';	
		if ($ldap != TRUE) {	# Error, No existe en LDAP		
			register_log('Error',"Se intentó agregar el usuario \"$usuario\" el cual no existe en el LDAP ",1);    	 	
			$msj = "El usuario <b>$usuario</b>, no posee correo institucional ó el Nombre de Usuario no coincide con el del correo. ";
			$msj .= "Cerciórese de la información suministrada ó contacte al personal de informática para crearle el Correo Institucional.";
			$str  	= dialog('Error',$msj,1);	  	
		}
		elseif (($id == '') AND ($duplicado)) {	# Error al agregar un usuario ya existente
			register_log('Error',"Se intentó agregar el usaurio \"$usuario\" que ya estaba registrado",1);    	 	
			$str  	= dialog('Error',"¡Usuario \"$usuario\" ya esta registrado en el sistema!",1);	  		
		}	
		elseif (($id == '') AND (!$duplicado)) {	# Agregó el usuario ya que no existe		
			$id = $this->usuario_model->agregar() ;
			register_log('Inserción',"Se agregó el usuario \"$usuario\" bajo el ID => $id",1);    	 	
			$str  	= dialog('Información','¡Usuario Agregado Satisfactoriamente!',2);   						  	
		}			
		elseif ($id != '') { # Modifico el Usuario
			$this->usuario_model->editar() ;
			register_log('Actualización',"Se editó el usuario \"$usuario\"",1);
			$str  	= dialog('Información','¡Usuario Modificado Satisfactoriamente!',2);	  	
		}		
		echo $str;
	}	
		
	function buscar_sigefirrhh(){	
		$cedula 	= (int) $this->input->post('cedula')	;
		$personal	= $this->usuario_model->get_personal($cedula) ;		
		register_log('Consulta',"Se busco la C.I. $cedula en el SIGEFIRRHH",1);
		if ($personal !== FALSE) {
				$usuario = $personal->primer_nombre.'.'.$personal->primer_apellido.substr($cedula,-3,3);
				$usuario = to_minuscula($usuario);
				$response  = '<script>';										
				$response .= "\n$('#id_personal').val('{$personal->id_personal}');\n";
				$response .= "$('#nombres').val('{$personal->primer_nombre} {$personal->segundo_nombre}');\n";
				$response .= "$('#apellidos').val('{$personal->primer_apellido} {$personal->segundo_apellido}');\n";
				$response .= "$('#usuario').val('{$usuario}');\n";
				$response .= '</script>';
		}
		else {			
			$response  	= dialog('Información',"¡Cédula $cedula no existe en SIGEFIRRHH!",1) ;
		}
		echo $response;
	}
	
}