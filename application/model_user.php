<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Обрабатывает права пользователя
 *
 * @author Пользователь
 * @param string $userID - логин пользователя сервисе
 */


class User {
    
    public function __construct($userID = '', $user_password = '') {
        
        if (!empty($userID)){
            $this->userID = $userID;
            $this->user_password = $user_password;
            //$this->user_status = $this->get_user_status ();
        }
        
        //$this->need_solt = TRUE; //Вынести в ini
        
    }
    
    public function get_user_balance($userID) {
        require 'billing.php';
                
        return ModelBalance::get_user_balance($userID);
    }
    
    public function set_new_password ($userID) {
        $datapath = Registry::getInstance()->getResource('setting')['data_path'];
        $new_password = array ('pass'=>substr(md5(uniqid(rand(),true)), 0, 8), 'time'=>time());
        $need_solt = Registry::getInstance()->getResource('setting')['solt'];
        $result = FALSE;
        
        if (($need_solt == "ON")){
            $hash = crypt($new_password['pass'], uniqid(mt_rand(), true));
        }
	else {
            $hash = crypt($new_password['pass']);
	}
				
        $new_pass_record =  $userID . ','
                    . $new_password['time'] .','
                    . $new_password['pass'] . ',' 
                    . $hash . ','
                    . "\n";
        
        if (file_put_contents ($datapath.'login.csv', $new_pass_record, FILE_APPEND)){
            
            $result = $new_password['pass'];
        } 
        
        return $result;
    }

    public function get_user_status (){ //перенести в Admin
        if ($this->get_user_reg()) {
            $result = 1;
         
            if (($this->get_user_login())) {
                $result = 2;
            }
        }
        else {
            $result = 0;
        }
        
        return $result;
    }
    
    private function get_user_reg (){
        $datapath = Registry::getInstance()->getResource('setting')['data_path'];
        $result = FALSE;
        $file = fopen ($datapath.'user.csv', "r");
        while (($buffer = fgets($file)) !== false) {
            $current = explode(',', $buffer);
            if ($current[0] == $this->userID){
                $result = TRUE;
            }
        }
        fclose($file);
        return $result;
    }
    
    private function get_user_login (){
        $datapath = Registry::getInstance()->getResource('setting')['data_path'];
        $result = FALSE;
        $file = fopen ($datapath.'login.csv', "r");
        while (($buffer = fgets($file)) !== false) {
            $current = explode(',', $buffer);
            if ($current[0] == $this->userID){
                $the_last_login = $current;
            }
        }
            fclose($file);
		
            if (isset ($the_last_login[3]) &&
                    password_verify($this->user_password, $the_last_login[3])){
                $result = TRUE; 
            }
        return $result;
    }
    
}
