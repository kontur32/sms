<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * выполняет запросы к сервису SigmaSMS
 *
 * @author SoS
 * 
 * @param string $login - логин пользователя сервисе SigmaSMS
 * @param string $API_key - ключь API на сервисе SigmaSMS
 * @param string $APIsetting - точки доступа к API SigmaSMS в виде строки JSON
 */
class model_sms {
    
    function __construct() {
                       
        $this->login            = Registry::getInstance()->getResource('apisetting')['login'];
        $this->api_key          = Registry::getInstance()->getResource('apisetting')['api_key'];
        $this->default_sender   = Registry::getInstance()->getResource('apisetting')['default_sender'];
        $this->api_url          = Registry::getInstance()->getResource('apisetting')['api_url'];
       
    }
    
    /**
     * Отправляет СМС
     *
     * @param string $phone - телефоны получателя
     * @param string $text - текст сообщения
     * @param string $sender - отправитель из числа зарегистрированных 
     * на сервисе SigmaSMS
     * @return string ответ сервиса SigmaSMS
     */
    
    public function send_sms($phone, $text) {

        $params = array(
            'phone'     => $phone,
            'text'      => $text,
            'sender'    => $this->default_sender // Имя отправителя, установленное в аккаунте
        );
        
        $result = $this->get_request ($this->build_GET ($this->api_url['sendURL'], $this->set_params($params)));  
        
        return $result;
    }

    public function get_balance() { 

        $result = $this->get_request ($this->build_GET ($this->api_url['balanceURL'], $this->set_params()));
        
        return $result;
    }

    public function get_status($id_sms) {

        $response =  $this->get_request ($this->build_GET ($this->api_url['statusURL'], 
                                            $this->set_params(array('state' => $id_sms)))); 

        $result = $response;
        return $result;
    }

    public function build_GET($base_URL, $params = array()) {

        $result = $base_URL . '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        return $result;
    }

    public function set_params($user_params = array()) { // устанавливает значения параметров GET запроса к API SigmaSMS
        $api_params = array(
            'timestamp' => $this->get_request($this->api_url['timestampURL']),
            'login' => $this->login
        );

        $params = array_merge($api_params, $user_params);
        $params['signature'] = $this->signature($params, $this->api_key); 

        return $params;
    }

    private function signature($params, $api_key) { // вычисление сигнатуры для аутентификации в API SigmaSMS
        ksort($params);
        reset($params);

        return md5(implode($params) . $api_key);
    }

    private function get_request($URL) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPGET, TRUE);

        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }

}
