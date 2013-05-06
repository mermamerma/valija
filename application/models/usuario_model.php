<?php

/**
 * 
 * 
 * @author Jesus Rodriguez
 * @version 
 */	

class Usuario_model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function validar_en_sistema(){
		$this->db->where('usuario',$this->input->post('usuario'));
		#$this->db->where('password', md5($this->input->post('password')));
		$this->db->limit(1);
		$query = $this->db->get('usuarios');
		
		if ($query->num_rows == 1) {
			return true;
		}
		else {
			return false;
		}
	}

	function validar_en_ldap($usuario, $password) {
		$res = $this->adldap->authenticate($usuario,$password);
		return $res ;
		#return true;		
	}
    
	function get_usuario($usuario) {
		$this->db->select("usuarios.id, usuarios.id_acceso, usuarios.usuario, usuarios.id_coordinacion, nombres, apellidos, 
							accesos.nombre as 'nombre_acceso', accesos.acceso");
		$this->db->join('accesos', 'accesos.id = usuarios.id_acceso', 'left');
		$usuario = $this->db->get_where('usuarios', array('usuario' => $usuario, 'id_estatus' => 1), 1);
		return $usuario->row();
		
	}

	function get_nombre_usuario($id) {
		$this->db->select("usuario");		
		$query = $this->db->get_where('usuarios', array('id' => $id), 1);
		$usuario = $query->row();
		if ($query->num_rows() == 1 )
			return $usuario->usuario;
		else 
			return "Usuario no definido bajo el ID => $id";
		
	}
	
	function get_usuario_by_id($id) {
		$this->db->select("id, id_estatus, id_acceso, id_coordinacion, usuario, nombres, apellidos"); 
							
		$usuario = $this->db->get_where('usuarios', array('id' => $id), 1);
		$num_rows = $usuario->num_rows();
		if ($num_rows > 0)
			return $usuario->row();
		else
			return false;
		
	}
	
	function listar_usaurios() {
		$query = $this->db->query("
		SELECT
		usuarios.id,
		usuarios.usuario,
		usuarios.nombres,
		usuarios.apellidos,
		uc.usuario as 'creador',
		coordinaciones.nombre as 'coordinacion',
		accesos.nombre as 'acceso',
		IF(usuarios.id_estatus = 1,'Activo','Inactivo') as 'estatus',
		IF(usuarios.id_estatus = 1,'good_bit.png','bad_bit.png') as 'img'
		FROM
		usuarios
		INNER Join coordinaciones ON usuarios.id_coordinacion = coordinaciones.id
		LEFT Join accesos 				ON usuarios.id_acceso = accesos.id
		INNER Join usuarios uc 		ON uc.id = usuarios.id_creador
		ORDER BY usuarios.usuario ASC
		");
		$data = $query->result_array();
		return $data ;		
	}

	function listar_usaurios_1() {
		$query = $this->db->query("
		SELECT
		usuarios.id,
		usuarios.usuario,
		usuarios.nombres,
		usuarios.apellidos,
		uc.usuario as 'creador',
		coordinaciones.nombre as 'coordinacion',
		accesos.nombre as 'acceso',
		IF(usuarios.id_estatus = 1,'Activo','Inactivo') as 'estatus',
		IF(usuarios.id_estatus = 1,'good_bit.png','bad_bit.png') as 'img'
		FROM
		usuarios
		INNER Join coordinaciones ON usuarios.id_coordinacion = coordinaciones.id
		LEFT Join accesos 				ON usuarios.id_acceso = accesos.id
		INNER Join usuarios uc 		ON uc.id = usuarios.id_creador
		ORDER BY usuarios.usuario ASC
		");
		$data = $query->result_object();
		return $data ;		
	}
	
	function agregar() {
		$row = array(
		'usuario'	 		=> strtolower(trim($this->input->post('usuario'))),
		'nombres'		 	=> ucfirst(trim($this->input->post('nombres'))),
		'apellidos'		 	=> ucfirst(trim($this->input->post('apellidos'))),
		'id_coordinacion'		=> $this->input->post('id_coordinacion'),
		'id_acceso'			=> $this->input->post('id_acceso'),
		'id_creador' 			=> $this->session->userdata('id'),
		'fecha_creacion' 		=> now_mysql_datetime(),
		'fecha_actualizacion'           => now_mysql_datetime()
		);	
		$insert = $this->db->insert('usuarios', $row);	
		return $this->db->insert_id();
	}
	
	function editar() {
		$usuario = array(
		'usuario'	 		=> $this->input->post('usuario'),
		'id_estatus'		=> $this->input->post('id_estatus'),
		'nombres' 			=> $this->input->post('nombres'),
		'apellidos' 		=> $this->input->post('apellidos'),	
		'id_coordinacion'	=> $this->input->post('id_coordinacion'),
		'id_acceso'			=> $this->input->post('id_acceso'),
		'fecha_actualizacion'	 => now_mysql_datetime()
		);
		$this->db->where('id', $this->input->post('id'));
		$update = $this->db->update('usuarios', $usuario);
		return $update; 	
	}
	
	function duplicado(){
		$usuario = $this->input->post('usuario');
		$query = $this->db->get_where('usuarios', array('usuario' => $usuario));
		if ($query->num_rows() >= 1) {
			return true; 
		}
		return false;
	}
}


