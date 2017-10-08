<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller_model
 *
 * @author Пользователь
 */
class controller_main {
    
    public function index () {
        
        include_once 'Parsedown.php';
        $readme = file_get_contents('readme.md');
            
        $Parsedown = new Parsedown();

        echo $Parsedown->text($readme);
    }
}
