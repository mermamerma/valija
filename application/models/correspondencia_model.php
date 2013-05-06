<?php

/**
 * 
 * 
 * @author
 * @version 
 */	

class Correspondencia_model extends Model {

	function __construct() {
		parent::Model();
	}
		
	function registrar() {
		$correspondencia_data = array(
		'indice_interno'		 => $this->input->post('indice_interno'),
		'fecha_ingreso'			 => datePg($this->input->post('fecha_ingreso')),
		'id_mision'		 		 => $this->input->post('id_mision'),
		'asunto'		 		 => $this->input->post('asunto'),
		'numero_ingreso' 		 => $this->input->post('numero_ingreso'),		
		'id_destinatario' 		 => $this->input->post('id_destinatario'),
		'indice_remitente' 		 => $this->input->post('indice_remitente'),
		'fecha_correspondencia'	 => datePg($this->input->post('fecha_correspondencia')),
		'id_tipo_documento'		 => $this->input->post('id_tipo_documento'),
		'numero_documento' 		 => $this->input->post('numero_documento'),
		'entrada'				 => $this->input->post('entrada'),
		'anexo'					 => $this->input->post('anexo'),
		'observaciones' 		 => $this->input->post('observaciones'),				
		'id_usuario' 			 => $this->session->userdata('id'),
		'fecha_creacion' 		 => now_mysql_datetime(),
		'fecha_actualizacion'	 => now_mysql_datetime()
		);
		$insert = $this->db->insert('correspondencias', $correspondencia_data);
		return $insert;
	}
	
 	function get_correspondencias($num, $offset){
 		
  	$this->db->select("correspondencias.id,
				CONCAT(tipo_mision.nombre, ' EN', ciudades.nombre_ciudad, ', ', paises.nombre_pais) AS mision,
				correspondencias.asunto,
				estructura.nombre as 'destinatario',
				correspondencias.indice_interno,
				date_format(correspondencias.fecha_ingreso, '%d-%m-%Y') AS fecha_ingreso,
				correspondencias.indice_remitente,
				IF (correspondencias.fecha_correspondencia = '0000-00-00', 'Sin Fecha', date_format(correspondencias.fecha_correspondencia, '%d-%m-%Y')) AS fecha_correspondencia,
				tipo_documento.nombre AS tipo_documento,
				correspondencias.numero_documento,
				IF(correspondencias.anexo   = 'S','Si','No') as anexo, 
				IF(correspondencias.entrada = 'T','Taquilla','Valija') as entrada,
				date_format(correspondencias.fecha_creacion, '%d-%m-%Y %H:%i %p') AS fecha_creacion,
				usuarios.usuario ", FALSE);  	
  	$this->db->join('usuarios', 'correspondencias.id_usuario = usuarios.id', 'inner');
  	$this->db->join('misiones', 'correspondencias.id_mision = misiones.id_mision', 'inner');  	
  	$this->db->join('tipo_mision', 'misiones.id_tipo_mision = tipo_mision.id', 'inner');
  	$this->db->join('ciudades', 'misiones.id_ciudad = ciudades.id_ciudad', 'inner');
  	$this->db->join('paises', 'ciudades.id_pais = paises.id_pais', 'inner');  	
  	$this->db->join('tipo_documento', 'correspondencias.id_tipo_documento = tipo_documento.id', 'inner');
  	$this->db->join('estructura', 'correspondencias.id_destinatario = estructura.id', 'inner');  	
  	$this->db->order_by("correspondencias.id", "DESC"); 
	$query = $this->db->get_where('correspondencias', array('correspondencias.estatus' => 1), $num, $offset);
	#die($this->db->last_query());	
	#$data = $query->result_array();
	$data = $query->result_object();
	$num_rows = $query->num_rows();
	if ($num_rows > 0 )
		return $data ;
	else 
		return 0;			
  }
	
	function get_correspondencia($id){
 		
  	$this->db->select("c.id,
  				c.indice_interno,date_format(c.fecha_ingreso, '%d-%m-%Y') AS fecha_ingreso,
				c.id_mision, CONCAT(tipo_mision.nombre, ' EN', ciudades.nombre_ciudad, ', ', paises.nombre_pais) AS mision,
				c.asunto,
				c.numero_ingreso,
				c.id_destinatario,
				estructura.nombre as 'destinatario',				
				c.indice_remitente,
				IF (c.fecha_correspondencia = '0000-00-00', 'Sin Fecha', date_format(c.fecha_correspondencia, '%d-%m-%Y')) AS fecha_correspondencia,
				c.id_tipo_documento,
				c.numero_documento,
				c.anexo, 
				c.entrada,
				c.observaciones,
				c.fecha_creacion, date_format(c.fecha_creacion,'%d-%m-%Y %r') as creacion, date_format(c.fecha_creacion,'%a, %d %b %Y %T') as easydate_c, 
				c.fecha_actualizacion, date_format(c.fecha_actualizacion,'%d-%m-%Y %r') as actualizacion, date_format(c.fecha_actualizacion,'%a, %d %b %Y %T') as easydate_a,
				usuarios.usuario ", FALSE);  	
  	$this->db->join('usuarios', 'c.id_usuario = usuarios.id', 'inner');
  	$this->db->join('misiones', 'c.id_mision = misiones.id_mision', 'inner');  	
  	$this->db->join('tipo_mision', 'misiones.id_tipo_mision = tipo_mision.id', 'inner');
  	$this->db->join('ciudades', 'misiones.id_ciudad = ciudades.id_ciudad', 'inner');
  	$this->db->join('paises', 'ciudades.id_pais = paises.id_pais', 'inner');  	
  	$this->db->join('estructura', 'c.id_destinatario = estructura.id', 'inner');  	
  	$this->db->order_by("c.id", "ASC"); 
	$query = $this->db->get_where('correspondencias c', array('c.estatus' => 1,'c.id' => $id),1);
	#die($this->db->last_query());	
	#$data = $query->result_array();
	$num_rows = $query->num_rows();
	if ($num_rows > 0 )
		return $query->row() ;		
	else 
		return 0;			
  }
  
	function buscar_ingreso(){
 		
  	$this->db->select("c.id,
				CONCAT(tipo_mision.nombre, ' EN ', ciudades.nombre_ciudad, ', ', paises.nombre_pais) AS mision,
				c.asunto,
				c.numero_ingreso,
				estructura.nombre as 'destinatario',
				c.indice_interno,
				date_format(c.fecha_ingreso, '%d-%m-%Y') AS fecha_ingreso,
				c.indice_remitente,
				IF (c.fecha_correspondencia = '0000-00-00', 'Sin Fecha', date_format(c.fecha_correspondencia, '%d-%m-%Y')) AS fecha_correspondencia,
				tipo_documento.nombre AS tipo_documento,
				c.numero_documento,
				IF(c.anexo   = 'S','Si','No') as anexo, 
				IF(c.observaciones IS NULL,'&nbsp;',c.observaciones) as observaciones,				
				IF(c.entrada = 'T','Taquilla','Valija') as entrada,
				date_format(c.fecha_creacion, '%d-%m-%Y %H:%i %p') AS fecha_creacion,
				usuarios.usuario ", FALSE);  
  	$this->db->join('usuarios', 'c.id_usuario = usuarios.id', 'inner');
  	$this->db->join('misiones', 'c.id_mision = misiones.id_mision', 'inner');  	
  	$this->db->join('tipo_mision', 'misiones.id_tipo_mision = tipo_mision.id', 'inner');
  	$this->db->join('ciudades', 'misiones.id_ciudad = ciudades.id_ciudad', 'inner');
  	$this->db->join('paises', 'ciudades.id_pais = paises.id_pais', 'inner');  
  	$this->db->join('tipo_documento', 'c.id_tipo_documento = tipo_documento.id', 'inner');	
  	$this->db->join('estructura', 'c.id_destinatario = estructura.id', 'inner');  	
  	$this->db->order_by("c.id", "ASC"); 
  	
  	#### Armar condicionales en la sentencia SQL si los campos fueron rellenados
  	($this->input->post('indice_interno')) 		? $this->db->where('c.indice_interno', $this->input->post('indice_interno')) : null; 
  	($this->input->post('fecha_ingreso')) 		? $this->db->where('c.fecha_ingreso', datePg($this->input->post('fecha_ingreso'))) : null;
  	($this->input->post('id_destinatario'))		? $this->db->where('c.id_destinatario', $this->input->post('id_destinatario')) : null;  	
  	($this->input->post('id_mision')) 			? $this->db->where('c.id_mision', $this->input->post('id_mision')) : null;
  	($this->input->post('asunto')) 				? $this->db->like('c.asunto', $this->input->post('asunto')) : null;
  	($this->input->post('numero_documento'))	? $this->db->where('c.numero_documento', $this->input->post('numero_documento')) : null;  	
  	($this->input->post('id_usuario')) 			? $this->db->where('c.id_usuario', $this->input->post('id_usuario')) : null;
  	
  	$this->db->where('c.estatus',1); ### Recuperar sólo los registros la que no hayan sido eliminadas de namera lógica
  	$this->db->limit(35);
	$query = $this->db->get('correspondencias c');	
	#die($this->db->last_query());	
	$num_rows = $query->num_rows();
	if ($num_rows > 0 ) 
		return $query->result() ;			
	else 
		return 0;			
  }
  	
	function editar() {
		$correspondencia_data = array(
		'indice_interno'		 => $this->input->post('indice_interno'),
		'fecha_ingreso'			 => datePg($this->input->post('fecha_ingreso')),
		'id_mision' 			 => $this->input->post('id_mision'),
		'asunto'	 			 => $this->input->post('asunto'),
		'numero_ingreso'		 => $this->input->post('numero_ingreso'),
		'id_destinatario'		 => $this->input->post('id_destinatario'),
		'indice_remitente'		 => $this->input->post('indice_remitente'),
		'fecha_correspondencia'	 => datePg($this->input->post('fecha_correspondencia')),
		'id_tipo_documento'		 => $this->input->post('id_tipo_documento'),
		'numero_documento'		 => $this->input->post('numero_documento'),		
		'entrada'				 => $this->input->post('entrada'),
		'anexo'					 => $this->input->post('anexo'),
		'observaciones' 		 => $this->input->post('observaciones'),						
		'fecha_actualizacion'	 => now_mysql_datetime()
		);
		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('correspondencias', $correspondencia_data);
		return $update; 
	}
		
	function mostrar() {
		$id = $this->uri->segment(3);
		$rs = $this->db->query(	"
								SELECT *,  v.id as id_valija,
								misiones.nombre_mision,
								courriers.nombre as nombre_courrier,
								tipo_valija.nombre as nombre_tipo_valija,
								tipo_registro.nombre as nombre_tipo_registro,
								tipo_correspondencia.nombre as nombre_tipo_correspondencia,
								tipo_asunto.nombre as nombre_tipo_asunto,
								estructura.nombre as nombre_destino,
								estatus_taquilla.nombre as nombre_estatus_taquilla
								FROM valijas_aperturadas v
								LEFT Join misiones ON v.id_mision = misiones.id_mision
								LEFT Join courriers   ON v.id_courrier = courriers.id
								LEFT Join tipo_valija ON v.id_tipo_valija = tipo_valija.id
								LEFT Join tipo_registro ON v.id_tipo_registro = tipo_registro.id
								LEFT Join tipo_correspondencia ON v.id_tipo_correspondencia = tipo_correspondencia.id
								LEFT Join tipo_asunto ON v.id_tipo_asunto = tipo_asunto.id
								LEFT Join estructura ON v.id_destino = estructura.id_estructura
								LEFT Join estatus_taquilla ON v.id_estatus_taquilla = estatus_taquilla.id
								Where v.id = $id");
		return $rs->row();

	}
    	
	function get_registro() {
		$id = $this->uri->segment(3);		
		$rs = $this->db->query(	"
				SELECT
				c.id,
				estructura.nombre as remitente,
				c.id_remitente,
				c.numero,
				c.asunto,
				c.anexos,
				c.asignacion,
				c.observaciones,
				date_format(c.fecha_correspondencia,'%d-%m-%Y') AS f_correspondencia,
				date_format(c.fecha_ingreso,'%d-%m-%Y') AS f_ingreso,				
				c.fecha_creacion, date_format(c.fecha_creacion,'%d-%m-%Y %r') as creacion, date_format(c.fecha_creacion,'%a, %d %b %Y %T') as easydate_c, 
				c.fecha_actualizacion, date_format(c.fecha_actualizacion,'%d-%m-%Y %r') as actualizacion, date_format(c.fecha_actualizacion,'%a, %d %b %Y %T') as easydate_a,  
				estructura.nombre AS destinatario, 
				usuarios.usuario
				FROM
				correspondencias AS c
				Left Join estructura ON c.id_remitente = estructura.id
				LEFT Join usuarios ON c.id_usuario = usuarios.id
				WHERE c.id = $id ");		
		return $rs->row();
	} 
	
	function listar () {
    	$query = $this->db->query("
		SELECT c.id,
		estructura.nombre,
		c.numero,
		c.asunto,
		c.asignacion,
		date_format(c.fecha_correspondencia,'%d-%m-%Y') as f_correspondencia,
		date_format(c.fecha_ingreso,'%d-%m-%Y') as f_ingreso,
		date_format(c.fecha_creacion,'%d-%m-%Y %h:%i %p') as f_creacion
		FROM
		correspondencias c
		LEFT JOIN estructura ON c.id_remitente = estructura.id ");
		$data = $query->result_array();

		return $data ; 
	}	

	function eliminar($id) {		
		$this->db->where('id', $id,1);
		$update = $this->db->update('correspondencias', array('estatus' => 0));
		return $this->db->affected_rows();
	}
	
}
