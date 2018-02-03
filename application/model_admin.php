<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * реализует функции администратора сервиса
 *
 * @author Пользователь
 */
class Аdmin {

     public function set_new_user () { 
        
        if ($this->user_status == 0) {
            file_put_contents ('user.csv', $this->userID.",". time() ."\n", FILE_APPEND);
            $this->set_new_password();
            $result = 'Новый пользователь: '.$this->userID."\n";
        }
         else {
            $result = 'Пользователь: '.$this->userID." уже зарегистрирован\n";
        }
        return $result;  
    }
    
    public function unset_user () {
        
    }
}
