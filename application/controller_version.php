<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of controller-version
 *
 * @author Пользователь
 */
class controller_version {
    public function index (){
        $version = Registry::getInstance()->getResource('setting')['version'];
        if (!empty($version)){
            echo $version;
        }
        else {
            echo 'Версия сервиса не установлена';
        }
    }
}
