<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class envios_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getShippingList() // MJ: OBTIENE LA LISTA DE TODOS LOS ENVÍOS
	{
		return $this->db->query("SELECT p.id_pedido, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre_cliente,
		CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_vendedor,
		e.estatus, oxc.nombre estatus_pedido, SUM(axp.total) total, SUM(axp.cantidad) num_articulos, e.fecha_envio,
		e.estatus_envio, IFNULL(t.estatus, 0) ticket, p.estatus_pedido, e.id_envio FROM envios e
		INNER JOIN pedidos p ON p.id_pedido = e.id_pedido
		INNER JOIN clientes c ON c.id_cliente = p.id_cliente
		INNER JOIN usuarios u ON u.id_usuario = p.id_vendedor
		INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = p.estatus_pedido AND oxc.id_catalogo = 3
		INNER JOIN articulos_x_pedidos axp ON axp.id_pedido = p.id_pedido
		INNER JOIN tickets t ON 	t.id_pedido = p.id_pedido GROUP BY e.id_envio;");
	}

}
