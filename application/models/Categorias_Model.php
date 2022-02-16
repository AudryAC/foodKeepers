<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class categorias_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}


	function getAllCategoria()
	{
		$query = $this->db->query('SELECT * FROM categorias');
		return $query->result_array();
	}

	function changeUserStatus($data, $id_categoria) {
		$response = $this->db->update("categorias", $data, "id_categoria = $id_categoria");
		if (! $response ) {
			return $finalAnswer = 0;
		} else {
			return $finalAnswer = 1;
		}
	}

	function addCategory($data_category)
	{
		$this->db->insert('categorias',$data_category);
		return $this->db->affected_rows();
	}

	function getCatInfoById($id_categoria)
	{
		$query = $this->db->query("SELECT * FROM categorias WHERE id_categoria=".$id_categoria);
		return $query->result_array();
	}

	public function updateCategory($data_update, $id_categoria)
	{
		$this->db->where("id_categoria",$id_categoria);
		$this->db->update('categorias',$data_update);
		return $this->db->affected_rows();
	}


}
