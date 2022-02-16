<?php
class formatter{

    private $_CI;
    public function __construct()
    {
        $this->_CI = & get_instance();
    }

    function removePhoneFormat($input){ // MJ: REMUEVE ESPACIOS EN BLANCO, ., ( Y )
		$search  = array('(', ')', '-', ' ');
		$replace = array('');
		$subject = $input;
		return str_replace($search, $replace, $subject);
    }

    function monthFromNumberToLetter($month){ // MJ: CONVIERTE EL MES EN NÚMERO A LETRA
		$date = DateTime::createFromFormat('!m', $month);
		$final_month = strftime("%B", $date->getTimestamp());
		return $final_month;
	}
}
?>
