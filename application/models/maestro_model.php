<?php

/**
 * 
 * 
 * @author Jesús Rodríguez
 * @version 
 */	

class Maestro_model extends Model {

	function __construct() {
		parent::Model();
		######
	}
    
	function get_detalle ($tabla) {
		switch ($tabla) {
			case 'paises':
				$nombre_campo = 'nombre_pais';
				$this->db->select("id_pais as 'id', nombre_pais as 'nombre'");
				break;
			default:
				$nombre_campo = 'nombre';
		}			
		$this->db->order_by($nombre_campo, "ASC");
		$query = $this->db->get($tabla);
		$data = $query->result_array();
		return $data ; 		
	}
    		
	function agregar(){
		$id_tabla		= $this->input->post('id_tabla') ;
		$nombre		 	= strtoupper(trim($this->input->post('nombre'))) ;
		$nombre_tabla	= $this->maestro[$id_tabla]['nombre_tabla'];
		$id 			= $this->input->post('id_row') ; 				
		$row 			= array('nombre' => $nombre);		
		$insert = $this->db->insert($nombre_tabla, $row);		
		#return $this->db->affected_rows();
		return $this->db->insert_id();
	}
	
	function duplicado() {
		$id_tabla		= $this->input->post('id_tabla') ;
		$nombre		 	= strtoupper(trim($this->input->post('nombre'))) ;
		$nombre_tabla	= $this->maestro[$id_tabla]['nombre_tabla'];		
		$query = $this->db->get_where($nombre_tabla, array('nombre' => $nombre));
		#die('Valor: '.$query->num_rows);
		if ($query->num_rows() >= 1) {
			return true; 
		}
		return false;
	}
	
	function modificar(){
		$id				= $this->input->post('id_row') ;
		$id_tabla		= $this->input->post('id_tabla') ;
		$nombre		 	= strtoupper(trim($this->input->post('nombre'))) ;
		$nombre_tabla	= $this->maestro[$id_tabla]['nombre_tabla'];				
		$row 			= array('nombre' => $nombre);
						
		$query = $this->db->get_where($nombre_tabla, array('id' => $id), 1);

		if ($query->num_rows() > 1) {
			return false; 
		}
		else {
			$this->db->where('id', $id);		
			$update = $this->db->update($nombre_tabla, $row);		
			return $this->db->affected_rows();
		}		
	}

	function get_mision ($id_mision) {
		$this->db->select("misiones.id_mision AS id_mision,
							tipo_mision.id as id_tipo_mision,
							ciudades.id_ciudad as id_ciudad,
							paises.id_pais as id_pais,
							tipo_mision.nombre as tipo_mision,
							ciudades.nombre_ciudad as ciudad,
							paises.nombre_pais as pais,
							misiones.nro_expediente");  		
		$this->db->join('ciudades', 	'ciudades.id_pais = paises.id_pais', 'inner');
  		$this->db->join('misiones',		'misiones.id_ciudad = ciudades.id_ciudad', 'inner');
  		$this->db->join('tipo_mision', 	'tipo_mision.id = misiones.id_tipo_mision', 'inner'); 
  		$query = $this->db->get_where('paises',array('id_mision' => $id_mision), 1); 		
		$data = $query->row();
		return $data ; 
	}

	function get_misiones () {
		$this->db->select('misiones.id_mision, tipo_mision.nombre as nombre_mision, ciudades.nombre_ciudad, paises.nombre_pais'); 
		$this->db->from('paises');
  		$this->db->join('ciudades', 	'ciudades.id_pais = paises.id_pais', 'inner');
  		$this->db->join('misiones',		'misiones.id_ciudad = ciudades.id_ciudad', 'inner');
  		$this->db->join('tipo_mision', 	'tipo_mision.id = misiones.id_tipo_mision', 'inner');  		
  		$query = $this->db->get(); 		
		$data = $query->result_object();
		return $data ; 
	}

	function mision_duplicada() {
		$id_tipo_mision	= $this->input->post('id_tipo_mision') ;
		$id_ciudad		= $this->input->post('id_ciudad') ;
		$query = $this->db->get_where('misiones', array('id_tipo_mision' => $id_tipo_mision,'id_ciudad' => $id_ciudad));
		if ($query->num_rows() >= 1) {
			return true; 
		}
		return false;
	}

	function agregar_mision(){		
        $id_ciudad      = $this->input->post('id_ciudad') ;
        $id_tipo_mision = $this->input->post('id_tipo_mision') ;
        $nro_expediente = $this->input->post('nro_expediente') ;        
		$row 			= array('id_tipo_mision' => $id_tipo_mision, 'id_ciudad' => $id_ciudad, 'nro_expediente' => $nro_expediente);		
		$insert = $this->db->insert('misiones', $row);		
		return $this->db->insert_id();
	}

	function modificar_mision(){
		$id_mision      = $this->input->post('id_mision') ;
		$id_ciudad      = $this->input->post('id_ciudad') ;
        $id_tipo_mision = $this->input->post('id_tipo_mision') ;
        $nro_expediente = $this->input->post('nro_expediente') ; 	
		$row 			= array('id_tipo_mision' => $id_tipo_mision, 'id_ciudad' => $id_ciudad, 'nro_expediente' => $nro_expediente);		
		$this->db->where(array('id_mision' => $id_mision));		
		$update = $this->db->update('misiones', $row);		
		return $this->db->affected_rows();	
	}

	function get_ciudades () {
		$this->db->select('ciudades.id_ciudad, ciudades.id_pais, ciudades.nombre_ciudad, paises.nombre_pais'); 
		$this->db->from('ciudades');
  		$this->db->join('paises', 'ciudades.id_pais = paises.id_pais', 'left');
  		$this->db->order_by('paises.nombre_pais', 'ASC');
  		$query = $this->db->get(); 
		//$query = $this->db->get_where('log', array('log.id_usuario' => $id), $num, $offset);
		$data = $query->result_object();
		return $data ; 
	}
	
	function get_ciudad ($id_ciudad) {
		$this->db->select('ciudades.id_ciudad, ciudades.id_pais, ciudades.nombre_ciudad, paises.nombre_pais'); 
		//$this->db->from('ciudades');
  		$this->db->join('paises', 'ciudades.id_pais = paises.id_pais', 'left');
  		$this->db->order_by('paises.nombre_pais', 'ASC');
  		$query = $this->db->get_where('ciudades',array('id_ciudad' => $id_ciudad), 1); 
		//$query = $this->db->get_where('log', array('log.id_usuario' => $id), $num, $offset);
		$data = $query->row();
		return $data ; 
	}
	
	function modificar_ciudad(){
		$id_ciudad		= $this->input->post('id_ciudad') ;
		$id_pais		= $this->input->post('id_pais') ;
		$nombre_ciudad	= strtoupper(trim($this->input->post('nombre_ciudad'))) ;		
		$row 			= array('nombre_ciudad' => $nombre_ciudad, 'id_pais' => $id_pais);						
		$this->db->where(array('id_ciudad' => $id_ciudad));		
		$update = $this->db->update('ciudades', $row);		
		return $this->db->affected_rows();	
	}

	function agregar_ciudad(){
		$nombre_ciudad		 	= strtoupper(trim($this->input->post('nombre_ciudad'))) ;
		$id_pais 		= $this->input->post('id_pais') ; 				
		$row 			= array('id_pais' => $id_pais, 'nombre_ciudad' => $nombre_ciudad);		
		$insert = $this->db->insert('ciudades', $row);		
		return $this->db->insert_id();
	}
	
	function ciudad_duplicada() {		
		$nombre_ciudad	= strtoupper(trim($this->input->post('nombre_ciudad'))) ;
		$id_pais 		= $this->input->post('id_pais');
		if ($id_pais != '') 
			$query = $this->db->get_where('ciudades', array('nombre_ciudad' => $nombre_ciudad, 'id_pais' => $id_pais));			
		else
			$query = $this->db->get_where('ciudades', array('nombre_ciudad' => $nombre_ciudad));					
		
		if ($query->num_rows() >= 1) {
			return true; 
		}
		return false;
	}

	function get_estructuras () {
		$this->db->select('estructura.id as id_estructura,estructura.id_ubicacion as id_ubicacion,estructura.nombre as estructura,ubicaciones.nombre as ubicacion'); 
		$this->db->from('estructura');
  		$this->db->join('ubicaciones', 	'ubicaciones.id = estructura.id_ubicacion', 'inner');
  		$query = $this->db->get(); 		
		$data = $query->result_object();
		return $data ; 
	}

	function agregar_estructura(){
		$nombre_estructura 	= strtoupper(trim($this->input->post('nombre_estructura'))) ;
		$id_ubicacion 		= $this->input->post('id_ubicacion') ; 				
		$row 				= array('id_ubicacion' => $id_ubicacion, 'nombre' => $nombre_estructura);		
		$insert = $this->db->insert('estructura', $row);		
		return $this->db->insert_id();
	}

	function estructura_duplicada() {		
		$nombre_estructura	= strtoupper(trim($this->input->post('nombre_estructura'))) ;
		$id_ubicacion 		= $this->input->post('id_ubicacion');		
		$query = $this->db->get_where('estructura', array('nombre' => $nombre_estructura, 'id_ubicacion' => $id_ubicacion));
		#die($this->db->last_query());			
		if ($query->num_rows() >= 1) {
			return true; 
		}
		return false;
	}

	function get_registro($tabla, $criterio){		 		
  		$query = $this->db->get_where($tabla, $criterio, 1); 		
		$data = $query->row();
		return $data ; 		
	}

	function update_record($tabla, $campos, $criterio){
		$row 			= $campos;		
		$this->db->where($criterio);		
		$update = $this->db->update($tabla, $row);		
		return $this->db->affected_rows();	
	}	
}
