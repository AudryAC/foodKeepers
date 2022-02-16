<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class welcome_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function validateLogin($username,$password)
	{
		$new_pass = encrypt($password);
		return $this->db->query("SELECT u.id_usuario, u.id_lider, u.id_rol, u.id_sede, u.nombre, u.apellido_paterno, u.apellido_materno, u.correo, u.usuario, u.contrasena,
        u.telefono, u.estatus, u.sesion_activa, u.fecha_creacion, u.creado_por, u.modificado_por, u.restablecer_contrasena, u.id_sesion
        FROM usuarios u WHERE u.usuario = '$username' AND u.contrasena = '$new_pass' AND u.estatus IN (1, 3)")->result();
	}

}
