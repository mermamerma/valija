<?php

/**
 * 
 * 
 * @author Jesus Rodriguez
 * @version 
 */	

class Mision_model extends Model {

	function __construct() {
		parent::Model();
	}

	function autocomplete() {
						
		$term = $_GET['term'];
    	$sql = "select 
				m.id_mision, m.nombre_mision, c.nombre_ciudad, p.nombre_pais, CONCAT(m.nombre_mision,' / ',p.nombre_pais) as label  
				FROM mision m
				INNER JOIN ciudades c 	ON c.id_ciudad = m.id_ciudad
				INNER JOIN paises   p 	ON p.id_pais = c.id_pais
				WHERE
				m.nombre_mision like '%$term%' 
				OR
				p.nombre_pais like '%$term%'";    	
    	
		$query = $this->db->query($sql);
    	
    	if ($query->num_rows() > 0 ) {
 		   	foreach ($query->result() as $row) {
    			$arreglo[]=array('id'=>utf8_encode($row->id_mision),
                                 'label'=>utf8_encode($row->label),
                                 'value'=>utf8_encode($row->label)
    							);
			}
			return json_encode($arreglo);		
    	}
    	return 0;	 
	}
    
	function get_all() {
		#$misiones = $this->db->query('SELECT * FROM misiones');
		$query = $this->db->get('misiones');
		$misiones = $query->result_array();
		return $misiones ; 
		
	}
}


