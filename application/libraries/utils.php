<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utils {
	var $CI;
	
	function __construct(){
		$this->CI =& get_instance();
	}
	
	function array_select(){
		$this->CI =& get_instance();
    	$query = $this->db->get(self::TABLA_REGISTROS);
    	$data = array();
    	$data[]='Seleccion un elemento'; //aqui agregamos una opcion sin valor a nuestro select, la cual sera la seleccion por defecto
    	if($query->num_rows()>0){
    	    foreach($query->result_array() as $row){
        	    $data[$row['id_mision']]= $row['nombre'];
        	}
        	return $data;
    	}
    	return false;
	}
	
	function pepe(){ 	
    	return 'Soy Pepe';
	}
	
	/**
	 * "Cuenta Todos los resgistros de una tabla que cumplan una condicion" query
	 *
	 * Generates a platform-specific query string that counts all records in
	 * the specified database
	 *
	 * @access	public
	 * @param	String $table 
	 * @param	String $fields campos condiciondaos
	 * @return	Integer
	 */
	function count_all_condition($table = '', $fields = '')
	{
		
		if ($table == '')
		{
			return 0;
		}
		$sql = "SELECT COUNT(*) as 'numrows' FROM $table WHERE $fields " ;
		//die($sql);
		$query = $this->CI->db->query($sql);
		
		#if ($query->num_rows() == 0)
		if ( $query->num_rows() == 0)
		{
			return 0;
		}

		$row = $query->row();
		return (int) $row->numrows;
	}
	
}

