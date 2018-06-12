<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class controller_status {

    public function index (){

	require_once 'model_sms.php';

	$balance = new model_sms();
	$bal_val = json_decode($balance->get_balance(), TRUE)['money'];

	$is_on = Registry::getInstance()->getResource('setting')['is_on'];
	$min_balance = Registry::getInstance()->getResource('setting')['min_balance'];

        if ( (float)$bal_val > $min_balance && $is_on == 'ON'){ 
            echo '0:SMS шлюз принимает запросы';
        }
        else {
     	   echo '1:SMS шлюз в режиме технического обслуживания';
        }
    }
}
