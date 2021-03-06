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
		$this->load->library('adldap');
		
	}
	
	function validar_en_sistema($usuario){
		#$usuario = $this->input->post('usuario');
		$this->db->where('usuario',$usuario);
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
		#$res = $this->adldap->authenticate($usuario,$password);
		#return $res ;
		return true;		
	}
    
	function existe_en_ldap($usuario) {
		
		$flag = $this->adldap->user_exist($usuario);
		return $flag;
	}
	
	function get_usuario($usuario) {
		$this->db->select("usuarios.id, usuarios.id_acceso, usuarios.usuario,  
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
		$this->db->select("id, id_estatus, id_personal, cedula, id_acceso, usuario"); 
							
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
		accesos.nombre as 'acceso',
		IF(usuarios.id_estatus = 1,'Activo','Inactivo') as 'estatus',
		IF(usuarios.id_estatus = 1,'good_bit.png','bad_bit.png') as 'img'
		FROM
		usuarios			
		LEFT Join accesos			ON usuarios.id_acceso = accesos.id
		LEFT Join usuarios uc 		ON uc.id = usuarios.id_creador
		WHERE usuarios.usuario != 'admin'
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
		'usuario'				=> to_minuscula(trim($this->input->post('usuario'))),
		'cedula'				=> (int) $this->input->post('cedula'),		  
		'id_personal'			=> (int) $this->input->post('id_personal'),
		'id_estatus'			=> (int) $this->input->post('id_estatus'),
		'id_acceso'				=> $this->input->post('id_acceso'),
		'id_creador' 			=> $this->session->userdata('id'),
		'fecha_creacion' 		=> now_mysql_datetime(),
		'fecha_actualizacion'   => now_mysql_datetime()
		);	
		$insert = $this->db->insert('usuarios', $row);	
		return $this->db->insert_id();
	}
	
	function editar() {
		$usuario = array(
		'usuario'	 		=> $this->input->post('usuario'),		
		'id_acceso'			=> $this->input->post('id_acceso'),
		'id_estatus'		=> $this->input->post('id_estatus'),
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

    function listar_usaurios_obj() {
		$query = $this->db->query("
		SELECT
		usuarios.id,
		usuarios.usuario,
		usuarios.nombres,
		usuarios.apellidos,
		uc.usuario as 'creador',
		coordinaciones.nombre as 'coordinacion',
		accesos.nombre as 'acceso',
                usuarios.fecha_creacion,
                usuarios.fecha_actualizacion,
		IF(usuarios.id_estatus = 1,'Activo','Inactivo') as 'estatus',
		IF(usuarios.id_estatus = 1,'good_bit.png','bad_bit.png') as 'img'
		FROM
		usuarios
		INNER Join coordinaciones ON usuarios.id_coordinacion = coordinaciones.id
		LEFT Join accesos 				ON usuarios.id_acceso = accesos.id
		INNER Join usuarios uc 		ON uc.id = usuarios.id_creador
		ORDER BY usuarios.usuario ASC
		");
		return $query ;		
	}
	
	function get_personal($cedula) {
		$this->sigefirrhh = $this->load->database('sigefirrhh',TRUE); 		
		$this->sigefirrhh->select("*");  	
		$this->sigefirrhh->from('personal');	
		$this->sigefirrhh->where('cedula = ',$cedula ) ;		
		$query = $this->sigefirrhh->get();		
		//$row = $this->sigefirrhh->query($sql);
		if ($query->num_rows()>0)			
			return $query->row();
		else
			return FALSE;
	}
        
}


