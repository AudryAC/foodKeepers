<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_menu($rol)
	{
		return $this->db->query("SELECT * FROM menus WHERE id_rol=" . $rol . " order by orden asc");
	}

	function get_children_menu($rol)
	{
		return $this->db->query("SELECT * FROM menus WHERE id_rol=" . $rol . " AND padre > 0 AND estatus = 1 ORDER BY orden ASC");
	}

	function get_active_buttons($var, $rol)
	{
		return $this->db->query("SELECT padre FROM menus WHERE pagina='" . $var . "' AND id_rol=" . $rol . " ");
	}

	public function getTotals($month) // MJ: OBTIENE REGISTROS TOTALES DEL MES ACTUAL Y EL PORCENTAJE GENERADO
	{
		return $this->db->query("SELECT COUNT(*) total, ROUND((COUNT(*) * 100 / (SELECT COUNT(*) FROM clientes)), 0) porcentaje, 'clientes' tabla FROM clientes WHERE MONTH(fecha_creacion) = $month
		UNION ALL
		SELECT COUNT(*) total, ROUND((COUNT(*) * 100 / (SELECT COUNT(*) FROM pedidos)), 0) porcentaje, 'pedidos' tabla FROM pedidos WHERE MONTH(fecha_creacion) = $month
		UNION ALL
		SELECT COUNT(*) total, ROUND((COUNT(*) * 100 / (SELECT COUNT(*) FROM envios)), 0) porcentaje, 'envios' tabla FROM envios WHERE MONTH(fecha_creacion) = $month
		UNION ALL
		SELECT COUNT(*) total, ROUND((COUNT(*) * 100 / (SELECT COUNT(*) FROM usuarios)), 0) porcentaje, 'usuarios' tabla FROM usuarios WHERE MONTH(fecha_creacion) = $month;")->result();
	}

	public function getTotalClients($year) // MJ: OBTIENE REGISTROS TOTALES DEL AÑO ACTUAL AGRUPADO POR MES TBL CLIENTES
	{
		return $this->db->query("SELECT COUNT(*) total, MONTH(fecha_creacion) month, YEAR(fecha_creacion) year FROM clientes WHERE 
		YEAR(fecha_creacion) = $year GROUP BY MONTH(fecha_creacion) ORDER BY YEAR(fecha_creacion), MONTH(fecha_creacion);")->result();
	}

	public function getTotalOrders($year) // MJ: OBTIENE REGISTROS TOTALES DEL AÑO ACTUAL AGRUPADO POR MES TBL PEDIDOS
	{
		return $this->db->query("SELECT COUNT(*) total, MONTH(fecha_creacion) month, YEAR(fecha_creacion) year FROM pedidos WHERE 
		YEAR(fecha_creacion) = $year GROUP BY MONTH(fecha_creacion) ORDER BY YEAR(fecha_creacion), MONTH(fecha_creacion);")->result();
	}

}
