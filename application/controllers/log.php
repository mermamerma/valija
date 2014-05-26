<?php

/**
 * 
 * 
 * @author Jesús Rodríguez
 * @version 
 */	

class Log extends Controller {

	function __construct() {
		parent::Controller();
		$this->load->model('log_model');
		is_logged_in();
	}
	    	
	function listar() {
		// load pagination class
    	$this->load->library('pagination');
    	$config['base_url'] 		= base_url().'/log/listar/';
   		$total_rows 				= $this->db->count_all('log');
		$this->config->set_item('enable_query_strings',FALSE);

   		$config['total_rows'] 		= $total_rows;
    	$config['per_page'] 		= 25;
		$data['results']			= array();
		$data['total_rows']			= $total_rows;		
		$data['inicio']				= $config['per_page'];	
		$data['fin']				= $this->uri->segment(3);
    	$this->pagination->initialize($config);    	
	
		$data['results'] = $this->log_model->get_logs($config['per_page'],$this->uri->segment(3));				
		
		$this->load->library('table');
				
		$this->table->set_heading('Id','Usuario', 'IP', 'URL','Modulo','Acción', 'Descripción', 'Fecha');	
		$tmpl = array ('table_open'=>'<table   cellspacing="1" id="datatable" class="display" id="datatable">');
		$this->table->set_template($tmpl); 	

		register_log('Consulta',"Acceso a la Bitácora General");  
		$data ['main_content'] 		= 'sistema/view_log';  
		$this->load->view('sistema/template',$data);  	
    }

	function usuario() {
		$this->load->model('usuario_model');
		$this->load->library('pagination');
		$id_usuario = $this->uri->segment(3);
		$usuario = $this->usuario_model->get_usuario_by_id($id_usuario);
		register_log('Consulta',"Acceso a la Bitacora del Usuario => $usuario->usuario");  
		$this->config->set_item('enable_query_strings',FALSE);
		$total_rows 				= $this->log_model->count_logs_user($id_usuario);  
		$config['uri_segment'] 		= 4;  	
    	$config['base_url'] 		= base_url().'/log/usuario/'.$id_usuario;   		   		
   		$config['total_rows'] 		= $total_rows;   		     		    	
    	$config['per_page'] 		= 20;
    	$data['total_rows']			= $total_rows;
    	$data['usuario']			= $usuario;
		$data['results']			= array();				
		$data['inicio']					= $config['per_page'];	
		$data['fin']					= $this->uri->segment(3);
    	$this->pagination->initialize($config);    	
	
		$data['results'] = $this->log_model->get_logs_user($this->uri->segment(3),$config['per_page'],$this->uri->segment(4));				
		$total = count($data['results']);
		$this->load->library('table');
				
		$this->table->set_heading('usuario', 'IP', 'URL','Modulo', 'Acción', 'Descripción', 'Fecha');	
		$tmpl = array ('table_open'=>'<table border="0" cellpadding="4" cellspacing="0"   class="display" id="datatable">');
		$this->table->set_template($tmpl); 	

		
		$data ['main_content'] 		= 'usuario/view_log_user';  
		$this->load->view('sistema/template',$data);  	
    }
} ### FIN DE CLASE


