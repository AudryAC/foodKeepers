<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session', 'form_validation', 'get_menu', 'phpmailer_lib'));
		$this->load->helper(array('url', 'form', 'text'));
		$this->load->database('default');
		$this->load->model(array('general_Model'));
	}

	public function index()
	{
	}

	public function getOptions($id_catalogo)// MJ: OBTIENE LAS OPCIONES POR CATÁLOG CON BASE EN EL PARÁMETRO RECIBIDO (ID CATÁLOGO)
	{
		echo json_encode($this->general_Model->getOptions($id_catalogo)->result_array());
	}

	public function changeStatus($id) // MJ: ACTUALIZA EL ESTATUS DEL PEDIDO / ENVÍO
	{
		if (isset($_POST) && !empty($_POST)) {
			$data = array(
				"fecha_modificacion" => date("Y-m-d H:i:s"),
				"modificado_por" => $this->session->userdata('id_usuario')
			);
			$hdata = array(
				"fecha_creacion" => date("Y-m-d H:i:s"),
				"creado_por" => $this->session->userdata('id_usuario'),
				"fecha_modificacion" => date("Y-m-d H:i:s"),
				"modificado_por" => $this->session->userdata('id_usuario'),
				"estatus" => $this->input->post("select_status")
			);
			$id_array = explode(",", $id);
			if ($this->input->post("input_type_upc") == 1) { // MJ: FROM PEDIDOS
				$data = array("estatus_pedido" => $this->input->post("select_status"));
				$hdata = array("id_pedido" => $id);
				for( $i = 0; $i < count($id_array); $i++){
					$response = $this->general_Model->updateRecord("pedidos", $data, "id_pedido", $id_array[$i]); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
					$this->general_Model->addRecord("historial_pedidos", $hdata); // MJ: LLEVA 2 PARÁMETROS $table, $data
				}
			} else { // MJ: FROM ENVIOS
				$data = array("estatus_envio" => $this->input->post("select_status"));
				$hdata = array("id_envio" => $id);
				for( $i = 0; $i < count($id_array); $i++){
					$response = $this->general_Model->updateRecord("envios	", $data, "id_envio", $id_array[$i]); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
					$this->general_Model->addRecord("historial_envios", $hdata); // MJ: LLEVA 2 PARÁMETROS $table, $data
				}
			}
			echo json_encode($response);
		} else {
			echo json_encode(0);
		}
	}

	public function getChangelog($id, $type) // MJ: OBTIENE LA BITÁCORA DE CAMBIOS DE PEDIDOS / ENVÍOS
	{
		$data = $this->general_Model->getChangelog($id, $type)->result_array();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}


}
