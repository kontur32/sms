<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Billing
 *
 * @author Пользователь
 */
class ModelBalance {

    const SENDSMSFEE = 1.5;
    const HLRFEE = 0.6; 
    const SMSLENGHTUTF8 = 132;
    const SMSLENGHTASCII = 132;
    const  MAXSMSLENGHT = 264; //Допутимая длина текста текст смс в байтах 

    public function add_payment($userID, $payment) {
        $datapath = Registry::getInstance()->getResource('setting')['data_path'];
        return self::save_to_file ($datapath.'payment.csv', $userID.','.$payment.','. time()."\n");
    }
    
    public function add_fee($userID, $fee, $action) {
        $datapath = Registry::getInstance()->getResource('setting')['data_path'];
        return self::save_to_file ($datapath.'fee.csv', $userID.','.$fee.','.$action.','. time()."\n");
    }
    
    public function get_user_balance($userID) {
        $total_user_payment = self::get_total_payment($userID);
        $total_user_fee = self::get_total_fee($userID);
        
        if ($total_user_payment && $total_user_fee){
            $result = $total_user_payment - $total_user_fee;
        }
        else {
            $result = FALSE;
        }
        return $result;
    }
    
    public function get_action_price($action, $params) {
        $result = FALSE;
        switch (mb_strtoupper($action)){
            case ('SENDSMS'):
                
                switch (mb_detect_encoding($params['text'])) {
                    case 'ASCII':
                        $sms_lengh = self::SMSLENGHTASCII;
                        break;
                    case 'UTF-8':
                        $sms_lengh = self::SMSLENGHTUTF8;
                        break;
                }
                $result = ( (ceil (strlen($params['text'])/$sms_lengh) == 0 ? 1: ceil (strlen($params['text'])/$sms_lengh)))*self::SENDSMSFEE;
                break;
            
            case ('HLR'):   // запрос статус телефона
                $result = self::HLRFEE;
                break;
        }
        return $result;
    }
    
     
    private function get_total_payment($userID){
        
        $datapath = Registry::getInstance()->getResource('setting')['data_path'];
        $user_payment = array ();
        $total_user_payment = 0;
        
        $total_payment = self::get_csv_file($datapath.'payment.csv', $mode="r");
         
        foreach ($total_payment as $user_payment ) {
            if ($user_payment [0]==$userID){
                $total_user_payment = $total_user_payment + $user_payment[1];
            }
        }
        return $total_user_payment;
    }
    
    private function get_total_fee ($userID){
        $datapath = Registry::getInstance()->getResource('setting')['data_path'];
        $user_fee = array ();
        $total_user_fee = 0;
        
        $total_fee = self::get_csv_file($datapath.'fee.csv', $mode="r");
         
        foreach ($total_fee as $user_fee ) {
            if ($user_fee [0]==$userID){
                $total_user_fee = $total_user_fee + $user_fee[1];
            }
        }
        return $total_user_fee;
    }

    private function get_csv_file($filename, $mode="r") {
        $handle = fopen($filename, $mode); 

        while (($line = fgetcsv($handle, 0, ',')) !== FALSE) {  //Проходим весь csv-файл, и читаем построчно
                $result[] = $line;				//Записываем строки в массив
        }
        fclose($handle); 

        return $result;
    }
    
    private function save_to_file ($filename, $string, $mode = 'a+'){	//Записывает строку в конец файла
        $handle = fopen($filename, $mode);
        fwrite ($handle, $string);
        fclose($handle);
        
        return TRUE;
    }
}
