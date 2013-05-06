<?php

/**
 * 
 * 
 * @author Jesus Rodriguez
 * @version 
 */	

class Log_model extends Model {

	function __construct() {
		parent::Model();
	}
	
 function get_logs($num, $offset) {
 	#$this->db->select("id, url, accion, desc"); 
 	$query = $this->db->get('view_log', $num, $offset);	
    return $query;
  }
  
  function get_logs_user($id, $num, $offset){
  	$this->db->select(" usuarios.usuario AS 'usuario', log.ip AS 'ip', log.accion AS 'accion',log.detalle AS 'detalle', 
					   date_format(log.fecha,'%d-%m-%Y %H:%i %p') AS 'fecha'", FALSE); 
  	$this->db->join('usuarios', 'log.id_usuario = usuarios.id', 'left');
  	$this->db->order_by("log.id", "DESC"); 
	$query = $this->db->get_where('log', array('log.id_usuario' => $id), $num, $offset);
			
	$data = $query->result_array();
	$num_rows = $query->num_rows();
	if ($num_rows > 0 )
		return $data ;
	else 
		return 0;			
  }
  
  function count_logs_user($id_usuario) {
  	$query = $this->db->query("SELECT COUNT(id_usuario) as 'logs' FROM log WHERE id_usuario = $id_usuario");
  	$logs = $query->row();
  	return $logs->logs; 
  }

}