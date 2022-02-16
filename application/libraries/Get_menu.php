<?php
class Get_Menu{

    private $_CI;
    public function __construct()
    {
        $this->_CI = & get_instance();
        $this->_CI->load->model('home_Model','hm');
    }

    function get_menu_data($id_rol){
        $datos = array();
        $datos['datos2'] = $this->_CI->hm->get_menu($id_rol)->result();
        $datos['datos3'] = $this->_CI->hm->get_children_menu($id_rol)->result();
		$val = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $salida = str_replace('' . base_url() . '', '', $val);
        $datos['datos4'] = $this->_CI->hm->get_active_buttons($salida, $id_rol)->result();        
        return $datos;
    }
}
?>