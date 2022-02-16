<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session', 'form_validation', 'get_menu', 'Phpmailer_lib', 'formatter'));
		$this->load->helper(array('url', 'form', 'text'));
		$this->load->database('default');
		$this->load->model(array('usuarios_Model', 'general_Model'));
	}

	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}
		$datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Usuarios', $datos);
	}

	public function myProfile() // MJ: CARGA VISTA PARA VISUALIZAR / ACTUALIZAR PERFIL
	{
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}
		$data = $this->usuarios_Model->getPersonalInformation($this->session->userdata('id_usuario'))->result();
		foreach ($data as $value) {
			$datos["id_usuario"] = $value->id_usuario;
			$datos["nombre"] = $value->nombre;
			$datos["apellido_paterno"] = $value->apellido_paterno;
			$datos["apellido_materno"] = $value->apellido_materno;
			$datos["correo"] = $value->correo;
			$datos["telefono"] = $value->telefono;
			$datos["usuario"] = $value->usuario;
			$datos["tipo"] = $value->tipo;
			$datos["ubicacion"] = $value->ubicacion;
			$datos["contrasena"] = decrypt($value->contrasena);
		}
		$datos += $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Perfil', $datos);
	}

	public function getUsersList() // MJ: OBTIENE LA LISTA DE TODOS LOS USUARIOS
	{
		$data['data'] = $this->usuarios_Model->getUsersList()->result_array();
		echo json_encode($data);
	}

	public function getUserInformation($id_usuario) // MJ: OBTIENE LA INFORMACIÓN ESPECÍFICA DE UN USUARIO
	{
		$data = $this->usuarios_Model->getUserInformation($id_usuario)->result_array();
		$data[0]['contrasena'] = decrypt($data[0]['contrasena']);
		echo json_encode($data);
	}

	public function addEditUser() // MJ: ADD / EDIT USUARIO
	{
		if (isset($_POST) && !empty($_POST)) {
			if ($this->input->post("input_type_up") == 1) { // MJ: ADD OR EDIT GENERAL ARRAY DATA
				$hash = md5(rand(0,1000));
				$data = array(
					"nombre" => $_POST['input_first_name'],
					"apellido_paterno" => $_POST['input_last_name'],
					"apellido_materno" => $_POST['input_mothers_last_name'],
					"correo" => $_POST['input_email_address'],
					"telefono" => $this->formatter->removePhoneFormat($_POST['input_phone']),
					"contrasena" => encrypt($_POST['input-password']),
					"hash" => $hash
				);
			} else { // MJ: CHANGE STATUS ARRAY DATA
				$data = array("estatus" => $this->input->post("input_status"));
			}
			if ($this->input->post("input_type") == 1) { // MJ: ADD USER
				$data["usuario"] = $_POST['input_username'];
				$data["id_rol"] = $_POST['select_user_type'];
				$data["id_sede"] = $_POST['select_location'];
				$data["estatus"] = 3;
				$data["restablecer_contrasena"] = 1;
				$response = $this->general_Model->addRecord("usuarios", $data); // MJ: LLEVA 2 PARÁMETROS $table, $data
			 	$this->sendEmailValidation($_POST['input_email_address'], $_POST['input_username'], $_POST['input-password'], $hash); // MJ: MANDA DATA PARA ENVIAR CORREO DE VALIDACIÓN DE CUENTA
			} else { // EDIT USER
				$data["fecha_modificacion"] = date("Y-m-d H:i:s");
				$data["modificado_por"] = $this->session->userdata('id_usuario');
				$response = $this->general_Model->updateRecord("usuarios", $data, "id_usuario", $this->input->post("input_id_usuario")); // MJ: LLEVA 4 PARÁMETROS $db, $data, $key, $value
			}
			echo json_encode($response);
		} else {
			echo json_encode(0);
		}
	}

	public function resetPassword() // MJ: GENERA CONTRASEÑA PROVISIONAL, ACTUALIZA Y ENVÍA CORREO
	{
		$datos = $this->usuarios_Model->getUser($this->input->post('input_email_address'));
		if (COUNT($datos) > 0) {
			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$password = substr(str_shuffle($permitted_chars), 0, 6);
			$data = array(
				"restablecer_contrasena" => 1,
				"contrasena" => encrypt($password),
				"fecha_modificacion" => date("Y-m-d H:i:s"),
				"modificado_por" => 1,
			);
			$response = $this->general_Model->updateRecord("usuarios", $data, "id_usuario", $datos[0]['id_usuario']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
			if ($response == 1) { // MJ: SUCCESS UPDATE PASSWORD
				$this->sendEmailPass($password, $this->input->post('input_email_address'));
				$this->session->set_userdata('statusCode', 200);
			} else { // MJ: ERROR UPDATE PASSWORD
				$this->session->set_userdata('statusCode', 500);
			}
		} else { // MJ: NO ENCONTRÓ REGISTROS
			$this->session->set_userdata('statusCode', 500);
		}
		redirect(base_url("index.php/Welcome/recoverPassword"));
	}

	public function changePassword() // MJ: CAMBIO DE CONTRASEÑA
	{
		$data = array(
			"restablecer_contrasena" => 0,
			"contrasena" => encrypt($this->input->post('input_passwordc')),
			"fecha_modificacion" => date("Y-m-d H:i:s"),
			"modificado_por" => $this->session->userdata('id_usuario'),
		);
		$response = $this->general_Model->updateRecord("usuarios", $data, "id_usuario", $this->session->userdata('id_usuario')); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
		if ($response == 1) { // MJ: SUCCESS UPDATE
			$data = array('restablecer_contrasena' => 0);
			$this->session->set_userdata($data);
		}
		echo json_encode($response);
	}

	public function sendEmailPass($password, $mailto) // MJ: SE ARMA Y ENVÍA CORREO PARA CAMBIO DE CONTRASEÑA
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
		$mail->Subject = utf8_decode('Restablecer contraseña');
		$mail->isHTML(true);

		$mailContent = utf8_decode("<html><head>
											  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
											  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\">
											  <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css\" integrity=\"sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO\" crossorigin=\"anonymous\">	
											  <title>Restablecer contraseña</title>
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
																							<h1 style=\"color:#241c15;font-family:Georgia,Times,serif;font-size:30px;font-style:normal;font-weight:400;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:center\">¿Olvidaste tu contraseña?</h1>
																						</td>
																					</tr>
																					<tr>
																						<td style=\"padding-right:40px;padding-bottom:40px;padding-left:40px\" valign=\"top\" align=\"left\">
																							<p style=\"color:#6a655f;font-family:'Helvetica Neue',Helvetica,Arial,Verdana,sans-serif;font-size:16px;font-style:normal;font-weight:400;line-height:25px;letter-spacing:normal;margin:0;padding:0;text-align:justify;\">
											
																								Hola,<br><br>
																								Recibió este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta. Es importante que en cuanto lleves a cabo el inicio de sesión cambies tu contraseña.<br><br>
											
																								<b>Contraseña</b>: " . $password . " <br><br>
											
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
		$mail->send();
	}

	public function sendEmailValidation($mailto, $usuario, $contrasena, $hash) // MJ: REENVÍA CORREO PARA ACTIVACIÓN DE CUENTA
	{
		$subject = 'Activación de cuenta';
		$mailContent = '<html><head>
						  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
						  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">	
						  <title>Activación de cuenta</title>
						</head>
						<body>   
							<div bgcolor="#EFEEEA">
								<center>
									<table id="m_-4107947934748351806bodyTable" width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#EFEEEA" align="center">
										<tbody><tr>
											<td id="m_-4107947934748351806bodyCell" style="padding-bottom:60px" valign="top" align="center">
												<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
													<tbody>
													<tr>
														<td style="background-color:#E91E2C" valign="top" bgcolor="#E91E2C" align="center">
															<table style="max-width:640px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
																<tbody><tr>
																	<td style="padding:40px" valign="top" align="center"></td>
																</tr>
																<tr>
																	<td style="background-color:#ffffff;padding-top:40px">&nbsp;</td>
																</tr>
															</tbody></table>
														</td>
													</tr>
													<tr>
														<td valign="top" align="center">
															<table style="background-color:#ffffff;max-width:640px; margin-top: -60px" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
																<tbody>
																<tr>
																	<td valign="top" bgcolor="#FFFFFF" align="center">
																		<img style="width:60%;padding-top: 40px;" src="https://www.ferroplasticas.com/images/food-keepers--logo.svg">
																	</td>
																</tr>
																<tr>
																	<td style="padding-right:40px;padding-bottom:40px;padding-left:40px;padding-top: 40px;" valign="top" bgcolor="#FFFFFF" align="center">
																		<h1 style="color:#241c15;font-family:Georgia,Times,serif;font-size:30px;font-style:normal;font-weight:400;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:center">¡Gracias por registrarte!</h1>
																	</td>
																</tr>
																<tr>
																	<td style="padding-right:40px;padding-bottom:40px;padding-left:40px" valign="top" align="left">
																		<p style="color:#6a655f;font-family:\'Helvetica Neue\',Helvetica,Arial,Verdana,sans-serif;font-size:16px;font-style:normal;font-weight:400;line-height:25px;letter-spacing:normal;margin:0;padding:0;text-align:justify;">
						
																			
																			Tu cuenta ha sido creada, puedes iniciar sesión con las siguientes credenciales después de haber activado tu cuenta presionando la URL a continuación.<br><br>
						
																			<b>Usuario</b>: '.$usuario.'<br>
																			<b>Contraseña</b>: '.$contrasena.'<br><br>
						
																			Haz clic en este enlace para activar tu cuenta:<br>
																			<br><br>
																			'.base_url().'index.php/Validacion/validateAccount/?correo='.$mailto.'&hash='.$hash.' 
																		</p>
																	</td>
																</tr>
																<tr>
																	<td style="border-top:2px solid #efeeea;color:#6a655f;font-family:\'Helvetica Neue\', Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding-top:40px;padding-bottom:40px;text-align:center" valign="top" align="center">
																		<p style="color:#6a655f;font-family:\'Helvetica Neue\',Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding:0 20px;margin:0;text-align:center">Food Keepers Copyright © <?php echo date("Y"); ?></p>
																	</td>
																</tr>
															</tbody></table> 
														</td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
								</center><div class="yj6qo"></div><div class="adL">
							</div></div><div class="adL">
						</div></div></div><div id=":nx" class="ii gt" style="display:none"><div id=":ny" class="a3s aiL undefined"></div></div><div class="hi"></div></div></div><div class="ajx"></div></div>
						</body></html>';
		$this->sendEmail($mailto, $subject, $mailContent);
	}

	public function resendEmailValidation() // MJ: REENVÍA CORREO PARA ACTIVACIÓN DE CUENTA
	{
		$data = $this->usuarios_Model->getPersonalInformation($_POST['input_id_usuario'])->result();
		$mailto = $data[0]->correo;
		$username = $data[0]->usuario;
		$password = decrypt($data[0]->contrasena);
		$subject = 'Activación de cuenta';
		$hash = md5(rand(0,1000));
		$data2 = array(
			"hash" => $hash,
			"fecha_modificacion" => date("Y-m-d H:i:s"),
			"modificado_por" => 1
		);
		$response = $this->general_Model->updateRecord("usuarios", $data2, "id_usuario", $_POST['input_id_usuario']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
		
		$mailContent = '<html><head>
						  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
						  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">	
						  <title>Activación de cuenta</title>
						</head>
						<body>   
							<div bgcolor="#EFEEEA">
								<center>
									<table id="m_-4107947934748351806bodyTable" width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#EFEEEA" align="center">
										<tbody><tr>
											<td id="m_-4107947934748351806bodyCell" style="padding-bottom:60px" valign="top" align="center">
												<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
													<tbody>
													<tr>
														<td style="background-color:#E91E2C" valign="top" bgcolor="#E91E2C" align="center">
															<table style="max-width:640px;" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
																<tbody><tr>
																	<td style="padding:40px" valign="top" align="center"></td>
																</tr>
																<tr>
																	<td style="background-color:#ffffff;padding-top:40px">&nbsp;</td>
																</tr>
															</tbody></table>
														</td>
													</tr>
													<tr>
														<td valign="top" align="center">
															<table style="background-color:#ffffff;max-width:640px; margin-top: -60px" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" align="center">
																<tbody>
																<tr>
																	<td valign="top" bgcolor="#FFFFFF" align="center">
																		<img style="width:60%;padding-top: 40px;" src="https://www.ferroplasticas.com/images/food-keepers--logo.svg">
																	</td>
																</tr>
																<tr>
																	<td style="padding-right:40px;padding-bottom:40px;padding-left:40px;padding-top: 40px;" valign="top" bgcolor="#FFFFFF" align="center">
																		<h1 style="color:#241c15;font-family:Georgia,Times,serif;font-size:30px;font-style:normal;font-weight:400;line-height:42px;letter-spacing:normal;margin:0;padding:0;text-align:center">¡Gracias por registrarte!</h1>
																	</td>
																</tr>
																<tr>
																	<td style="padding-right:40px;padding-bottom:40px;padding-left:40px" valign="top" align="left">
																		<p style="color:#6a655f;font-family:\'Helvetica Neue\',Helvetica,Arial,Verdana,sans-serif;font-size:16px;font-style:normal;font-weight:400;line-height:25px;letter-spacing:normal;margin:0;padding:0;text-align:justify;">
						
																			
																			Tu cuenta ha sido creada, puedes iniciar sesión con las siguientes credenciales después de haber activado tu cuenta presionando la URL a continuación.<br><br>
						
																			<b>Usuario</b>: '.$username.'<br>
																			<b>Contraseña</b>: '.$password.'<br><br>
						
																			Haz clic en este enlace para activar tu cuenta:<br>
																			<br><br>
																			'.base_url().'index.php/Validacion/validateAccount/?correo='.$mailto.'&hash='.$hash.' 
																		</p>
																	</td>
																</tr>
																<tr>
																	<td style="border-top:2px solid #efeeea;color:#6a655f;font-family:\'Helvetica Neue\', Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding-top:40px;padding-bottom:40px;text-align:center" valign="top" align="center">
																		<p style="color:#6a655f;font-family:\'Helvetica Neue\',Helvetica,Arial,Verdana,sans-serif;font-size:12px;font-weight:400;line-height:24px;padding:0 20px;margin:0;text-align:center">Food Keepers Copyright © <?php echo date("Y"); ?></p>
																	</td>
																</tr>
															</tbody></table> 
														</td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody></table>
								</center><div class="yj6qo"></div><div class="adL">
							</div></div><div class="adL">
						</div></div></div><div id=":nx" class="ii gt" style="display:none"><div id=":ny" class="a3s aiL undefined"></div></div><div class="hi"></div></div></div><div class="ajx"></div></div>
						</body></html>';

		$this->sendEmail($mailto, $subject, $mailContent);
		echo json_encode($response);
	}

	public function sendEmail($mailto, $subject, $mailContent) // MJ: SE ARMA Y ENVÍA CORREO
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
		$mail->Subject = utf8_decode($subject);
		$mail->isHTML(true);
		$mail->Body = $mailContent;
		$mail->send();
	}

}
