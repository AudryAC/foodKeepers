<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class comprar_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
    }

	public function getCategories()
	{
		return $this->db->query("SELECT id_categoria id_opcion, nombre FROM categorias WHERE estatus = 1 ORDER BY id_opcion, nombre");
	}

	public function getProductsByCategorie($id_categoria)
	{
		return $this->db->query("SELECT cxp.id_categoria, cxp.id_producto, p.nombre, p.descripcion, 
		p.precio_lista, p.precio_mayorista, p.imagen image FROM categorias_x_productos cxp 
		INNER JOIN productos p ON p.id_producto = cxp.id_producto
		INNER JOIN stocks s ON s.id_producto = p.id_producto AND s.cantidad_total > 0
		WHERE cxp.id_categoria = $id_categoria;");
	}

	public function getClients()
	{
		return $this->db->query("SELECT id_cliente id_opcion, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre_cliente FROM clientes WHERE estatus = 1 ORDER BY nombre_cliente");
	}

	public function getProducts($id_producto)
	{
		return $this->db->query("SELECT * FROM productos WHERE id_producto = $id_producto");
	}

	public function addRecord($table, $data) // MJ: INSERT RECORD
	{
		return $this->db->insert($table, $data);
	}

	public function updateClient($data, $id_cliente) // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 2 PARÁMETROS. DATA A ACTUALIZAR Y EL VALOR DE LA LLAVE
	{
		$response = $this->db->update('clientes', $data, "id_cliente = '$id_cliente'");
		if (!$response) {
			return $finalAnswer = 0;
		} else {
			return $finalAnswer = 1;
		}
	}

	public function getGeneralInformation($current_order) // MJ: OBTIENE LA INFORMACIÓN GENERAL DEL PEDIDO
	{
		return $this->db->query("SELECT p.id_pedido, fecha_pedido, CONCAT(c.nombre,  ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre_cliente,
		GROUP_CONCAT(oxc.nombre SEPARATOR ', ') forma_pago, SUM(dxtk.importe) importe FROM pedidos p 
		INNER JOIN clientes c ON c.id_cliente = p.id_cliente
		INNER JOIN tickets tk ON tk.id_pedido = p.id_pedido
		INNER JOIN detalles_x_tickets dxtk ON dxtk.id_ticket = tk.id_ticket
		INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = dxtk.forma_pago AND oxc.id_catalogo = 8
		WHERE p.id_pedido = $current_order
		GROUP BY p.id_pedido, fecha_pedido, CONCAT(c.nombre,  ' ', c.apellido_paterno, ' ', c.apellido_materno)")->result();
	}

	public function getItems($current_order) // MJ: OBTIENE TODOS LOS ARTÍCULOS POR PEDIDO
	{
		return $this->db->query("SELECT axp.id_ap, p.nombre name, axp.precio_lista price, (axp.cantidad * axp.precio_lista) 
		subtotal, p.imagen image, axp.cantidad qty FROM articulos_x_pedidos axp 
		INNER JOIN productos p ON p.id_producto = axp.id_producto
		WHERE axp.id_pedido = $current_order")->result();
	}

	public function getTotalItemsByProduct($id_producto)
	{
		return $this->db->query("SELECT id_stock, id_producto, cantidad_total, cantidad_actual FROM stocks WHERE id_producto = $id_producto")->result();
	}

}
