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
class controller_main {
    public function index (){
	echo file_get_contents('html/user-info.html');
    }
}
