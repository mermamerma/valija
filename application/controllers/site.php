<?php

/**
 * 
 * 
 * @author Jesus Rodriguez
 * @version 
 */	

class Site extends Controller {

	function __construct()
	{
		parent::Controller();
		is_logged_in();
		$this->load->model('correspondencia_model');
	}
	
    function index()    
    {
    	register_log('Accesos',"Acceso al Inicio"); 		
    	$data ['main_content']	= 'sistema/inicio_view';
		$data ['cant_corresp']	= $this->correspondencia_model->count_hoy();
    	$data ['usuario'] 		= $this->session->userdata('usuario');    	
    	$this->load->view('sistema/template',$data);
    }   	
    
    
}
