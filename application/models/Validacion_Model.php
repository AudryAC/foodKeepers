<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class validacion_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function validateAccountStatus($correo, $hash){
		return $this->db-> query("SELECT correo, hash, estatus, id_usuario FROM usuarios WHERE correo= '$correo' AND hash= '$hash' AND estatus = 3")->result();
	}

	public function updateRecord($table, $data, $key, $value) // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
	{
		$response = $this->db->update($table, $data, "$key = '$value'");
		if (!$response) {
			return $finalAnswer = 0;
		} else {
			return $finalAnswer = 1;
		}
	}

}
