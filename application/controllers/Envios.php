<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Envios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session', 'form_validation', 'get_menu'));
		$this->load->helper(array('url', 'form', 'text'));
		$this->load->database('default');
		$this->load->model(array('envios_Model', 'general_Model'));
	}

	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}

		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Envios', $datos);
	}

	public function getShippingList() // MJ: OBTIENE LA LISTA DE TODOS LOS ENVÍOS
	{
		$data['data'] = $this->envios_Model->getShippingList()->result_array();
		echo json_encode($data);
	}

	public function addEditShipping() // MJ: ADD / EDIT
	{
		if (isset($_POST) && !empty($_POST)) {
			if ($this->input->post("input_type_up") == 1) { // MJ: ADD OR EDIT GENERAL ARRAY DATA
				$data = array(
					"id_pedido" => $_POST['input_id_pedido'],
					"clave" => $_POST['input_clave'],
					"estatus_pedido" => $_POST['input_estatus_pedido']
				);
			} else { // MJ: CHANGE STATUS ARRAY DATA
				$data = array("estatus" => $this->input->post("input_status"));
			}
			if ($this->input->post("input_type") == 1) // ADD USER
				$response = $this->general_Model->addRecord("envios", $data); // MJ: LLEVA 2 PARÁMETROS $table, $data
			else { // MJ: EDIT USER
				$data["fecha_modificacion"] = date("Y-m-d H:i:s");
				$data["modificado_por"] = $this->session->userdata('id_usuario');
				$response = $this->general_Model->updateRecord("envios", $data, "id_envio", $this->input->post("input_id-envio")); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
			}
			echo json_encode($response);
		} else {
			echo json_encode(0);
		}
	}
}
