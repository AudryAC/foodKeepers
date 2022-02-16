<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class clientes_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getClientsList() // MJ: OBTIENE LA LISTA DE TODOS LOS CLIENTES
	{
		return $this->db->query("SELECT id_cliente, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre_completo, 
		correo, telefono, estatus FROM clientes ORDER BY nombre_completo;");
	}

	public function getClientInformation($id_usuario) // MJ: OBTIENE LA INFORMACIÓN DE UN CLIENTE EN PARTICULAR
	{
		return $this->db->query("SELECT * FROM clientes WHERE id_cliente = $id_usuario;");
	}

}
