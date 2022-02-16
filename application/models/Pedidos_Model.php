<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pedidos_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getOrdersList() // MJ: OBTIENE LA LISTA DE TODAS LO PEDIDOS
	{
		return $this->db->query("SELECT p.id_pedido, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre_cliente,
		CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_vendedor,
		p.estatus, oxc.nombre estatus_pedido, SUM(axp.total) total, SUM(axp.cantidad) num_articulos, p.fecha_pedido,
		IFNULL(e.estatus_envio, 0) envio, IFNULL(t.estatus, 0) ticket, p.estatus_pedido FROM pedidos p
		LEFT JOIN envios e ON e.id_pedido = p.id_pedido
		INNER JOIN clientes c ON c.id_cliente = p.id_cliente
		INNER JOIN usuarios u ON u.id_usuario = p.id_vendedor
		INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = p.estatus_pedido AND oxc.id_catalogo = 3
		INNER JOIN articulos_x_pedidos axp ON axp.id_pedido = p.id_pedido
		LEFT JOIN tickets t ON 	t.id_pedido = p.id_pedido GROUP BY p.id_pedido;");
	}

	public function getOrderInformation($id_pedido) // MJ: OBTIENE EL REGISTRO EN ESPECÍFICO DE UN PEDIDO
	{
		return $this->db->query("SELECT p.id_pedido, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre_cliente, c.id_cliente,
		CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_vendedor,
		p.estatus, oxc.nombre estatus_pedido, SUM(axp.total) total, SUM(axp.cantidad) num_articulos, p.fecha_pedido,
		IFNULL(e.estatus, 0) envio, IFNULL(t.estatus, 0) ticket, c.correo, c.telefono,
		UPPER(CONCAT(c.calle, ' ', c.numero, ' ', c.colonia, ', ', c.cp, ' ', c.municipio, ', ', 
		(CASE WHEN oxc2.nombre IS NULL THEN c.estado ELSE oxc2.nombre END), ', ', oxc3.nombre, '.')) direccion
		FROM pedidos p
		LEFT JOIN envios e ON e.id_pedido = p.id_pedido
		INNER JOIN clientes c ON c.id_cliente = p.id_cliente
		INNER JOIN usuarios u ON u.id_usuario = p.id_vendedor
		INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = p.estatus_pedido AND oxc.id_catalogo = 3
		INNER JOIN articulos_x_pedidos axp ON axp.id_pedido = p.id_pedido
		LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = c.estado AND oxc2.id_catalogo = 7
		LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = c.pais AND oxc3.id_catalogo = 6
		LEFT JOIN tickets t ON 	t.id_pedido = p.id_pedido WHERE p.id_pedido = $id_pedido GROUP BY p.id_pedido;
        ");
	}

	public function getOrderDetailsInformation($id_pedido) // MJ: OBTIENE EL DETALLE DE UN PEDIDO
	{
		return $this->db->query("SELECT pr.nombre producto, pr.codigo, axp.cantidad, axp.precio_lista, axp.total total_descuento, 
		(axp.precio_lista * axp.cantidad) total FROM articulos_x_pedidos axp
		INNER JOIN productos pr ON pr.id_producto = axp.id_producto WHERE axp.id_pedido = $id_pedido;");
	}

}
