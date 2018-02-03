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
class controller_apiinfo {

    public function index () {

        include_once 'Parsedown.php';
        $readme = file_get_contents('README.md');
		$status = file_get_contents("http://od37.ru/sms/status");
		$status_code = ( substr($status, 0 , 1) == 0 ? "green" : "yellow" );
		$version = substr (file_get_contents("http://od37.ru/sms/version"), 0, 7);

        $Parsedown = new Parsedown();

        echo
		'<link rel="stylesheet" type="text/css" href="style.css">'
		.'<div class="block">'
			.'<p><a href="/sms">[на главную]</a></p>'
			.'<p class="' . $status_code . '">Текущий статус: <span>'. substr ($status, 2) .'</span></p>'
			.'<p class="status">Текущая версия: <a href="https://github.com/ivznanie/SMS_Client/raw/dev/clients/MS Excel/Компиляции/SMS_Client/SMS_Client (Клиент отправки произвольных СМС).xlsm">'. $version .'</a></p>'
			. $Parsedown->text($readme)
		.'</div>';
    }
}
