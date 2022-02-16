<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session', 'form_validation'));
		$this->load->helper(array('url', 'form', 'text'));
		$this->load->database('default');
		$this->load->model(array('welcome_Model', 'general_Model'));
	}

	public function index()
	{
		switch ($this->session->userdata('id_rol')) {
			case '1': // ADMINISTRADOR
				redirect(base_url() . 'index.php/Home');
				break;
			default:
				$data['token'] = $this->token();
				$data['titulo'] = 'Login con roles de usuario en codeigniter';
				$this->load->view('v_Login', $data);
				break;
		}
	}

	public function token()
	{
		$token = md5(uniqid(rand(), true));
		$this->session->set_userdata('token', $token);
		return $token;
	}

	public function validateLogin()
	{
		if ($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token')) {
			$this->form_validation->set_rules('username', 'nombre de usuario', 'required|trim|min_length[2]|max_length[150]|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'required|trim|min_length[5]|max_length[150]|xss_clean');
			$this->form_validation->set_message('required', 'El %s es requerido');
			$this->form_validation->set_message('max_length', 'El %s debe tener al menos %s carácteres');
			$check_user = $this->welcome_Model->validateLogin($this->input->post('input_username'), $this->input->post('input-password'));
			if (empty($check_user)) {
				$this->session->set_userdata('errorLogin', 33);
				redirect(base_url());
			} else {
				if ($check_user == TRUE) {
					if ($check_user[0]->estatus == 1) { // MJ: CUENTA ACTIVA
						if ($check_user[0]->sesion_activa == 0) { // MJ: SE VALIDA LA SESIÓN 0 NO TIENE SESIÓN ACTIVA
							$data = array(
								'is_logued_in' => TRUE,
								'id_usuario' => $check_user[0]->id_usuario,
								'nombre' => $check_user[0]->nombre,
								'apellido_paterno' => $check_user[0]->apellido_paterno,
								'apellido_materno' => $check_user[0]->apellido_materno,
								'id_sede' => $check_user[0]->id_sede,
								'id_rol' => $check_user[0]->id_rol,
								'id_lider' => $check_user[0]->id_lider,
								'usuario' => $check_user[0]->usuario,
								'restablecer_contrasena' => $check_user[0]->restablecer_contrasena
							);
							$data2 = array(
								"sesion_activa" => 1,
								"id_sesion" => $this->session->session_id,
								"fecha_modificacion" => date("Y-m-d H:i:s"),
								"modificado_por" => $this->session->userdata('id_usuario'),
							);
							$this->general_Model->updateRecord("usuarios", $data2, "id_usuario",  $check_user[0]->id_usuario); // LLEVA 4 MARÁMETROS $table, $data, $key, $value
							$this->session->set_userdata($data);
							$this->index();
						} else { //MJ: CUENTA CON UNA SESIÓN ACTIVA sesion_activa = 1
							$this->session->set_userdata('errorLogin', 34); // MJ: ERROR SESIÓN ACTIVA
							$this->session->set_userdata('userLogin', $check_user[0]->usuario); // MJ: USUARIO QUE CUENTA CON UNA SESIÓN ACTIVA
							$this->session->set_userdata('idSesion', $check_user[0]->id_sesion); // MJ: USUARIO QUE CUENTA CON UNA SESIÓN ACTIVA
							redirect(base_url());
						}
					} else { // MJ: CUENTA SIN ACTIVAR
						$this->session->set_userdata('errorLogin', 35); // MJ: ERROR, LA CUENTA AÚN NO HA SIDO ACTIVADA
						redirect(base_url());
					}
				}
			}
		} else {
			redirect(base_url());
		}
	}

	public function logout()
	{
		$data = array(
			"sesion_activa" => 0,
			"fecha_modificacion" => date("Y-m-d H:i:s"),
			"modificado_por" => $this->session->userdata('id_usuario'),
		);
		$this->general_Model->updateRecord("usuarios", $data, "id_usuario", $this->session->userdata('id_usuario')); // LLEVA 4 MARÁMETROS $table, $data, $key, $value
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function recoverPassword()
	{
		$data['token'] = $this->token();
		$data['titulo'] = 'Login con roles de usuario en codeigniter';
		$this->load->view('v_Contrasena', $data);
	}

	public function resetSession() // MJ
	{
		$data = array(
			"sesion_activa" => 0,
			"fecha_modificacion" => date("Y-m-d H:i:s"),
			"modificado_por" => 1,
		);
		$response = $this->general_Model->updateRecord("usuarios", $data, "usuario", $this->input->post('input_user')); // LLEVA 4 MARÁMETROS $table, $data, $key, $value
		$this->general_Model->deleteRecord("session_fk", "id", $this->input->post('input_id')); // MJ: LLEVA 3 PARÁMETROS $data, $key, $value
		echo json_encode($response);
	}
}
