<?php

/**
 * 
 * 
 * @author
 * @version 
 */	

class Test extends Controller {

    function __construct() {
		parent::Controller();
		$this->load->model('valija_model');
                $this->load->model('usuario_model');
		#is_logged_in();
	}
	
    function phpinfo() {		
		echo phpinfo();
	}
    
    function index() {
        echo 'dentro del index';
	#$data ['main_content'] 		= 'test/test';
        #$this->load->view('test/test',$data);
        
        #$data ['main_content'] = 'test/test';
        #$this->load->view('sistema/template',$data);
    	
    }
    
    function saludo1 () {
        echo 'Saludo';
    }
    
    function saludo2 ($nombre) {
        echo "Saludo $nombre";
        
    }
    
    function cargar_vista () {
        
        $data['nombre'] = 'Jesus';
        #$this->load->model('usuario_model');
       # $data['usuario'] =  $this->usuario_model->get_nombre_usuario(1);
        #$data['nombre'] = 'Jesus';  
        $this->load->view('test/vistica',$data);
    }           
    
    function procesar_vista () {
        echo 'Proceso la vista OK.. Con el nombre de usuario :'.$this->input->post('usuario') ;
    }
            
    function fecha(){ 
		// Los delimitadores pueden ser barra, punto o guión
		$fecha = "04/30/1973";
		list($mes, $día, $año) = split('[/.-]', $fecha);
		echo "Mes: $mes; Día: $día; Año: $año<br />\n";
    }
  
    function probar_data_table() {
        $data ['main_content'] 		= 'test/probar_data_table';
        $this->load->view('sistema/template',$data);
	}

    function probar_jqgrid(){
	$data['tabla'] = 'al Pelo';
	$data ['main_content'] 		= 'test/probar_jqgrid';
        $this->load->view('sistema/template',$data);
	}

    function exportar () {      
        $this->load->model('correspondencia_model');
        $rs = $this->usuario_model->listar_usaurios_obj();
        export_to_xls($rs) ;
        
    }
    
   }

