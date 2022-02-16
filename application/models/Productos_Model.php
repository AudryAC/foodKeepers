<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class productos_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
    }

	public function getAllProductos()
	{
		$query = $this->db->query("SELECT p.id_producto, p.nombre, p.precio_mayorista, p.precio_lista, p.imagen, p.codigo, p.descripcion, 
		p.estatus, p.fecha_creacion, GROUP_CONCAT(c.nombre SEPARATOR ', ') categoria, s.cantidad_total, p.barcode FROM productos p
		INNER JOIN categorias_x_productos cxp ON cxp.id_producto = p.id_producto
		INNER JOIN categorias c ON c.id_categoria = cxp.id_categoria
		INNER JOIN stocks s ON s.id_producto = p.id_producto
		GROUP BY p.id_producto, p.nombre, p.precio_mayorista, p.precio_lista, p.imagen, p.codigo, p.descripcion, p.estatus, p.fecha_creacion, p.barcode	");
		return $query->result_array();
	}

	public function addProduct($data_producto)
	{
		$this->db->insert('productos',$data_producto);
		//return $this->db->affected_rows();
		$insertId = $this->db->insert_id();
		return  $insertId;
	}
	function changeUserStatus($data, $id_producto) {
		$response = $this->db->update("productos", $data, "id_producto = $id_producto");
		if (! $response ) {
			return $finalAnswer = 0;
		} else {
			return $finalAnswer = 1;
		}
	}

	function getProductInfoById($id_producto)
	{
		$query = $this->db->query("SELECT * FROM productos WHERE id_producto=".$id_producto);
		return $query->result_array();
	}

	function updateProduct($data_producto, $id_producto)
	{
		$this->db->where("id_producto",$id_producto);
		$this->db->update('productos',$data_producto);
		return $this->db->affected_rows();
	}



	function addCatsxProds($dataCatsxProd)
	{
		//categorias_x_productos
		$this->db->insert('categorias_x_productos',$dataCatsxProd);
		return $this->db->affected_rows();
	}

	function lastId()
	{
		$query = $this->db->query("SELECT MAX(id_producto) as produc from productos WHERE estatus=1");
		return $query->row();
	}
	function GetCXPbyIdProd($id_producto)
	{
		$query = $this->db->query("SELECT c.id_categoria, c.nombre, id_cp FROM categorias_x_productos cp 
									INNER JOIN categorias c ON cp.id_categoria=c.id_categoria
									WHERE id_producto=".$id_producto." AND cp.estatus=1");
		return $query->result_array();
	}

	function getAllCats()
	{
		$query = $this->db->query("SELECT * FROM categorias WHERE estatus=1");
		return $query->result_array();
	}

	function verifyIfExistPXC($id_producto, $id_categoria)
	{

		$query = $this->db->query("SELECT * FROM categorias_x_productos WHERE id_producto=" . $id_producto . " AND id_categoria=" . $id_categoria);
		return $query->result_array();

	}
	function update_ventas_pxc($data_update, $id_cp)
	{
		$this->db->update("categorias_x_productos", $data_update, "id_cp = $id_cp");
		return $this->db->affected_rows();
	}
}
