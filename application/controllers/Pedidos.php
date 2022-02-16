<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session', 'form_validation', 'get_menu', 'Pdf', 'phpmailer_lib'));
		$this->load->helper(array('url', 'form', 'text'));
		$this->load->database('default');
		$this->load->model(array('pedidos_Model', 'general_Model'));
	}

	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}

		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Pedidos', $datos);
	}

	public function getOrdersList() // MJ: OBTIENE LA LISTA DE TODOS LOS PEDIDOS
	{
		$data['data'] = $this->pedidos_Model->getOrdersList()->result_array();
		echo json_encode($data);
	}

	public function addEditOrder() // MJ: ADD / EDIT PEDIDOS
	{
		if (isset($_POST) && !empty($_POST)) {
			if ($this->input->post("input_type_up") == 1) { // MJ: ADD OR EDIT GENERAL ARRAY DATA
				$data = array(
					"id_vendedor" => $_POST['input_id_vendedor'],
					"id_cliente" => $_POST['input_id_cliente'],
					"id_sucursal" => $_POST['input_id_sucursal'],
					"estatus" => 1,
					"estatus_pedido" => 0,
				);
			} else { // MJ: CHANGE STATUS ARRAY DATA
				$data = array("estatus" => $this->input->post("input_status"));
			}
			if ($this->input->post("input_type") == 1) // MJ: ADD USER
				$response = $this->general_Model->addRecord("pedidos", $data); // MJ: LLEVA 2 PARÁMETROS $table, $data
			else { // EDIT USER
				$data["fecha_modificacion"] = date("Y-m-d H:i:s");
				$data["modificado_por"] = $this->session->userdata('id_usuario');
				$response = $this->general_Model->updateRecord("pedidos", $data, "id_pedido", $this->input->post("input_id_pedido")); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
			}
			echo json_encode($response);
		} else {
			echo json_encode(0);
		}
	}

	public function getOrderInformation($id_pedido) // MJ: OBTIENE LA INFORMACIÓNN ESPECÍFICA DE UN PEDIDO
	{
		$data = $this->pedidos_Model->getOrderInformation($id_pedido)->result_array();
		echo json_encode($data);
	}

	public function getOrderDetailsInformation($id_pedido) // MJ: OBTIENE LOS DETALLES DE UN PEDIDO
	{
		$data = $this->pedidos_Model->getOrderDetailsInformation($id_pedido)->result_array();
		echo json_encode($data);
	}

	public function printOrder($id_pedido, $type)
	{
		/*
		 type
			1 print pdf
			2 print and send email
		  */
		date_default_timezone_set("America/Mexico_City");
		setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
		$pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		// $pdf->SetAuthor('Sistemas Victor Manuel Sanchez Ramirez');
		$pdf->SetTitle('INFORMACIÓN GENERAL DE PEDIDO');
		$pdf->SetSubject('Información general de pedido');
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(TRUE, 0);
		//relación utilizada para ajustar la conversión de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setPrintHeader(false);
		// $pdf->setPrintFooter();
		$pdf->setFontSubsetting(true);

		$pdf->SetFont('dejavusans', '', 9, '', true);
		$pdf->SetMargins(7, 10, 10, true);
		$pdf->AddPage('P', 'LETTER');
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$bMargin = $pdf->getBreakMargin();
		$auto_page_break = $pdf->getAutoPageBreak();

		$pdf->setPageMark();
		$order_info = $this->pedidos_Model->getOrderInformation($id_pedido)->result();

		$order_details = $this->pedidos_Model->getOrderDetailsInformation($id_pedido)->result();
		$html_details = '';
		$color_row = '';
		$total = 0;
		for ($i = 0; $i < COUNT($order_details); $i++) {
			$total += $order_details[$i]->total;
			$color_row = $i % 2 != 0 ? '#eaeaea' : '#fff';
			$html_details .= '<tr style="background-color: ' . $color_row . '">
								<td>' . $order_details[$i]->codigo . '</td>
							  	<td>&nbsp;&nbsp;' . $order_details[$i]->producto . '</td>
								<td align="center">$' . number_format($order_details[$i]->precio_lista, 2) . '</td>
								<td align="center">' . $order_details[$i]->cantidad . '</td>
								<td align="center">$' . number_format($order_details[$i]->total, 2) . '</td>
								<td align="center">$' . number_format($order_details[$i]->total_descuento, 2) . '</td>
							  </tr>';
		}
		$iva = $total * 0.16;
		$grandTotal = $total + $iva;
		// AA: Encabezado e información general del cliente.
		if ($order_info) {
			$html = '
					<link rel="stylesheet" media="print" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
            		<style media="print">
						label { 
							color: black; 
							border-bottom:10em;
						}
						u {
							text-decoration: none;
							border-bottom: 10px solid black;
						}​
					</style>
					<body>';
			$html2 = '
							<table>
								<tr style="color:#333;">
									<td>
										<div align="left"><img width="250px" src="' . base_url("assets/img/brand/food-keepers--logo.png") . '"><br><br>FoodKeepers, S. DE R.L. DE C.V.<br>Circuito Balvanera Nº 3, Fracc. Ind. Balvanera.<br>Corregidora, Querétaro. CP. 76900. México.<br>Tel. <b>(442) 372 3133</b> |<b> ecommerce@ferroplasticas.com</b></div>
									</td>
									<td>
										<div align="right"><span style="font-size:24px; color: #EF3739">COTIZACIÓN<br></span><br><br><br><span style="font-size:12px;"><b>FOLIO:</b> FK00' . $id_pedido . '&nbsp;&nbsp;<br><b>ID CLIENTE: </b>' . $order_info[0]->id_cliente . '</span>&nbsp;&nbsp;<br><b>FECHA:</b>' . strftime("%e de  %B del %Y") . '&nbsp;&nbsp;</div>
									</td>
								</tr>
    						</table>';
			$html3 = '
							<table>
								<tr style="color:#333;">
									<td>
										<div align="right"><span style="font-size:12px;"><b>FOLIO:</b> FK00' . $id_pedido . '&nbsp;&nbsp;<br><b>ID CLIENTE: </b>' . $order_info[0]->id_cliente . '</span>&nbsp;&nbsp;<br><b>FECHA:</b>' . strftime("%e de  %B del %Y") . '&nbsp;&nbsp;</div>
									</td>
								</tr>
    						</table>';
			$html4 = '
							<table>
								<tr>
									<td>
										<div style="color:#333;">
											<p><span style="color: #EF3739; font-size: 14px;">CLIENTE</span><br>' . $order_info[0]->nombre_cliente . '<br><b></b>' . $order_info[0]->direccion . '<br>Tel. <b>' . $order_info[0]->telefono . '</b> | <b>' . $order_info[0]->correo . '</b></p>
										</div>
									</td>
								</tr>
							</table>
							<table style="font-size:12px; color:#333;">
								<tr style="background-color: #EF3739; padding:5px;">
									<th style="color: #fff; width: 18%">&nbsp;&nbsp;<b>Código</b></th>
									<th style="color: #fff; width: 35%">&nbsp;&nbsp;<b>Descripción</b></th>
									<th align="center" style="color: #fff; width: 15%"><b>Costo unit.</b></th>
									<th align="center" style="color: #fff; width: 7%"><b>Pzs</b></th>
									<th align="center" style="color: #fff; width: 10%"><b>IVA</b></th>
									<th align="center" style="color: #fff; width: 15%"><b>Total</b></th>
								</tr>
								' . $html_details . '
							</table>
							<br><br>
							<table style="font-size:12px; color:#333;">
								<tr>
									<td style="width: 75%"></td>
									<td align="center" style="width: 10%">Subtotal</td>
									<td style="width: 15%">
										<table>
											<tr>
												<td>$</td>
												<td align="right">' . $total . '</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="width: 75%"></td>
									<td align="center" style="width: 10%">IVA</td>
									<td style="width: 15%">
										<table>
											<tr>
												<td>$</td>
												<td align="right">' . $iva . '</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="width: 75%"></td>
									<td align="center" style="width:10%;">Total</td>
									<td style="width: 15%;">
										<table>
											<tr>
												<td>$</td>
												<td align="right">' . $grandTotal . '</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						<body>
					</html>';

			$pdf->writeHTMLCell(0, 0, $x = '', $y = '10', $html . $html2 . $html4, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
			//ob_end_clean();
			$finalHtml = $html . $html3 . $html4;
			if ($type == 2) {
				$namePDF = utf8_decode('ORDER_SUCCESS.pdf');
				$attachment = $pdf->Output(utf8_decode($namePDF), 'S');
				$this->sendOrderEmail($namePDF, $attachment, $order_info[0]->correo, $finalHtml);
			}
			$pdf->Output(utf8_decode("Informacion_" . $order_info[0]->nombre_cliente . ".pdf"), 'I');
		}
	}

	public function sendOrderEmail($namePDF, $attachment, $mailto, $htmlContent) // MJ: SE ARMA Y ENVÍA CORREO PARA ADJUNTAR EL PDF EL PEDIDO
	{
		$mail = $this->phpmailer_lib->load();
		$mail->isSMTP();
		//$mail->SMTPDebug = 5;
		//$mail->Host = 'smtp.gmail.com'; // MJ: LOCAL ENVIRONMENT
		$mail->Host = 'solucionescontablespv.com.mx'; // MJ: TEST ENVIRONMENT
		$mail->SMTPAuth = true;
		//$mail->Username = 'food.keepers1@gmail.com'; // MJ: LOCAL ENVIRONMENT
		$mail->Username = 'aureaargaiz@solucionescontablespv.com.mx'; // MJ: TEST ENVIRONMENT
		//$mail->Password = 'foodkeepers2021'; // MJ: LOCAL ENVIRONMENT
		$mail->Password = 'javapackage1'; // MJ: TEST ENVIRONMENT
		//$mail->SMTPSecure = 'tls'; // MJ: LOCAL ENVIRONMENT
		$mail->SMTPSecure = 'ssl'; // MJ: TEST ENVIRONMENT
		//$mail->Port = 587; // MJ: LOCAL ENVIRONMENT
		$mail->Port = 465; // MJ: TEST ENVIRONMENT
		//$mail->setFrom('food.keepers1@gmail.com', 'Food Keepers'); // MJ: LOCAL ENVIRONMENT
		$mail->setFrom('aureaargaiz@solucionescontablespv.com.mx', 'Food Keepers'); // MJ: TEST ENVIRONMENT
		$mail->AddAddress($mailto);
		$mail->Subject = utf8_decode('Gracias por tu pedido');
		$mail->isHTML(true);
		$mailContent = utf8_decode("<html><head>
											  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
											  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\">
											  <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css\" integrity=\"sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO\" crossorigin=\"anonymous\">	
											  <title>Gracias por tu pedido</title>
											</head>
											<body>   
												<div bgcolor=\"#EFEEEA\">
													<center>
														<table id=\"m_-4107947934748351806bodyTable\" width=\"100%\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" bgcolor=\"#EFEEEA\" align=\"center\">
															<tbody><tr>
																<td id=\"m_-4107947934748351806bodyCell\" style=\"padding-bottom:60px\" valign=\"top\" align=\"center\">
																	<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\">
																		<tbody>
																		<tr>
																			<td style=\"background-color:#E91E2C\" valign=\"top\" bgcolor=\"#E91E2C\" align=\"center\">
																				<table style=\"max-width:640px;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\">
																					<tbody><tr>
																						<td style=\"padding:40px\" valign=\"top\" align=\"center\"></td>
																					</tr>
																					<tr>
																						<td style=\"background-color:#ffffff;padding-top:40px\">&nbsp;</td>
																					</tr>
																				</tbody></table>
																			</td>
																		</tr>
																		<tr>
																			<td valign=\"top\" align=\"center\">
																				<table style=\"background-color:#ffffff;max-width:640px; margin-top: -60px\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" bgcolor=\"#FFFFFF\" align=\"center\">
																					<tbody>
																					<tr>
																						<td valign=\"top\" bgcolor=\"#FFFFFF\" align=\"center\">
																							<img style=\"width:60%;padding-top: 40px;\" src=\"https://www.ferroplasticas.com/images/food-keepers--logo.svg\">
																						</td>
																					</tr>
																					<tr>
																						<td style=\"padding-right:40px;padding-bottom:40px;padding-left:40px;padding-top: 40px;\" valign=\"top\" bgcolor=\"#FFFFFF\" align=\"center\">
																							<h1 style=\"color:#241c15;font-family:Georgia,Times,serif;font-size:30px;font-style:normal;font-weight:400;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:center\">Gracias por tu pedido</h1>
																						</td>
																					</tr>
																					<tr>
																						<td style=\"padding-right:40px;padding-bottom:40px;padding-left:40px\" valign=\"top\" align=\"left\">
																							<p style=\"color:#6a655f;font-family:'Helvetica Neue',Helvetica,Arial,Verdana,sans-serif;font-size:16px;font-style:normal;font-weight:400;line-height:25px;letter-spacing:normal;margin:0;padding:0;text-align:justify;\">
											
																								Hola,<br><br>
																								
																								Tu pedido se ha recibido y se está procesando. Para tu información, los detalles del pedido son los siguientes.<br><br>			
																								" . $htmlContent . "
																								Saludos,<br>
																								Food Keepers
																							</p>
																						</td>
																					</tr>
																					<tr>
																						<td style=\"border-top:2px solid #efeeea;color:#6a655f;font-family:'Helvetica Neue', Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding-top:40px;padding-bottom:40px;text-align:center\" valign=\"top\" align=\"center\">
																							<p style=\"color:#6a655f;font-family:'Helvetica Neue',Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding:0 20px;margin:0;text-align:center\">Food Keepers Copyright © <?php echo date(\"Y\"); ?></p>
																						</td>
																					</tr>
																				</tbody></table> 
																			</td>
																		</tr>
																	</tbody></table>
																</td>
															</tr>
														</tbody></table>
													</center><div class=\"yj6qo\"></div><div class=\"adL\">
												</div></div><div class=\"adL\">
											</div></div></div><div id=\":nx\" class=\"ii gt\" style=\"display:none\"><div id=\":ny\" class=\"a3s aiL undefined\"></div></div><div class=\"hi\"></div></div></div><div class=\"ajx\"></div></div>
											</body></html>");
		$mail->Body = $mailContent;
		$mail->AddStringAttachment($attachment, $namePDF);
		$mail->send();
		/*if(!$mail->send()) {
        	echo "Mailer Error: " . $mail->ErrorInfo;
	    } 
	    else {
	        echo "Message has been sent successfully";
	    }*/

	}

}
