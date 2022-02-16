<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','form_validation', 'get_menu'));
		$this->load->helper(array('url','form', 'text'));
		$this->load->database('default');
		$this->load->model(array('categorias_Model'));
	}

	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE ){
			redirect(base_url());
		}

		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Categorias', $datos);
	}

	public function getAllCategoria()
	{
		$data = $this->categorias_Model->getAllCategoria();

		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function changeStatus()
	{
		if(isset($_POST) && !empty($_POST)){
			$data = array(
				"estatus" => $this->input->post("estatus"),
				"fecha_modificacion" => date("Y-m-d H:i:s"),
				"modificado_por" => $this->session->userdata('id_usuario'),
			);
			$response = $this->categorias_Model->changeUserStatus($data, $this->input->post("id_categoria"));
			echo json_encode($response);
		}
	}

	public function addCategoria()
	{
		$nombre = $this->input->post('nombre');

		/*$imagenProducto = $this->input->post('imagenProducto');*/


		if ($_FILES['imagenCategoria']['size'] > 0 && $_FILES['imagenCategoria']['error'] != 1)
		{
			$data = array();
			$fileTmpPath = $_FILES['imagenCategoria']['tmp_name'];
			$fileName = $_FILES['imagenCategoria']['name'];
			$fileSize = $_FILES['imagenCategoria']['size'];
			$fileType = $_FILES['imagenCategoria']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
			$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
			$uploadFileDir = FCPATH.'assets/img/categories/';
			$dest_path = $uploadFileDir . $newFileName;
			move_uploaded_file($fileTmpPath, $dest_path);
			$data_category = array(
				"nombre" => $nombre,
				"imagen" => $newFileName,
				"fecha_creacion" => date('Y-m-d H:i:s'),
				"creado_por" => $this->session->userdata('id_usuario'),
				"fecha_modificacion" => date('Y-m-d H:i:s'),
				"modificado_por" => $this->session->userdata('id_usuario'),
				"estatus" => 1
			);
			$data_request = $this->categorias_Model->addCategory($data_category);
			if($data_request>0)
			{
				$data['success'] = 1;
				$data['message'] = 'La categoría fue añadida exitosamente.';
			}
			else{
				$data['success'] = 0;
				$data['message'] = 'Algo ocurrió al intentar añadir la categoría, inténtalo nuevamente.';
			}
		}else{
			$data['success'] = 0;
			$data['message'] = 'Debes seccionar un archivo.';
		}

		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}


	public function getCatInfoById($id_categoria)
	{
		$data = $this->categorias_Model->getCatInfoById($id_categoria);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function updateCategory()
	{
		$nombreE = $this->input->post('nombreE');
		$imagenCategoriaE = $this->input->post('imagenProductoE');

		$id_categoria = $this->input->post('id_categoriaE');

		$data_update = array(
			'nombre' => $nombreE,
			'fecha_modificacion' => date("Y-m-d H:i:s"),
			'modificado_por' => $this->session->userdata('id_usuario')
		);
		if($imagenCategoriaE != '' && $imagenCategoriaE != null)
		{
			$data_update['imagen'] = $imagenCategoriaE;

		}else if ($_FILES['imagenNewCategoriaE']['size'] > 0 && $_FILES['imagenNewCategoriaE']['error'] != 1)
		{
			$fileTmpPath = $_FILES['imagenNewCategoriaE']['tmp_name'];
			$fileName = $_FILES['imagenNewCategoriaE']['name'];
			$fileSize = $_FILES['imagenNewCategoriaE']['size'];
			$fileType = $_FILES['imagenNewCategoriaE']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
			$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
			$uploadFileDir = FCPATH.'assets/img/categories/';
			$dest_path = $uploadFileDir . $newFileName;
			move_uploaded_file($fileTmpPath, $dest_path);
			$data_update['imagen'] = $newFileName;
		}
		$data = $this->categorias_Model->updateCategory($data_update, $id_categoria);

		if($data > 0)
		{
			$data_request['success'] = 1;
			$data_request['message'] = 'Se actualizó correctamente la categoría.';
		}else{
			$data_request['success'] = 0;
			$data_request['message'] = 'Ocurrió un error al intentar actualizar la categoría.';
		}

		if($data_request != null){
			echo json_encode($data_request);
		}
		else{
			echo json_encode(array());
		}

	}
}
