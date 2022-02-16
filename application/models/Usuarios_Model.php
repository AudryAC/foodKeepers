<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class usuarios_Model extends CI_Model

{

	public function __construct()

	{

		parent::__construct();

	}



	public function getPersonalInformation($id_usuario) // MJ: OBTIENE LA INFORMACIÓN DE UN USUARIO EN PARTICULAR

	{
		return $this->db->query("SELECT id_usuario, u.nombre, apellido_paterno, apellido_materno, correo, usuario, 
		telefono, usuario, contrasena, oxc.nombre tipo, oxc2.nombre ubicacion FROM usuarios u
		INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
		INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u.id_sede AND oxc2.id_catalogo = 2
		WHERE id_usuario = $id_usuario");
	}



	public function getUsersList() // MJ: OBTIENE LA LISTA DE TODOS LOS USUARIOS

	{
		return $this->db->query("SELECT u.id_usuario, CONCAT(u.nombre, ' ', apellido_paterno, ' ', u.apellido_materno) nombre_completo, 
		u.correo, u.usuario, u.telefono, u.contrasena, oxc.nombre tipo, oxc2.nombre ubicacion, u.estatus FROM usuarios u
		INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
		INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u.id_sede AND oxc2.id_catalogo = 2 ORDER BY nombre_completo;");
	}



	public function getUserInformation($id_usuario) // MJ: OBTIENE LA INFORMACIÓN DE UN USUARIO

	{

		return $this->db->query("SELECT id_usuario, u.nombre, apellido_paterno, apellido_materno, correo, usuario, 

		telefono, usuario, contrasena, oxc.nombre tipo, oxc2.nombre ubicacion, u.id_rol, u.id_sede FROM usuarios u

		INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1

		INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u.id_sede AND oxc2.id_catalogo = 2

		WHERE id_usuario = $id_usuario;");

	}



	public function getUser($email) // MJ: OBTIENE EL ID DE USUARIO CON BASE EN EMAIL RECIBIDO COMO PARÁMETRO

	{

		return $this->db->query("SELECT id_usuario FROM usuarios WHERE correo = '$email' AND estatus = 1")->result_array();

	}



	public function validateAccountStatus($correo, $hash){

		return $this->db-> query("SELECT correo, hash, estatus, id_usuario FROM usuarios WHERE correo= '$correo' AND hash= '$hash' AND estatus = 3")->result_array();

	}



}

