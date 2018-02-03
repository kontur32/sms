<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller_sms
 *
 * @author Пользователь
 */
class controller_sms {

    public function send ($params) {
                
        if (isset($params['phone']) && isset($params['text'])){
            if (isset($params['login']) && isset($params['password'])){
                $is_user_login = $this->is_user_login($params['login'], $params['password']);
                if ( $is_user_login === TRUE){
                    $sms = new model_sms();
					$answer = $sms->send_sms($params['phone'], $params['text']);
                    $result = json_decode($answer, TRUE)[0][$params['phone']];
                    
                    if ($result['error'] == '0'){
                    
                                              
                        include_once 'application/billing.php';
                        $fee = new ModelBalance ();
                        $fee_val = $fee->get_action_price('sendsms', $params); // определяет стоимость смс
                        
                        $fee->add_fee($params['login'], $fee_val, 'sendsms'); // записывает стоимость
                        
                        echo '100:Сообщение отправлено&id:' . $result['id_sms'] . '&стоимость:'. $fee_val ;
												
                    }
                    else {
                        echo '400:Ошибка сервиса';
						                    }
                }
            }
            else {
                echo '301:Не указаны пользователь и/или пароль';
            }
        }
        else {
            echo '311:Не указаны телефон получателя и/или текст сообщения';
        }
    }
    
    public function status ($params) {
        
        if (isset($params['id'])){
            if (isset($params['login']) && isset($params['password'])){

                if ($this->is_user_login($params['login'], $params['password']) == 2){
                    $sms = new model_sms();
                    $status = json_decode($sms->get_status($params['id']), TRUE)[$params['id']];
                    if ($status['status'] = 'deliver'){
                        echo '101:Cтатус сообщения&'. 'доставлено:' .  str_replace(':', '-',  $status['time']);
                    }
                    else {
                        echo '101:Cтатус сообщения&'. 'не доставлено'; 
                    }
                }
            }
            else {
                echo '301:Не указаны пользователь и/или пароль';
            }
        }
        else {
            echo '311:Не полные параметры сообщения';
        }
    }
    
    private function is_user_login($login, $password) {
        include_once 'model_user.php';
        
        $user = new User ($login, $password);
        $user_status  = $user->get_user_status();
        $result = FALSE;
        if ($user_status == 2){
                $result = TRUE;
            }
        elseif ($user_status == 1) {
            echo '303:Пользователь не авторизован';
        }
        else {
            echo '302:Пользователь не зарегистрирован';
        }
        return $result;
    }
}
