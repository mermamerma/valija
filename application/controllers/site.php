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
	}
	
    function index()    
    {
    	register_log('Sistema',"Acceso al Inicio"); 
    	$data ['main_content'] 	= 'sistema/inicio_view';
    	$data ['usuario'] 		= $this->session->userdata('usuario');    	
    	$this->load->view('sistema/template',$data);
    }   	
    
    
}
