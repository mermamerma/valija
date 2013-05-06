<?php

/**
 * 
 * 
 * @author
 * @version 
 */	

class Valija_model extends Model {

	function __construct() {
		parent::Model();
	}
	
	/*********************** Valija Despacho **************************/
	
	function aperturar(){
		$valija_data = array(
		'id_mision' 			 => $this->input->post('id_mision'),
		'indice_valija' 		 => $this->input->post('indice_valija'),
		'id_tipo_valija' 		 => $this->input->post('id_tipo_valija'),
		'id_estatus_valija'		 => $this->input->post('id_estatus_valija'),
		'fecha_anuncio'			 => datePg($this->input->post('fecha_anuncio')),
		'fecha_recibido'		 => datePg($this->input->post('fecha_recibido')),
		'presilla'				 => $this->input->post('presilla'),
		'peso'					 => str_replace(",", ".", $this->input->post('peso')),
		'num_candado' 			 => $this->input->post('num_candado'),
		'id_courrier'			 => $this->input->post('id_courrier'),
		'num_guia'				 => $this->input->post('num_guia'),
		'id_tipo_contenido'		 => $this->input->post('id_tipo_contenido'),
		'num_cajas'	 			 => $this->input->post('num_cajas'),
		'num_sacos'				 => $this->input->post('num_sacos'),
		'num_piezas' 			 => $this->input->post('num_piezas'),
		'observaciones'			 => $this->input->post('observaciones'),
		'id_ubicacion'			 => $this->session->userdata('id_coordinacion'),
		'id_usuario' 			 => $this->session->userdata('id'),
		'fecha_creacion' 		 => now_mysql_datetime(),
		'fecha_actualizacion'	 => now_mysql_datetime()
		);
		$insert = $this->db->insert('valijas', $valija_data);
		return $insert;
	}
	
	function get_valija_aperturada() {
		$id = $this->uri->segment(3);		
		$valija = $this->db->query(	"
			SELECT
			v.id, v.presilla, v.indice_valija, v.id_mision, v.num_candado, v.id_estatus_valija, v.id_usuario,
			v.id_courrier, v.num_guia, v.peso, v.id_tipo_valija, v.id_tipo_contenido, v.num_cajas, v.num_sacos,
			CONCAT(tipo_mision.nombre,' EN ',ciudades.nombre_ciudad,', ',paises.nombre_pais) AS mision,
			v.num_piezas, v.observaciones, v.id_ubicacion, v.fecha_anuncio, v.fecha_recibido, v.id_coordinacion,
			v.fecha_creacion, date_format(v.fecha_creacion,'%d-%m-%Y %r') as creacion, date_format(v.fecha_creacion,'%a, %d %b %Y %T') as easydate_c, 
			v.fecha_actualizacion, date_format(v.fecha_actualizacion,'%d-%m-%Y %r') as actualizacion, date_format(v.fecha_actualizacion,'%a, %d %b %Y %T') as easydate_a,
			usuarios.usuario
			FROM valijas v
			Left Join misiones ON misiones.id_mision = v.id_mision
			Left Join ciudades ON ciudades.id_ciudad = misiones.id_ciudad
			Left Join tipo_mision ON tipo_mision.id = misiones.id_tipo_mision
			Left Join usuarios ON usuarios.id = v.id_usuario
			Left Join paises ON ciudades.id_pais = paises.id_pais					
			WHERE v.id = $id 
			ORDER BY v.id DESC
			LIMIT 1		");		
		return $valija->row();
	}
	
	function editar_apertura() {
		$valija_data = array(
		'id_mision' 			 => $this->input->post('id_mision'),
		'indice_valija' 		 => $this->input->post('indice_valija'),
		'id_tipo_valija' 		 => $this->input->post('id_tipo_valija'),
		'id_estatus_valija'		 => $this->input->post('id_estatus_valija'),
		'fecha_anuncio'			 => datePg($this->input->post('fecha_anuncio')),
		'fecha_recibido'		 => datePg($this->input->post('fecha_recibido')),
		'presilla'				 => $this->input->post('presilla'),
		'peso'					 => str_replace(",", ".", $this->input->post('peso')),
		'num_candado' 			 => $this->input->post('num_candado'),
		'id_courrier'			 => $this->input->post('id_courrier'),
		'num_guia'				 => $this->input->post('num_guia'),
		'id_tipo_contenido'		 => $this->input->post('id_tipo_contenido'),
		'num_cajas'	 			 => $this->input->post('num_cajas'),
		'num_sacos'				 => $this->input->post('num_sacos'),
		'num_piezas' 			 => $this->input->post('num_piezas'),
		'observaciones'			 => $this->input->post('observaciones'),		
		'fecha_actualizacion'	 => now_mysql_datetime()
		);
		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('valijas', $valija_data);
		return $update; 	
	}
	
	function eliminar_apertura() {
		$id 	= $this->uri->segment(3);
		$this->db->delete('valijas', array('id' => $id));		
		return $this->db->affected_rows();
	}
	
	function listar_aperturadas(){
		$query = $this->db->query("
			SELECT
			valijas.id,
			valijas.presilla,
			valijas.indice_valija,
			valijas.num_guia,
			valijas.peso,
			valijas.num_candado,
			if (valijas.fecha_anuncio = '0000-00-00','-',DATE_FORMAT(valijas.fecha_anuncio,'%d-%m-%Y')) AS fecha_anuncio,
			if (valijas.fecha_recibido = '0000-00-00','-',DATE_FORMAT(valijas.fecha_recibido,'%d-%m-%Y')) AS fecha_recibido,
			valijas.fecha_creacion,
			valijas.fecha_actualizacion,
			tipo_valija.nombre AS tipo,
			estatus_valija.nombre AS estatus,
			courriers.nombre AS courrier,
			usuarios.usuario AS usuario,
			tipo_mision.nombre AS nombre_mision,
			ciudades.nombre_ciudad,
			paises.nombre_pais
			FROM
			valijas
			Left Join tipo_valija ON valijas.id_tipo_valija = tipo_valija.id
			Left Join estatus_valija ON valijas.id_estatus_valija = estatus_valija.id
			Left Join courriers ON valijas.id_courrier = courriers.id
			Left Join misiones ON valijas.id_mision = misiones.id_mision
			Left Join usuarios ON valijas.id_usuario = usuarios.id
			Inner Join tipo_mision ON misiones.id_tipo_mision = tipo_mision.id
			Inner Join ciudades ON misiones.id_ciudad = ciudades.id_ciudad
			Inner Join paises ON paises.id_pais = ciudades.id_pais
			ORDER BY valijas.id DESC	
		");
		$data = $query->result_array();
		return $data ; 
	}

	/*********************** Valija Ingreo **************************/
	
	function registrar_en_taquilla() {
		$numero_nota = ($this->input->post('numero_nota')==0) ? '': $this->input->post('numero_nota');		  
		$numero_guia = ($this->input->post('numero_guia')==0) ? '': $this->input->post('numero_guia');	
		$valija_data = array(
		'id_mision' 			 => $this->input->post('id_mision'),
		'id_tipo_valija' 		 => $this->input->post('id_tipo_valija'),
		'id_courrier' 			 => $this->input->post('id_courrier'),
		'numero_guia'			 => $this->input->post('numero_guia'),
		'id_tipo_registro'		 => $this->input->post('id_tipo_registro'),
		'numero_nota' 			 => $this->input->post('numero_nota'),
		'id_tipo_correspondencia'=> $this->input->post('id_tipo_correspondencia'),
		'numero_ingreso'		 => $this->input->post('numero_ingreso'),
		'indice_valija'			 => $this->input->post('indice_valija'),
		'fecha'		 			 => datePg($this->input->post('fecha')),
		'id_tipo_asunto'		 => $this->input->post('id_tipo_asunto'),
		'asunto'	 			 => $this->input->post('asunto'),
		'otros'			 		 => $this->input->post('otros'),
		'id_destinatario'		 => $this->input->post('id_destinatario'),
		'fecha_ingreso'			 => datePg($this->input->post('fecha_ingreso')),
		'anexos'	 			 => $this->input->post('anexos'),
		'observaciones'			 => $this->input->post('observaciones'),
		'indice_diario'			 => $this->input->post('indice_diario'),		
		'entregado_por'			 => $this->input->post('entregado_por'),
		'id_estatus_taquilla'	 => $this->input->post('id_estatus_taquilla'),
		'id_usuario' 			 => $this->session->userdata('id'),
		'fecha_creacion' 		 => now_mysql_datetime(),
		'fecha_actualizacion'	 => now_mysql_datetime()
		);
		$insert = $this->db->insert('valija_registro_taquilla', $valija_data);
		return $insert;
	}
	
	function editar_en_taquilla() {
		$numero_nota = ($this->input->post('numero_nota')==0) ? '': $this->input->post('numero_nota');		  
		$numero_guia = ($this->input->post('numero_guia')==0) ? '': $this->input->post('numero_guia');	
		$valija_data = array(
		'id_mision' 			 => $this->input->post('id_mision'),
		'id_tipo_valija' 		 => $this->input->post('id_tipo_valija'),
		'id_courrier' 			 => $this->input->post('id_courrier'),
		'numero_guia'			 => $this->input->post('numero_guia'),
		'id_tipo_registro'		 => $this->input->post('id_tipo_registro'),
		'numero_nota' 			 => $this->input->post('numero_nota'),
		'id_tipo_correspondencia'=> $this->input->post('id_tipo_correspondencia'),
		'numero_ingreso'		 => $this->input->post('numero_ingreso'),
		'indice_valija'			 => $this->input->post('indice_valija'),
		'fecha'		 			 => datePg($this->input->post('fecha')),
		'id_tipo_asunto'		 => $this->input->post('id_tipo_asunto'),
		'asunto'	 			 => $this->input->post('asunto'),
		'otros'			 		 => $this->input->post('otros'),
		'id_destinatario'		 => $this->input->post('id_destinatario'),
		'fecha_ingreso'			 => datePg($this->input->post('fecha_ingreso')),
		'anexos'	 			 => $this->input->post('anexos'),
		'observaciones'			 => $this->input->post('observaciones'),
		'indice_diario'			 => $this->input->post('indice_diario'),		
		'entregado_por'			 => $this->input->post('entregado_por'),
		'id_estatus_taquilla'	 => $this->input->post('id_estatus_taquilla'),	
		'fecha_actualizacion'	 => now_mysql_datetime()
		);
		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('valija_registro_taquilla', $valija_data);
		return $update; 
	}
		
	function mostrar_en_taquilla() {
		$id = $this->uri->segment(3);
		$valija = $this->db->query(	"
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
		return $valija->row();

	}
    
	function get_registro_en_taquilla() {
		$id = $this->uri->segment(3);		
		$valija = $this->db->query(	"
		SELECT v.id, v.id_mision, v.id_tipo_valija, v.id_courrier, v.id_tipo_registro, v.id_tipo_correspondencia, v.id_tipo_asunto, v.id_destinatario,
		v.id_estatus_taquilla,
		v.id_usuario,
		CONCAT(tipo_mision.nombre,' EN ',ciudades.nombre_ciudad,', ',paises.nombre_pais) as mision,
		v.indice_valija, v.numero_ingreso, v.fecha, v.asunto, v.otros, v.fecha_ingreso, v.observaciones,
		v.anexos, v.indice_diario,
		v.entregado_por, 
		v.fecha_creacion, date_format(v.fecha_creacion,'%d-%m-%Y %r') as creacion, date_format(v.fecha_creacion,'%a, %d %b %Y %T') as easydate_c,
		v.fecha_actualizacion, date_format(v.fecha_actualizacion,'%d-%m-%Y %r') as actualizacion, date_format(v.fecha_actualizacion,'%a, %d %b %Y %T') as easydate_a,  
		v.numero_guia, v.numero_nota,
		estructura.nombre AS destinatario,
		usuarios.usuario
		FROM
		valija_registro_taquilla AS v
		Inner Join misiones ON v.id_mision = misiones.id_mision
		Inner Join tipo_mision ON misiones.id_tipo_mision = tipo_mision.id
		Inner Join estructura ON v.id_destinatario = estructura.id
		Inner Join usuarios ON usuarios.id = v.id_usuario
		Inner Join ciudades ON ciudades.id_ciudad = misiones.id_ciudad
		Inner Join paises ON paises.id_pais = ciudades.id_pais	
		Where v.id = $id ");		
		return $valija->row();
	} 
	
	function listar_en_taquilla () {
    	$query = $this->db->query("
 			SELECT  v.id as id,			
			v.numero_guia as 'guia',
			v.numero_ingreso as 'ingreso',
			estructura.nombre as 'destinatario',									
			estatus_taquilla.nombre as 'estatus',
			date_format(v.fecha_creacion,'%d-%m-%Y %h:%i %p') as 'creado',
			tipo_mision.nombre AS nombre_mision,
			ciudades.nombre_ciudad,
			paises.nombre_pais, usuarios.usuario
			FROM valija_registro_taquilla v
			LEFT Join misiones ON v.id_mision = misiones.id_mision
			LEFT Join courriers   ON v.id_courrier = courriers.id
			LEFT Join tipo_valija ON v.id_tipo_valija = tipo_valija.id
			LEFT Join tipo_registro ON v.id_tipo_registro = tipo_registro.id
			LEFT Join tipo_correspondencia ON v.id_tipo_correspondencia = tipo_correspondencia.id
			LEFT Join tipo_asunto ON v.id_tipo_asunto = tipo_asunto.id
			LEFT Join estructura ON v.id_destinatario = estructura.id
			LEFT Join estatus_taquilla ON v.id_estatus_taquilla = estatus_taquilla.id
			Inner Join tipo_mision ON misiones.id_tipo_mision = tipo_mision.id
			Inner Join ciudades ON misiones.id_ciudad = ciudades.id_ciudad
			Inner Join paises ON paises.id_pais = ciudades.id_pais	
			Inner Join usuarios ON v.id_usuario = usuarios.id 		
			ORDER BY v.id DESC ");
		$data = $query->result_array();
		return $data ; 
	}

	function eliminar_en_taquilla() {
		$id 	= $this->uri->segment(3);
		$this->db->delete('valija_registro_taquilla', array('id' => $id));		
		return $this->db->affected_rows();
	}

	function buscar_ingreso () {
		$query = $this->db->query("
 			SELECT  v.id as id,			
			v.numero_guia as 'guia',
			v.numero_ingreso as 'ingreso',
			estructura.nombre as 'destinatario',									
			estatus_taquilla.nombre as 'estatus',
			date_format(v.fecha_creacion,'%d-%m-%Y %h:%i %p') as 'creado',
			tipo_mision.nombre AS nombre_mision,
			ciudades.nombre_ciudad,
			paises.nombre_pais
			FROM valija_registro_taquilla v
			LEFT Join misiones ON v.id_mision = misiones.id_mision
			LEFT Join courriers   ON v.id_courrier = courriers.id
			LEFT Join tipo_valija ON v.id_tipo_valija = tipo_valija.id
			LEFT Join tipo_registro ON v.id_tipo_registro = tipo_registro.id
			LEFT Join tipo_correspondencia ON v.id_tipo_correspondencia = tipo_correspondencia.id
			LEFT Join tipo_asunto ON v.id_tipo_asunto = tipo_asunto.id
			LEFT Join estructura ON v.id_destinatario = estructura.id
			LEFT Join estatus_taquilla ON v.id_estatus_taquilla = estatus_taquilla.id
			Inner Join tipo_mision ON misiones.id_tipo_mision = tipo_mision.id
			Inner Join ciudades ON misiones.id_ciudad = ciudades.id_ciudad
			Inner Join paises ON paises.id_pais = ciudades.id_pais
			WHERE
			1 = 1			
			ORDER BY v.id DESC ");
		$data = $query->result_array();
		if ($query->num_rows() <= 0) 
			return false; 
		else 	
			return $data ; 
	}
}
