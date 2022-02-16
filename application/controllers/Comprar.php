<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprar extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session', 'form_validation', 'get_menu', 'cart'));
		$this->load->helper(array('url', 'form', 'text'));
		$this->load->database('default');
		$this->load->model(array('comprar_Model', 'general_Model'));
	}

	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Comprar', $datos);
	}

	public function shoppingCart()
	{
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Carrito', $datos);
	}

	public function checkout()
	{
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Revision', $datos);
	}

	public function orderSuccess()
	{
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}
		$query = $this->comprar_Model->getGeneralInformation($this->session->userdata('current_order'));
		$itms = $this->comprar_Model->getItems($this->session->userdata('current_order'));
		$items = array();
		for ($i = 0; $i < COUNT($itms); $i++) {
			$items["name"][$i] = $itms[$i]->name;
			$items["qty"][$i] = $itms[$i]->qty;
			$items["price"][$i] = $itms[$i]->price;
			$items["subtotal"][$i] = $itms[$i]->subtotal;
			$items["image"][$i] = $itms[$i]->image;
		}

		$datos["items"] = $items;
		$datos["id_pedido"] = $query[0]->id_pedido;
		$datos["fecha_pedido"] = $query[0]->fecha_pedido;
		$datos["nombre_cliente"] = $query[0]->nombre_cliente;
		$datos["forma_pago"] = $query[0]->forma_pago;
		$datos["importe"] = $query[0]->importe;
		$datos += $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_EstatusPedido', $datos);
	}

	public function getCategories() // MJ: OBTIENE LISTADO DE TODAS LAS CATEGORÍAS ACTIVAS
	{
		echo json_encode($this->comprar_Model->getCategories()->result_array());
	}

	public function getProductsByCategorie($id_categoria) // MJ: OBTIENE LISTADO DE TODAS LAS CATEGORÍAS ACTIVAS
	{
		echo json_encode($this->comprar_Model->getProductsByCategorie($id_categoria)->result_array());
	}

	public function getClients() // MJ: OBTIENE LISTADO DE TODOS LOS CLIENTES
	{
		echo json_encode($this->comprar_Model->getClients()->result_array());
	}

	public function cartAction()
	{
		$cart = new Cart;
		if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
			if ($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])) {
				$productID = $_REQUEST['id'];
				$Qty = ($_REQUEST['qty'] != null) ? $_REQUEST['qty'] : 1;
				// get product details
				$query = $this->comprar_Model->getProducts($productID)->row();
				$itemData = array('id' => $query->id_producto, 'name' => $query->nombre, 'description' => $query->descripcion, 'code' => $query->codigo, 'image' => $query->imagen, 'price' => $query->precio_lista, 'qty' => $Qty);
				$insertItem = $cart->insert($itemData);

				// MJ: UPDATE TOTAL ITEMS PULLED APART
				$queryt = $this->comprar_Model->getTotalItemsByProduct($productID);
				$stockData = array("cantidad_actual" => $queryt[0]->cantidad_actual + 1);
				$this->general_Model->updateRecord("stocks", $stockData, "id_stock", $queryt[0]->id_stock); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value

				$transaction_result = $insertItem ? '1' : '0';
				echo json_encode($transaction_result);
			}
			elseif ($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])) {
				$queryt = $this->comprar_Model->getTotalItemsByProduct($_REQUEST['id_producto']);
				if ($_REQUEST['old_qty'] < $_REQUEST['qty']) {
					$stockData = array("cantidad_actual" => $queryt[0]->cantidad_actual + 1);
					$this->general_Model->updateRecord("stocks", $stockData, "id_stock", $queryt[0]->id_stock); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
				} else {
					$stockData = array("cantidad_actual" => $queryt[0]->cantidad_actual - 1);
					$this->general_Model->updateRecord("stocks", $stockData, "id_stock", $queryt[0]->id_stock); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
				}
				$itemData = array('rowid' => $_REQUEST['id'], 'qty' => $_REQUEST['qty']);
				$updateItem = $cart->update($itemData);
				echo $updateItem ? 'ok' : 'err';
				die;
			}
			elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])) {
				$queryt = $this->comprar_Model->getTotalItemsByProduct($_REQUEST['id_producto']);
				$stockData = array("cantidad_actual" => $queryt[0]->cantidad_actual - $_REQUEST['qty']);
				$this->general_Model->updateRecord("stocks", $stockData, "id_stock", $queryt[0]->id_stock); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
				$transaction_result = $cart->remove($_REQUEST['id']);
				if ($transaction_result)
					echo json_encode(1); // MJ: SUCCESSFUL
				else
					echo json_encode(2); // MJ: ERROR
			}
			elseif ($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0) {
				$clientData = array("nombre" => $_POST['input_first_name'], "apellido_paterno" => $_POST['input_last_name'], "apellido_materno" => $_POST['input_mothers_last_name'], "correo" => $_POST['input_email_address'], "telefono" => $_POST['input_phone'], "contacto" => $_POST['input_contact'], "calle" => $_POST['input_street'], "colonia" => $_POST['input_suburb'], "numero" => $_POST['input_number'], "municipio" => $_POST['input_municipality'], "estado" => $_POST['input_state'] == '' ? $_POST['select_state'] : $_POST['input_state'], "pais" => $_POST['select_country'], "cp" => $_POST['input_postal_code']);
				if ($_POST['input_type'] == 1) { // ADD CLIENT
					$clientAtion = $this->comprar_Model->addRecord('clientes', $clientData);
					$id_cliente = $this->db->insert_id();
				} else { // UPDATE CLIENT
					$id_cliente = $_POST['select-clients'][0];
					$clientAtion = $this->comprar_Model->updateClient($clientData, $id_cliente);
				}
				// insert order details into database
				$orderData = array("id_vendedor" => $this->session->userdata('id_usuario'), "id_cliente" => $id_cliente, "id_sucursal" => 1, "estatus" => 1, "estatus_pedido" => 1);
				$insertOrder = $this->comprar_Model->addRecord('pedidos', $orderData);
				if ($insertOrder) {
					// begin transaction
					$orderID = $this->db->insert_id();
					//$this->db->trans_start();
					// get cart items
					$cartItems = $cart->contents();
					foreach ($cartItems as $item) { // insert cart items into database
						$queryt = $this->comprar_Model->getTotalItemsByProduct($item['id']);
						$stockData = array("cantidad_actual" => $queryt[0]->cantidad_actual - $item['qty'], "cantidad_total" => $queryt[0]->cantidad_total - $item['qty']);
						$this->general_Model->updateRecord("stocks", $stockData, "id_stock", $queryt[0]->id_stock); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
						$itemsData = array("id_pedido" => $orderID, "id_producto" => $item['id'], "cantidad" => $item['qty'], "precio_lista" => $item['price'], "total" => $item['subtotal']);
						$insertOrderItems = $this->comprar_Model->addRecord('articulos_x_pedidos', $itemsData);
					}
					// insert shipping details into database
					$shippingData = array("id_pedido" => $orderID, "clave" => 'PR00' . $orderID, "estatus" => 1, "estatus_envio" => 0);
					$this->comprar_Model->addRecord('envios', $shippingData);
					// insert ticket into database
					$total = $cart->total() + $cart->total() * .16;
					$ticketData = array("id_pedido" => $orderID, "importe" => $cart->total(), "iva" => $total, "descuento" => 0, "estatus" => 1);
					$this->comprar_Model->addRecord('tickets', $ticketData);
					$id_ticket = $this->db->insert_id();
					// MJ: SE RECORRE ARRAY MÉTODOS DE PAGO PARA OBTENER MONTO E INSERTAR EN TARJETAS / TRANSFERENCIAS EN CASO DE QUE VENGAN EL POST
					for ($j = 0; $j < count($this->input->post("paymentMethod")); $j++) {
						$detailsTicketData = array("id_ticket" => $id_ticket, "forma_pago" => $_POST['paymentMethod'][$j], "estatus" => 1);
						if ($_POST['paymentMethod'][$j] == 1) { // MJ: TARJETA DE CRÉDITO
							$detailsTicketData["importe"] = $_POST['input_card_amount'];
							$cardData = array("id_pedido" => $orderID, "tipo" => $_POST['select_type'], "msi" => $_POST['input_msi']);
							$this->comprar_Model->addRecord('tarjetas', $cardData);
						}
						if ($_POST['paymentMethod'][$j] == 2) { // MJ: TRANSFERENCIA
							$detailsTicketData["importe"] = $_POST['input_transfer_amount'];
							$transferData = array("id_pedido" => $orderID, "clave" => $_POST['input_code']);
							$this->comprar_Model->addRecord('transferencias', $transferData);
						}
						if ($_POST['paymentMethod'][$j] == 3) {  // MJ: EFECTIVO
							$detailsTicketData["importe"] = $_POST['input_cash_amount'];

						}
						// insert ticket details into database
						$this->comprar_Model->addRecord('detalles_x_tickets', $detailsTicketData);
					}
					// complete transaction
					//$this->db->trans_complete();
					if ($insertOrderItems) { //if ($this->db->trans_status() === TRUE) {
						$this->session->set_userdata('current_order', $orderID);
						$cart->destroy();
						echo json_encode(1);
					} else { // $this->db->trans_status() === FALSE
						echo json_encode(2); // ERROR EL INSERTAR CART ITEMS, SHIPPING, TICKET, TICKET DETAILS
					}
				} else {
					echo json_encode(3); // SI LA ORDEN NO SE INSERTÓ OK AQUÍ HAY QUE MANDAR EL ERROR
				}
			} else {
				echo json_encode(4); // *ACTION placeOrder* NO VIENE SETEADO EL TOTAL CART = 0
			}
		} else {
			header("Location: comprar"); // *ACTION* NO VIENE SETEADO
		}
	}

	function getProductDetail()
	{
		$id_producto = $this->input->post('id_producto');
		echo $id_producto;
	}

}
