<?php

/**
 * 
 * 
 * @author
 * @version 
 */	

class Search extends Controller {

	function __construct() {
		parent::Controller();
	}
    
    function search_autocomplete (){
    	$term	= $_GET['term'];
    	$p1		= $_GET['p1'];
    	$sql	= '';
		switch ($p1) {
    		case 'misiones':
				$sql = " SELECT	misiones.id_mision as id,	CONCAT(tipo_mision.nombre,' EN ',ciudades.nombre_ciudad,', ',paises.nombre_pais) AS label
				FROM paises Inner Join ciudades ON ciudades.id_pais = paises.id_pais Inner Join misiones ON misiones.id_ciudad = ciudades.id_ciudad
				Inner Join tipo_mision ON tipo_mision.id = misiones.id_tipo_mision	WHERE tipo_mision.nombre LIKE '%$term%'
				OR	ciudades.nombre_ciudad LIKE '%$term%'	OR	paises.nombre_pais LIKE '%$term%' ";
				break;
    		case 'estructura':
    			$sql = "SELECT id, nombre as label FROM estructura WHERE nombre like '%$term%' ORDER BY nombre ASC	";
    			break;
    		case 'estructura_in':
    			$sql = "SELECT id, nombre as label FROM estructura WHERE nombre like '%$term%' AND id_ubicacion = 1	ORDER BY nombre ASC	";
				$sql = "SELECT id, nombre as label FROM estructura WHERE nombre like '%$term%' AND estatus = 'A'ORDER BY nombre ASC	";
    			break;
    		case 'estructura_out':
    			$sql = "SELECT id, nombre as label FROM estructura WHERE nombre like '%$term%' AND id_ubicacion = 2	ORDER BY nombre ASC	";
    			break;
    		case 'procedencia':
    			$sql = "SELECT id, nombre as label FROM estructura WHERE nombre like '%$term%' ORDER BY nombre ASC	";
    			break ;
    		case 'paises':
    			$sql = "SELECT id_pais as id, nombre_pais as label FROM paises WHERE nombre_pais like '%$term%' ORDER BY nombre_pais ASC";
    			break;
    		case 'ciudades':
    			$sql = "SELECT ciudades.id_ciudad as id, CONCAT(ciudades.nombre_ciudad,', ' ,paises.nombre_pais) as label  
				FROM ciudades Inner Join paises ON ciudades.id_pais = paises.id_pais
				WHERE ciudades.nombre_ciudad like '%$term%' OR paises.nombre_pais like '%$term%' order by nombre_pais";
    			break; 
			case 'usuarios':				
    			$sql = "SELECT usuarios.id as id, CONCAT(usuarios.nombres, ' ', usuarios.apellidos, ' -> ',usuarios.usuario) as label
				FROM usuarios WHERE 
				usuarios.nombres like '%$term%' OR
				usuarios.apellidos like '%$term%' OR
				usuarios.usuario LIKE '%$term%' order by usuarios.usuario ASC";
    			break;   			
		}  
	 			
		$query = $this->db->query($sql);   	
		if ($query->num_rows() > 0 ) {
			foreach ($query->result() as $row) {
				#$arreglo[]=array('id'=>utf8_encode($row->id), 'label'=>$row->label,   'value'=>utf8_encode($row->label)	);
				$arreglo[]=array('id'=>($row->id), 'label'=>$row->label,   'value'=>($row->label)	);
			}
			echo json_encode($arreglo);
		}
		
	}
}