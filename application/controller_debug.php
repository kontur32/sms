<?php

/**
 * Description of controller-version
 *
 * @author Пользователь
 */
class controller_debug{
    
	public function index (){
		
		include_once 'model_sms.php';
		
		$a = new model_sms();
		
		$params = array(
            'phone'     => '79106679925',
            'text'      => 'Привет',
			'sender'    => $a->default_sender
        );
		
		echo $a->build_GET( $a->api_url['sendURL'], $a->set_params( $params ) ) .'</br>';
		
		echo $a->build_GET( $a->api_url['balanceURL'], $a->set_params() ) .'</br>';
		
		echo $a->get_balance();
		
		$b = '{"79106679925":{"error":"0","id_sms":"5599345210873050470004","cost":1.99,"count_sms":1,"sender":"B-Media","network":null,"ported":false,"dcs":"8"}}';
		
		$out = json_decode($b, TRUE)['79106679925']['error'];
		echo $out;
		
		// echo $a->send_sms( '79106679925', 'Однако, привет!');

    }
}
