<?php

/**
 * 
 * 
 * @author
 * @version 
 */	

class Maestro extends Controller {
	 
	var $maestro = array();
	
	function __construct() {	
		parent::Controller();
		is_logged_in();
		
		$this->maestro[] =array('desc' => 'Coordinaciones', 			'nombre_tabla'=>'coordinaciones'); // 0
		$this->maestro[] =array('desc' => 'Courriers', 					'nombre_tabla'=>'courriers');	// 1
		$this->maestro[] =array('desc' => 'Estatus de Valija',			'nombre_tabla'=>'estatus_valija'); // 2
		$this->maestro[] =array('desc' => 'Estatus en Taquilla', 		'nombre_tabla'=>'estatus_taquilla'); // 
		$this->maestro[] =array('desc' => 'Marcas de Candado',			'nombre_tabla'=>'marcas_candado'); // 4
		$this->maestro[] =array('desc' => 'Tipos de Asunto',			'nombre_tabla'=>'tipo_asunto'); // 5
		$this->maestro[] =array('desc' => 'Tipos de Contenido',			'nombre_tabla'=>'tipo_contenido'); // 6
		$this->maestro[] =array('desc' => 'Tipos de Correspondencia',	'nombre_tabla'=>'tipo_correspondencia'); // 7
		$this->maestro[] =array('desc' => 'Tipos de Registro',			'nombre_tabla'=>'tipo_registro'); // 8
		$this->maestro[] =array('desc' => 'Tipos de Valija',			'nombre_tabla'=>'tipo_valija'); //9
		$this->maestro[] =array('desc' => 'Paises',						'nombre_tabla'=>'paises'); //10
		$this->maestro[] =array('desc' => 'Tipos de Misión',			'nombre_tabla'=>'tipo_mision'); //11
        $this->maestro[] =array('desc' => 'Ubicaciones',                'nombre_tabla'=>'ubicaciones'); //12
		
		$this->load->model('maestro_model');
		$this->load->library('table');
	}
    
	public function index() {
    	$img = "<img src='".base_url()."public/images/lupa.png' align='absmiddle'/>";
    	$link = "<a href='#' onclick=javascript:detalle_maestro" ;
    	
    	$this->table->set_template(array ( 'table_open'  => '<table cellspacing="1"  class="display" id="datatable">' )); 
    	$this->table->set_heading(array('Tabla', '-'));
    	$this->table->add_row(array($this->maestro[0]['desc'],	"$link(0);>$img</a>"));    	
    	$this->table->add_row(array($this->maestro[1]['desc'],	"$link(1);>$img</a>"));
    	$this->table->add_row(array($this->maestro[2]['desc'],	"$link(2);>$img</a>"));
    	$this->table->add_row(array($this->maestro[3]['desc'],	"$link(3);>$img</a>"));
    	$this->table->add_row(array($this->maestro[4]['desc'],	"$link(4);>$img</a>"));
    	$this->table->add_row(array($this->maestro[5]['desc'],	"$link(5);>$img</a>"));
    	$this->table->add_row(array($this->maestro[6]['desc'],	"$link(6);>$img</a>"));
    	$this->table->add_row(array($this->maestro[7]['desc'],	"$link(7);>$img</a>"));
    	$this->table->add_row(array($this->maestro[8]['desc'],	"$link(8);>$img</a>"));
    	$this->table->add_row(array($this->maestro[9]['desc'],	"$link(9);>$img</a>"));
    	$this->table->add_row(array($this->maestro[10]['desc'],	"$link(10);>$img</a>"));    	
    	$this->table->add_row(array($this->maestro[11]['desc'],	"$link(11);>$img</a>"));
        $this->table->add_row(array($this->maestro[12]['desc'], "$link(12);>$img</a>"));
    	
		$data ['tabla'] = $this->table->generate(); 
		$data ['main_content'] 		= 'sistema/maestro/maestro'; 
		register_log('Sistema',"Acceso al listado Maestro Pricipal");
		$this->load->view('sistema/template',$data);
    }
    
    function procesar() { 
    	$id_tabla 		= $this->input->post('id_tabla') ;
    	$nombre_tabla	= $this->maestro[$id_tabla]['nombre_tabla'];
    	$nombre 		= strtoupper(trim($this->input->post('nombre'))) ;
    	$id		 		= $this->input->post('id_row');
    	$str 			= '';
    	$img 			= "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
    	$nombre_prepared = str_replace(' ','_',$nombre);    	
    	$accion			= ($this->input->post('id_row') == '') ? 'agregar' : 'modificar';
    	
    	if (!$this->maestro_model->duplicado()) {
    		if ($this->input->post('id_row') == '') {    			    		
    			if (!$this->maestro_model->duplicado()) {
	    			$id = $this->maestro_model->agregar() ;
	    			$accion = 'agregar';
    				register_log('Maestro',"Se agregó un nuevo registro en la tabla $nombre_tabla bajo el ID => $id",1);    	 	
   					$str  	= dialog('Información','¡Registro Agregado Satisfactoriamente!',2);
   					$link	= "<a href='#' onclick=javascript:frm_maestro($id,'$nombre_prepared',$id_tabla);>$img</a>";
   					#$str 	.= "<script>$('#datatable').dataTable().fnAddData( ['$nombre', \"$link\" ] );	</script>";   				
   					$str 	.= "<script>$( \"#datatable tbody\" ).append(\"<tr style='background-color:#A2FFA2'><td id='row_td1_$id'>$nombre</td><td id='row_td2_$id'>$link</td></tr>\");</script>";
    			}    		
    		}
    		else {   		
    			$this->maestro_model->modificar();
    			$accion = 'modificar';
    			register_log('Maestro',"Se modificó un registro en la tabla $nombre_tabla bajo el ID => $id",1);
    			$link	= "<a href='#' onclick=javascript:frm_maestro($id,'$nombre_prepared',$id_tabla);>$img</a>";
    	 		$str  	= dialog('Información','¡Registro Modificado Satisfactoriamente!',2);    	 	
				$str	.= "<script>$(\"#row_td1_$id\").html(\"$nombre\"); $(\"#row_td2_$id\").html(\"$link\");</script>";
    		}
    	} else {
    		 	register_log('Maestro',"Se intentó $accion un registro con nombre duplicado en la tabla $nombre_tabla",1);
    			$str  	= dialog('Información',"¡Error, el valor \"$nombre\" ya existe con el mismo nombre!",1); 
    	}
    	    	
		echo $str;
    }
    
	function detalle() {
		$id_tabla = $this->uri->segment(3);
		$data ['id_tabla']	 	= $id_tabla;
		$data ['nombre_tabla']	= $this->maestro[$id_tabla]['nombre_tabla'];
		$data ['desc'] 			= $this->maestro[$id_tabla]['desc'];
		$data ['tabla'] 		= $this->datatable_detalle($id_tabla);			
		$data ['main_content'] 	= 'sistema/maestro/detalle_maestro'; 
		register_log('Sistema',"Acceso al listado Maestro - {$data['desc']} ");
		$this->load->view('sistema/template',$data);
	}

    function datatable_detalle($tabla) {    
        $tabla_html = " <table cellspacing='1'  class='display' id='datatable'><thead><tr><th>Nombre</th><th>Opciones</th></tr></thead>";       
        $rows = $this->maestro_model->get_detalle($this->maestro[$tabla]['nombre_tabla'])  ;                    
        foreach ($rows as $key=> $row) {
                    $id         = $row['id'];
                    $nombre     = str_replace(' ','_',$row['nombre']);
                    $img        = "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
                    $link       = "<a href='#' onclick=javascript:frm_maestro($id,'$nombre',$tabla);>$img</a>";
                    $tabla_html .= "<tr id='row_{$row['id']}'><td id='row_td1_{$row['id']}'>{$row['nombre']}</td><td id='row_td2_{$row['id']}'>$link</td></tr>";
        }       
        $tabla_html .= "</table>";
        return $tabla_html;
    }

	function ciudades() {
		$data ['tabla'] 		= $this->datatable_ciudades();			
		$data ['main_content'] 	= 'sistema/maestro/detalle_ciudades'; 
		register_log('Sistema',"Acceso al listado Maestro Ciudades");
		$this->load->view('sistema/template',$data);
	}	

    function datatable_ciudades() { 
        $tabla_html = " <table cellspacing='1'  class='display' id='datatable'><thead><tr><th>Ciudad</th><th>País</th><th>Opciones</th></tr></thead>";      
        $rows = $this->maestro_model->get_ciudades()  ;                         
        foreach ($rows as $row) {
                    $id_ciudad  = $row->id_ciudad;
                    $img        = "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
                    $link       = "<a href='".base_url()."maestro/frm_ciudad/$id_ciudad'>$img</a>";
                    $tabla_html .= "<tr><td>{$row->nombre_ciudad}</td><td>{$row->nombre_pais}</td><td>$link</td></tr>";
        }       
        $tabla_html .= "</table>";
        return $tabla_html;
    }

	function frm_ciudad () {
    	
    	$id = $this->uri->segment(3);    	
    	$rules[] = ('nombre_ciudad : { required:true }');		
    	$rules[] = ('id_pais : { required:true }');		 	

    	// Para editar
		if (is_numeric($id) and $id > 0) {
			$row = $this->maestro_model->get_ciudad($id);	
            #die($row->nombre_ciudad);
            #die(var_dump($row))	;
			if ($row) { 
				$rules[] = ('id_ciudad : { required:true }');
				$script  = '<script>';										
				$script .= "\n$('#id_ciudad').val('{$row->id_ciudad}');\n";
				$script .= "$('#nombre_ciudad').val('{$row->nombre_ciudad}');\n";
				$script .= "$('#id_pais').val('{$row->id_pais}');\n";
				$script .= "$('#nombre_pais').val('{$row->nombre_pais}');\n";
				$script .= '</script>';
				$data['accion'] = 'Editar Ciudad';			
				$data['script'] = $script;				
				register_log('Usuario',"Acceso al formulario para modificar la ciudad {$row->nombre_ciudad}");
			}						
		}
		// Para cargar cargar el formulario y agregar
		else {			
			$data['accion'] = 'Agregar Ciudad';			
			$data['script'] = '';
			register_log('Maestro',"Acceso al formulario para agregar una ciudad");	
		}
		$data['rules'] = $rules; 
		$data ['main_content'] 		= 'sistema/maestro/frm_ciudad';  
		$this->load->view('sistema/template',$data);  	
    }
	
    function procesar_ciudad() { 
    	$id_ciudad 		= $this->input->post('id_ciudad') ;
    	$nombre_ciudad	= strtoupper(trim($this->input->post('nombre_ciudad'))) ;
    	$id_pais 		= $this->input->post('id_pais') ;    	
    	$esta = $this->maestro_model->ciudad_duplicada();
    	if (!$esta and $id_ciudad == '' and $id_pais != '')  { 
	    	$id = $this->maestro_model->agregar_ciudad() ;
	    	$accion = 'agregar';
    		register_log('Maestro',"Se agregó una ciudad nueva con el nombre \"$nombre_ciudad\" bajo el ID => $id",1);    	 	
   			$str  	= dialog('Información','¡Ciudad Agregada Satisfactoriamente!',2);   			
   			$str 	.= "<script>$('#id_ciudad').val('$id')</script>\n";  					
    	}    		
    	elseif (!$esta and $id_ciudad != '' and $id_pais != '') {   		
    		$this->maestro_model->modificar_ciudad();
    		$accion = 'modificar';
    		register_log('Maestro',"Se modificó la ciudad \"$nombre_ciudad\" bajo el ID => $id_ciudad",1);    		
    	 	$str  	= dialog('Información','¡Ciudad Modificada Satisfactoriamente!',2);    	 	
			#$str	.= "<script>$(\"#row_td1_$id\").html(\"$nombre\"); $(\"#row_td2_$id\").html(\"$link\");</script>";
    	}    	
    	elseif ($esta and $id_ciudad != '' and $id_pais != '') {
    		register_log('Maestro',"Se intentó agregar la ciudad \"$nombre_ciudad\" ya existente ",1);
    		$str  	= dialog('Información',"¡Error, la ciudad \"$nombre_ciudad\" ya existe con el mismo nombre y con el mismo país!",1); 
    	}
    	echo $str;
    }

    function misiones() {
        $data ['tabla']         = $this->datatable_misiones();          
        $data ['main_content']  = 'sistema/maestro/detalle_misiones'; 
        register_log('Sistema',"Acceso al listado Maestro Misiones");
        $this->load->view('sistema/template',$data);
    }
    
    function datatable_misiones() { 
        $tabla_html = " <table cellspacing='1'  class='display' id='datatable'><thead><tr><th>Tipo de Misión</th><th>Ciudad</th><th>País</th><th>Opciones</th></tr></thead>";      
        $rows = $this->maestro_model->get_misiones()  ;                         
         foreach ($rows as $row) {
                    $id_mision  = $row->id_mision;
                    $img        = "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
                    $link       = "<a href='".base_url()."maestro/frm_mision/$id_mision'>$img</a>";
                    $tabla_html .= "<tr><td>{$row->nombre_mision}</td><td>{$row->nombre_ciudad}</td><td>{$row->nombre_pais}</td><td>$link</td></tr>";
        }       
        $tabla_html .= "</table>";
        return $tabla_html;
    }

    function frm_mision () {
        
        $id_mision = $this->uri->segment(3);               
        $rules[] = ('id_ciudad : { required:true }'); 
        $rules[] = ('id_tipo_mision : { required:true }');   
        $rules[] = ('nro_expediente : { digits:true }');      

        // Para editar
        if (is_numeric($id_mision) and $id_mision > 0) {
            $rules[] = ('id_mision : { required:true }');   
            $row = $this->maestro_model->get_mision($id_mision);   
            #die($row->nombre_ciudad);
            #die(var_dump($row))    ;
            if ($row) { 
                $nombre_ciudad = $row->ciudad.', '.$row->pais;
                $rules[] = ('id_ciudad : { required:true }');
                $script  = '<script>';                                      
                $script .= "\n$('#id_mision').val('{$row->id_mision}');\n";
                $script .= "$('#id_ciudad').val('{$row->id_ciudad}');\n";
                $script .= "$('#nombre_ciudad').val('{$nombre_ciudad}');\n";
                $script .= "$('#id_tipo_mision').val('{$row->id_tipo_mision}');\n";
                $script .= "$('#nro_expediente').val('{$row->nro_expediente}');\n";
                $script .= '</script>';
                $data['accion'] = 'Editar Misión';          
                $data['script'] = $script;              
                register_log('Usuario',"Acceso al formulario para modificar la misión {$row->tipo_mision}");
            }                       
        }
        // Para cargar cargar el formulario y agregar
        else {          
            $data['accion'] = 'Agregar Misión';         
            $data['script'] = '';
            register_log('Maestro',"Acceso al formulario para agregar una misión"); 
        }
        $data['rules'] = $rules; 
        $data ['main_content']      = 'sistema/maestro/frm_mision';  
        $this->load->view('sistema/template',$data);    
    }	

    function procesar_mision() { 
        $id_mision      = $this->input->post('id_mision') ;
        $id_ciudad      = $this->input->post('id_ciudad') ;
        $id_tipo_mision = $this->input->post('id_tipo_mision') ;
        $nro_expediente = $this->input->post('nro_expediente') ;
        $nombre_ciudad  = ucfirst(strtolower($this->input->post('nombre_ciudad'))) ;       
        $esta = $this->maestro_model->mision_duplicada();
        if (!$esta and $id_mision == '' )  { 
            $id = $this->maestro_model->agregar_mision() ;
            $accion = 'agregar';
            register_log('Maestro',"Se agregó una nueva misión en \"$nombre_ciudad\" bajo el ID => $id",1);          
            $str    = dialog('Información','¡Misión Agregada Satisfactoriamente!',2);               
            $str    .= "<script>$('#id_mision').val('$id')</script>\n";                     
        }           
        elseif (!$esta and $id_ciudad != '') {           
            $this->maestro_model->modificar_mision();
            $accion = 'modificar';
            register_log('Maestro',"Se modificó la misión \"$nombre_ciudad\" bajo el ID => $id_ciudad",1);          
            $str    = dialog('Información','¡Misión Modificada Satisfactoriamente!',2);         
            #$str   .= "<script>$(\"#row_td1_$id\").html(\"$nombre\"); $(\"#row_td2_$id\").html(\"$link\");</script>";
        }       
        elseif ($esta and $id_ciudad != '') {
            register_log('Maestro',"Se intentó agregar una Misión en \"$nombre_ciudad\" al parecer ya existe",1);
            $str    = dialog('Información',"¡Error, La Misión en \"$nombre_ciudad\" ya existe con el mismo tipo y en la misma ciudad!",1); 
        }
        echo $str;
    }

    function estructuras() {
        $data ['tabla']         = $this->datatable_estructuras();          
        $data ['main_content']  = 'sistema/maestro/detalle_estructuras'; 
        register_log('Sistema',"Acceso al listado Maestro Estructuras");
        $this->load->view('sistema/template',$data);
    }

    function frm_estructura() {
        
        $id = $this->uri->segment(3);       
        $rules[] = ('nombre_estructura : { required:true }');       
        $rules[] = ('id_ubicacion : { required:true }');         

        // Para editar
        if (is_numeric($id) and $id > 0) {
            $row = $this->maestro_model->get_registro('estructura',array('id' => $id));   
            if ($row) { 
                $rules[] = ('id_estructura : { required:true }');                                               
                $script  = '<script>';                                      
                $script .= "\n$('#id_estructura').val('{$row->id}');\n";
                $script .= "$('#id_ubicacion').val('{$row->id_ubicacion}');\n";
                $script .= "$('#nombre_estructura').val('{$row->nombre}');\n";                
                $script .= '</script>';
                $data['accion'] = 'Editar Estructura';          
                $data['script'] = $script;              
                register_log('Usuario',"Acceso al formulario para modificar la estructura {$row->nombre}");
            }
            else
                show_404();                       
        }
        // Para cargar cargar el formulario y agregar
        else {          
            $data['accion'] = 'Agregar Estructura';         
            $data['script'] = '';
            register_log('Maestro',"Acceso al formulario para agregar una Estructura"); 
        }
        $data['rules'] = $rules; 
        $data ['main_content']      = 'sistema/maestro/frm_estructura';  
        $this->load->view('sistema/template',$data);    
    }

    function datatable_estructuras() { 
        $tabla_html = " <table cellspacing='1'  class='display' id='datatable'><thead><tr><th>Estructura</th><th>Ubicación</th><th>Opciones</th></tr></thead>";      
        $rows = $this->maestro_model->get_estructuras()  ;                         
        foreach ($rows as $row) {
                    $id_estructura  = $row->id_estructura;
                    $img        = "<img src='".base_url()."public/images/editar.png' align='absmiddle'/>";
                    $link       = "<a href='".base_url()."maestro/frm_estructura/$id_estructura'>$img</a>";
                    $tabla_html .= "<tr><td>{$row->estructura}</td><td>{$row->ubicacion}</td><td>$link</td></tr>";
        }       
        $tabla_html .= "</table>";
        return $tabla_html;
    }

    function procesar_estructura() { 
        $id_estructura      = $this->input->post('id_estructura') ;
        $id_ubicacion       = $this->input->post('id_ubicacion') ;
        $nombre_estructura  = strtoupper(($this->input->post('nombre_estructura'))) ;       
        $esta = $this->maestro_model->estructura_duplicada();
        #if($esta)
        #	echo 'SI ta';
        #else 
       # 	echo 'No TA';        
        if (!$esta and $id_estructura == '' )  { 
            $id_estructura = $this->maestro_model->agregar_estructura() ;
            register_log('Maestro',"Se agregó una nueva estructura con el nombre \"$nombre_estructura\" bajo el ID => $id_estructura",1);          
            $str    = dialog('Información','¡Estructura Agregada Satisfactoriamente!',2);               
            $str    .= "<script>$('#id_estructura').val('$id_estructura')</script>\n";                     
        }           
        elseif (!$esta and $id_estructura != '') {                        
            $this->maestro_model->update_record('estructura',array('id_ubicacion'=>$id_ubicacion,'nombre'=>$nombre_estructura),array('id' => $id_estructura));
            register_log('Maestro',"Se modificó la estructura \"$nombre_estructura\" bajo el ID => $id_estructura",1);          
            $str    = dialog('Información','¡Estructura Modificada Satisfactoriamente!',2);                     
        }       
        elseif ($esta and $id_estructura == '') {
            register_log('Maestro',"Se intentó agregar una estructura con el nombre \"$nombre_estructura\" al parecer ya existe",1);
            $str    = dialog('Información',"¡Error, La estructura \"$nombre_estructura\" ya existe con el mismo nombre y en la misma ubicación!",1); 
        }
        echo $str;
    }	
}
