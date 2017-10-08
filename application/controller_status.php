<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class controller_status {
    const MINBAL = 100; // минимальная сумма на лицевом счете для включения сервиса
    
    public function index (){
    
        require_once 'model_sms.php';
        $balance = new model_sms();
        $bal_val = json_decode($balance->get_balance(), TRUE)['money'];
        
        $is_on = Registry::getInstance()->getResource('setting')['is_on'];
              
        if ( (float)$bal_val > self::MINBAL && $is_on=='ON'){
            echo '0: SMS шлюз готов к принятию запросов';
        }
        else {
           echo '1: SMS шлюз находится в режиме технического обслуживания';
        }
    }
}

