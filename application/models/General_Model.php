<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class general_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getOptions($id_catalogo)
	{
		return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = $id_catalogo AND estatus = 1 ORDER BY id_opcion, nombre");
	}

	public function addRecord($table, $data) // MJ: AGREGA UN REGISTRO A UNA TABLA EN PARTICULAR, RECIBE 2 PARÁMETROS. LA TABLA Y LA DATA A INSERTAR
	{
		if ($data != '' && $data != null) {
			$response = $this->db->insert($table, $data);
			if (!$response) {
				return $finalAnswer = 0;
			} else {
				return $finalAnswer = 1;
			}
		} else {
			return 0;
		}
	}

	public function updateRecord($table, $data, $key, $value) // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
	{
		$response = $this->db->update($table, $data, "$key = '$value'");
		if (!$response) {
			return $finalAnswer = 0;
		} else {
			return $finalAnswer = 1;
		}
	}

	function getChangelog($id, $type) // MJ: OBTIENE EL CHANGELOG DE PEDIOS / ENVÍOS
	{
		switch ($type) {
			case 1: // MJ: FROM PEDIDOS
				$query = $this->db->query("SELECT hp.id_pedido, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario,
				oxc.nombre estatus, GROUP_CONCAT(pr.nombre SEPARATOR ', ') articulos, DATE_FORMAT(hp.fecha_creacion, '%W %c/%e/%Y %h:%i %p') fecha
				FROM historial_pedidos hp 
				INNER JOIN usuarios u ON u.id_usuario = hp.creado_por
				INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = hp.estatus AND oxc.id_catalogo = 3
				INNER JOIN pedidos p ON p.id_pedido = hp.id_pedido
				INNER JOIN articulos_x_pedidos axp ON axp.id_pedido = p.id_pedido
				INNER JOIN productos pr ON pr.id_producto = axp.id_producto
				WHERE hp.id_pedido = $id
				GROUP BY hp.id_pedido, hp.estatus");
				break;
			case 2: // MJ: FROM ENVÍOS
				$query = $this->db->query("SELECT he.id_envio, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario,
				oxc.nombre estatus, DATE_FORMAT(he.fecha_creacion, '%W %c/%e/%Y %h:%i %p') fecha
				FROM historial_envios he
				INNER JOIN usuarios u ON u.id_usuario = he.creado_por
				INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = he.estatus AND oxc.id_catalogo = 4
				WHERE he.id_envio = $id
				GROUP BY he.id_envio, he.estatus");
				break;
		}
		return $query;
	}

	public function deleteRecord($table, $key, $value) // MJ: ELIMINA UN REGISTRO. RECIBE 3 PARÁMETROS
	{
		$this->db->where($key, $value);
		$this->db->delete($table);
	}

}
