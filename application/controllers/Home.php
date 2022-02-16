<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {	
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','form_validation', 'get_menu', 'formatter'));
		$this->load->helper(array('url','form', 'text'));
		$this->load->database('default');
		$this->load->model(array('home_Model'));
    }

    public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE ) {
			redirect(base_url());
		}
		if ($this->session->userdata('id_rol') == FALSE) {
			redirect(base_url());
		}
		// MJ: SE CONSULTA DATA Y MANDA A LA VISTA PARA LLENAR DASHBOARD
		$queryt = $this->home_Model->getTotals(date("m"));
		$querytc = $this->home_Model->getTotalClients(date("Y"));
		$queryto = $this->home_Model->getTotalOrders(date("Y"));

		$tc = array();
		$tmc = array();
		$to = array();
		$tmo = array();

		for($i = 0; $i < COUNT($querytc); $i++){
			$tc[$i]= $querytc[$i]->total;
			$tmc[$i] = $this->formatter->monthFromNumberToLetter($querytc[$i]->month);
		}
		for($i = 0; $i < COUNT($queryto); $i++){
			$to[$i]= $queryto[$i]->total;
			$tmo[$i] = $this->formatter->monthFromNumberToLetter($queryto[$i]->month);
		}

		$datos["total_c"] = $tc;
		$datos["total_mc"] = $tmc;
		$datos["total_o"] = $to;
		$datos["total_mo"] = $tmo;
		$datos["totalc"] = $queryt[0]->total;
		$datos["pc"] = $queryt[0]->porcentaje;
		$datos["totalp"] = $queryt[1]->total;
		$datos["pp"] = $queryt[1]->porcentaje;
		$datos["totale"] = $queryt[2]->total;
		$datos["pe"] = $queryt[2]->porcentaje;
		$datos["totalu"] = $queryt[3]->total;
		$datos["pu"] = $queryt[3]->porcentaje;

		$datos += $this->get_menu->get_menu_data($this->session->userdata('id_rol'));
		$this->load->view('v_Home', $datos);
	}
}
