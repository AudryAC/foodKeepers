<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogos extends CI_Controller {	
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','form_validation', 'get_menu'));
		$this->load->helper(array('url','form', 'text'));
		$this->load->database('default');
		$this->load->model(array('catalogos_Model'));		
    }

    public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE ){
			redirect(base_url());
		}
		
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Catalogos', $datos);
    }
}