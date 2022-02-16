<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','form_validation', 'get_menu'));
		$this->load->helper(array('url','form', 'text'));
		$this->load->database('default');
		$this->load->model(array('inventario_Model', 'general_Model'));
    }

    public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE ){
			redirect(base_url());
		}
		
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Inventario', $datos);
    }

	public function getStockList() // MJ: LISTA DE INVENTARIO
	{
		$data['data'] = $this->inventario_Model->getStockList()->result_array();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function getStockInformation($id_stock) // MJ: OBTIENE LA INFORMACIÓNN ESPECÍFICA DE UN PEDIDO
	{
		$data = $this->inventario_Model->getStockInformation($id_stock)->result_array();
		echo json_encode($data);
	}

	public function addEditStock() // MJ: ADD / EDIT PEDIDOS
	{
		if (isset($_POST) && !empty($_POST)) {
			$data = array(
				"cantidad_total" => $_POST['input_quantity'],
				"max_items" => $_POST['input_maximum'],
				"min_items" => $_POST['input_minimum'],
				//"tasa_compra" => $_POST['input-purchase-rate'],
				//"tasa_stock" => $_POST['input-stock-rate'],
				"fecha_modificacion" => date("Y-m-d H:i:s"),
				"modificado_por" => $this->session->userdata('id_usuario')
			);
			$response = $this->general_Model->updateRecord("stocks", $data, "id_stock", $this->input->post("input_id_stock")); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
			echo json_encode($response);
		} else {
			echo json_encode(0);
		}
	}

}
