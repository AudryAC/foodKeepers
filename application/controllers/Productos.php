<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {	
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','form_validation', 'get_menu'));
		$this->load->helper(array('url','form', 'text'));
		$this->load->database('default');
		$this->load->model(array('Productos_Model', 'general_Model'));
    }

    public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE ){
			redirect(base_url());
		}
		
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Productos', $datos);
    }

    public function getAllProductos()
	{
		$data = $this->Productos_Model->getAllProductos();

		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function addProduct()
	{
		$nombre = $this->input->post('nombre');
		$precioMayorista = $this->input->post('precioMayorista');
		$precioLista = $this->input->post('precioLista');
		$codigo = $this->input->post('codigo');
		$descripcion = $this->input->post('descripcion');
		$categoria = $this->input->post('categoria');

		//print_r(count($categoria));

		/*$imagenProducto = $this->input->post('imagenProducto');*/


		if ($_FILES['imagenProducto']['size'] > 0 && $_FILES['imagenProducto']['error'] != 1)
		{
			$data = array();
			$fileTmpPath = $_FILES['imagenProducto']['tmp_name'];
			$fileName = $_FILES['imagenProducto']['name'];
			$fileSize = $_FILES['imagenProducto']['size'];
			$fileType = $_FILES['imagenProducto']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
			$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
			$uploadFileDir = FCPATH.'assets/img/products/';
			$dest_path = $uploadFileDir . $newFileName;
			move_uploaded_file($fileTmpPath, $dest_path);
			$data_producto = array(
				"barcode" => date('ymdhism') . rand(0, 9) . rand(0, 9),
				"nombre" => $nombre,
				"precio_mayorista" => $precioMayorista,
				"precio_lista" => $precioLista,
				"imagen" => $newFileName,
				"codigo" => $codigo,
				"descripcion" => $descripcion,
				"fecha_creacion" => date('Y-m-d H:i:s'),
				"creado_por" => $this->session->userdata('id_usuario'),
				"fecha_modificacion" => date('Y-m-d H:i:s'),
				"modificado_por" => $this->session->userdata('id_usuario'),
				"estatus" => 1
			);

			$data_request = $this->Productos_Model->addProduct($data_producto);
			$lastID = $this->Productos_Model->lastId();

			for($n=0; $n < count($categoria); $n++)
			{
				$dataInsert_catsprod = array(
					'id_producto' => $lastID->produc,
					'id_categoria' => $categoria[$n],
					'fecha_creacion' => date('Y-m-d H:i:s'),
					'creado_por' => 1,
					'fecha_modificacion' => date('Y-m-d H:i:s'),
					'modificado_por' => 1
				);
				$this->Productos_Model->addCatsxProds($dataInsert_catsprod);
			}

			$stockData = array(
				"id_producto" => $lastID->produc,
				"cantidad_total" => 0,
				"cantidad_actual" => 0,
				"max_items" => 0,
				"min_items" => 0
			);

			$this->general_Model->addRecord("stocks", $stockData); // MJ: LLEVA 2 PARÁMETROS $table, $data

			if($data_request>0)
			{
				$data['success'] = 1;
				$data['message'] = 'El producto fue añadido exitosamente.';
			}
			else{
				$data['success'] = 0;
				$data['message'] = 'Algo ocurrió al intentar añadir el producto, inténtalo nuevamente.';
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

	public function changeStatus()
	{
		if(isset($_POST) && !empty($_POST)){
			$data = array(
				"estatus" => $this->input->post("estatus"),
				"fecha_modificacion" => date("Y-m-d H:i:s"),
				"modificado_por" => $this->session->userdata('id_usuario'),
			);
			$response = $this->Productos_Model->changeUserStatus($data, $this->input->post("id_producto"));
			echo json_encode($response);
		}
	}

	public function getProductInfoById($id_producto)
	{
		$data = $this->Productos_Model->getProductInfoById($id_producto);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}

	}

	function GetCXPbyIdProd($id_producto)
	{
		$data = $this->Productos_Model->GetCXPbyIdProd($id_producto);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}

	}
	function getAllCats()
	{
		$data = $this->Productos_Model->getAllCats();
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}


	public function updateProduct()
	{
		$nombreE = $this->input->post('nombreE');
		$precioMayoristaE = $this->input->post('precioMayoristaE');
		$precioListaE = $this->input->post('precioListaE');
		$codigoE = $this->input->post('codigoE');
		$descripcionE = $this->input->post('descripcionE');
		$imagenProductoE = $this->input->post('imagenProductoE');

		$id_producto = $this->input->post('id_productoE');

		$categorias = $this->input->post('categoriaE');

//		print_r($categorias);
		$array_compare = array();
		if(isset($categorias))
		{
			for($n = 0; $n < count($_POST['categoriaE']); $n++)
			{
				$data_vc_exist = $this->Productos_Model->verifyIfExistPXC($id_producto, $_POST['categoriaE'][$n]);

				if(!empty($data_vc_exist))
				{
					$data_current_pxc = $this->Productos_Model->GetCXPbyIdProd($id_producto);
					for($i=0; $i<count($data_current_pxc); $i++)
					{
						$array_compare[$i] = $data_current_pxc[$i]['id_categoria'];
						$data_update = array(
							"creado_por" => $this->session->userdata('id_usuario'),
							"fecha_creacion" => date("Y-m-d H:i:s"),
							"estatus" => 1
						);
						$this->Productos_Model->update_ventas_pxc($data_update, $data_vc_exist[0]['id_cp']);
					}

					$array_diferente = array_values(array_diff($array_compare, $_POST['categoriaE']));
					for($u=0; $u < count($array_diferente); $u++)
					{
						$data_vc_exist_2 = $this->Productos_Model->verifyIfExistPXC($id_producto, $array_diferente[$u]);

						/*echo 'DEBES QUITAR ESTOS: '.$data_vc_exist_2[0]['id_cp']."<br><br>";*/
						$data_update = array(
							"creado_por" => $this->session->userdata('id_usuario'),
							"fecha_creacion" => date("Y-m-d H:i:s"),
							"estatus" => 0
						);
						$this->Productos_Model->update_ventas_pxc($data_update, $data_vc_exist_2[0]['id_cp']);
					}

				}
				else
				{
					/**/$dataInsert_catsprod = array(
						'id_producto' => $id_producto,
						'id_categoria' => $_POST['categoriaE'][$n],
						'fecha_creacion' => date('Y-m-d H:i:s'),
						'creado_por' => 1,
						'fecha_modificacion' => date('Y-m-d H:i:s'),
						'modificado_por' => 1
					);
					$this->Productos_Model->addCatsxProds($dataInsert_catsprod);
				}
			}
		}
		/*echo "ARRAY CURRENT:<br>";
		print_r($array_compare);
		echo "<br>ARRAY POST:<br>";
		print_r($_POST['categoriaE']);
		echo '<br><br>';
		print_r(array_diff($array_compare, $_POST['categoriaE']));
		exit;*/


		$data_update = array(
			'nombre' => $nombreE,
			'precio_mayorista' => $precioMayoristaE,
			'precio_lista' => $precioListaE,
			'codigo' => $codigoE,
			'descripcion' => $descripcionE,
			'fecha_modificacion' => date("Y-m-d H:i:s"),
			'modificado_por' => $this->session->userdata('id_usuario')
		);
		if($imagenProductoE != '' && $imagenProductoE != null)
		{
			$data_update['imagen'] = $imagenProductoE;

		}else if ($_FILES['imagenNewProductoE']['size'] > 0 && $_FILES['imagenNewProductoE']['error'] != 1)
		{
			$fileTmpPath = $_FILES['imagenNewProductoE']['tmp_name'];
			$fileName = $_FILES['imagenNewProductoE']['name'];
			$fileSize = $_FILES['imagenNewProductoE']['size'];
			$fileType = $_FILES['imagenNewProductoE']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
			$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
			$uploadFileDir = FCPATH.'assets/img/products/';
			$dest_path = $uploadFileDir . $newFileName;
			move_uploaded_file($fileTmpPath, $dest_path);
			$data_update['imagen'] = $newFileName;
		}
		$data = $this->Productos_Model->updateProduct($data_update, $id_producto);

		if($data > 0)
		{
			$data_request['success'] = 1;
			$data_request['message'] = 'Se actualizó correctamente el producto.';
		}else{
			$data_request['success'] = 0;
			$data_request['message'] = 'Ocurrió un error al intentar actualizar el producto.';
		}

		if($data_request != null){
			echo json_encode($data_request);
		}
		else{
			echo json_encode(array());
		}



	}

}
