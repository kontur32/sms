<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller_user
 *
 * @author Пользователь
 */
class controller_user {
        
    public function balance($params){
        
        if ($balance = User::get_user_balance($params['login'])) {
            echo '103:Баланс пользователя в рублях&баланс:'.$balance;
        }
        else {
            echo '305:Баланс получить не удалось';
        }
    }
    
    public function newpass ($params) {
        if ($newpass = User::set_new_password($params['login'])){
            require_once 'model_sms.php';
            
            $sms = new model_sms();
            if ($sms->send_sms($params['login'], $newpass)){
                echo '104:Новый пароль установлен';
            }
        }
        else {
            echo '304:Новый пароль установить не удалось';
        }
    }
}
