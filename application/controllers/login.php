<?php

/**
 * 
 * 
 * @Jesus Rodriguez
 * @version 
 */	

class Login extends Controller {

    function __construct() 
	{
		parent::Controller();
	}
    
    function index()
	{
		$esta_logueado = $this->session->userdata('esta_logueado'); 
    	
    	if(! isset($esta_logueado) || $esta_logueado != true)
    	{
			$data ['main_content'] = 'sistema/form_login_view';
    		$this->load->helper('html','url');
    		$this->load->view('sistema/template_logoff',$data);
    	}
    	else 
    	{
    		redirect('site');
    	}
    }
    
    function username_check($str)	{
		$this->load->model('Usuario_model');
		$usuario  = $this->input->post('usuario');
		$password = $this->input->post('password');
		
		$flag = strpos($usuario,'@');		
		if ($flag){
			$pos = strpos($usuario,'@');
			$usuario = substr($usuario,0,$pos);
		}
		
		#die($usuario);
		
    	$sistema = $this->Usuario_model->validar_en_sistema($usuario);
    	$ldap = $this->Usuario_model->validar_en_ldap($usuario, $password);
    	#$ldap = true ;
    	if ($sistema && $ldap)
    	{	
    		$usuario = $this->Usuario_model->get_usuario($usuario);
    		$data = array('usuario'=>$this->input->post('usuario'), 'esta_logueado'=> true);
    		$this->session->set_userdata($data);
    		$this->session->set_userdata($usuario);
    		$this->session->set_userdata($data);
    		$this->session->set_userdata($usuario);
    		#var_dump($usuario);
    		return TRUE;
		}
		else
		{
			$this->form_validation->set_error_delimiters('<p class="warning_message">', '</p>');
			if (!$sistema){
				$this->form_validation->set_message('username_check','Usuario Invalido en el Sistema de Valija Diplomática');
				register_log('Login',"Usuario Invalido en el Sistema de Valija Diplomática => $usuario");
			}
			elseif (!$ldap) {
				$this->form_validation->set_message('username_check','Usuario y/o Contraseña Invalida en el LDAP');	
				register_log('Login',"Usuario y/o Contraseña Invalida en el LDAP => $usuario");
			}			
			return FALSE;
		}		
	}
    
    function validar_usuario()  {
    	
    	$this->load->library('form_validation');
    	if ($this->input->post('usuario') != ''		AND		$this->input->post('password') != '')
    	{
    		$this->form_validation->set_error_delimiters('<p class="warnig_message">', '</p>');
    		$this->form_validation->set_rules('usuario', 'Usuario', 'callback_username_check');
    	}
    	else
    	{ 
    		$this->form_validation->set_error_delimiters('<p class="error_message">', '</p>');
    		$this->form_validation->set_rules('usuario', 'Nombre de Usuario','trim|required');
    		$this->form_validation->set_rules('password', 'Contrañesa','required');    	   	
    	}

    	
    	if ($this->form_validation->run() == false)
    	{
    		 $this->index();
    	}
    	else
    	{
    		register_log('Login',"Sesión abierta en el Sistema de Valija Dilplomática");    		
    		redirect('site'); 
    	}
    		
    }    
  
    function logoff()    {
    	register_log('Login','Sesión cerrada en el Sistema de Valija Dilplomática');
    	$this->session->sess_destroy();
    	redirect(base_url());	
    }
    
    function sesion_requerida() {
    	$data ['main_content'] = 'sistema/form_login_view';
    	$data ['msj'] = "<p class=\"warning_message\">Sesión Experida. Para Acceder al Sistema de Valija Diplomática debe Iniciar Sesión</p>";
    	$this->load->helper('html','url');
    	$this->load->view('sistema/template_logoff',$data);
    }
}