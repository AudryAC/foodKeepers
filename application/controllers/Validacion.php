<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validacion extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session', 'form_validation', 'get_menu'));
		$this->load->helper(array('url', 'form', 'text'));
		$this->load->database('default');
		$this->load->model(array('validacion_Model'));
    }

    public function index()
	{
    }

	public function validateAccount()
	{
		if(isset($_GET['correo']) && !empty($_GET['correo']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
			// MJ: VERIFY DATA
			$correo = $_GET['correo']; // MJ: SET CORREO VARIEBLE
			$hash = $_GET['hash']; // MJ: SET HASH VARIABLE
			// MJ: PRIMERO HAY QUE VALIDAR SI LA CUENTA NO HA SIDO ACTIVADA
			$query = $this->validacion_Model->validateAccountStatus($correo, $hash);
			if (COUNT($query) > 0){ // MJ: LA CUENTA NO SE HA ACTIVADO
				$datos["id_usuario"] = $query[0]->id_usuario;
				$datos["estatus"] = 3;

			} else { // MJ: LA CUENTA YA HA SIDO ACTIVADA
				$datos["estatus"] = 1;
			}
			$this->load->view('v_Validacion', $datos);
		}else{
			// MJ: INVALID DATA
		}
	}

	public function activeteAccount() // MJ: CAMBIO DE CONTRASEÑA
	{
		$data = array(
			"estatus" => 1,
			"fecha_modificacion" => date("Y-m-d H:i:s"),
			"modificado_por" => $this->session->userdata('id_usuario'),
		);
		$response = $this->validacion_Model->updateRecord("usuarios", $data, "id_usuario", $this->input->post("input_id_usuario")); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
		echo json_encode($response);
	}

}
