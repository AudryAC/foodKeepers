<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session', 'form_validation', 'get_menu', 'formatter'));
		$this->load->helper(array('url', 'form', 'text'));
		$this->load->database('default');
		$this->load->model(array('clientes_Model', 'general_Model'));
	}

	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Clientes', $datos);
	}

	public function getClientsList() // MJ: LISTA DE CLIENTES
	{
		$data['data'] = $this->clientes_Model->getClientsList()->result_array();
		echo json_encode($data);
	}

	public function getClientInformation($id_cliente) // MJ: OBTIENE LA INFORMACIÓN DE UN CLIENTE EN PARTICULAR
	{
		$data = $this->clientes_Model->getClientInformation($id_cliente)->result_array();
		echo json_encode($data);
	}

	public function addEditClient() // MJ: ADD / EDIT CLIENTE
	{
		if (isset($_POST) && !empty($_POST)) {
			if ($this->input->post("input_type_up") == 1) { // MJ: ADD OR EDIT GENERAL ARRAY DATA
				$data = array(
					"nombre" => $_POST['input_first_name'],
					"apellido_paterno" => $_POST['input_last_name'],
					"apellido_materno" => $_POST['input_mothers_last_name'],
					"correo" => $_POST['input_email_address'],
					"telefono" => $this->formatter->removePhoneFormat($_POST['input_phone']),
					"contacto" => $_POST['input_contact'],
					"calle" => $_POST['input_street'],
					"colonia" => $_POST['input_suburb'],
					"numero" => $_POST['input_number'],
					"municipio" => $_POST['input_municipality'],
					"estado" => $_POST['input_state'] == '' ? $_POST['select_state'] : $_POST['input_state'],
					"pais" => $_POST['select_country'],
					"cp" => $_POST['input_postal_code']
				);
			} else { // MJ: CHANGE STATUS ARRAY DATA
				$data = array("estatus" => $this->input->post("input_status"));
			}
			if ($this->input->post("input_type") == 1) // MJ: ADD CLIENT
				$response = $this->general_Model->addRecord("clientes", $data); // MJ: LLEVA 2 PARÁMETROS $table, $data
			else { // MJ: EDIT CLIENT
				$data["fecha_modificacion"] = date("Y-m-d H:i:s");
				$data["modificado_por"] = $this->session->userdata('id_usuario');
				$response = $this->general_Model->updateRecord("clientes", $data, "id_cliente", $this->input->post("input_id_cliente")); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
			}
			echo json_encode($response);
		} else {
			echo json_encode(0);
		}
	}
}
