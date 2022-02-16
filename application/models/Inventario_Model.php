<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class inventario_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
    }

	public function getStockList() // MJ: OBTIENE LA LISTA DE TODOS EL INVENTARIO
	{
		return $this->db->query("SELECT s.id_stock, p.nombre producto, c.nombre categoria,
		s.cantidad_total, s.cantidad_actual,
		s.max_items, s.min_items FROM stocks s 
		INNER JOIN productos p ON p.id_producto = s.id_producto
		INNER JOIN categorias_x_productos cxp ON cxp.id_producto = p.id_producto
		INNER JOIN categorias c ON c.id_categoria = cxp.id_categoria");
	}

	public function getStockInformation($id_stock) // MJ: OBTIENE UN REGISTRO DE STOCKS
	{
		return $this->db->query("SELECT s.id_stock, p.nombre producto, c.nombre categoria,
		s.cantidad_total, s.cantidad_actual,
		s.max_items, s.min_items FROM stocks s 
		INNER JOIN productos p ON p.id_producto = s.id_producto
		INNER JOIN categorias_x_productos cxp ON cxp.id_producto = p.id_producto
		INNER JOIN categorias c ON c.id_categoria = cxp.id_categoria
		WHERE s.id_stock = $id_stock");
	}

}
