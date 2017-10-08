<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'user.php';
include_once 'sigmasms.php';
include_once 'password.php';



$APIsetting = json_decode (file_get_contents ('apisetting.json'), TRUE);
$input = filter_input_array(INPUT_GET, $_GET);
$user = new User($input['login']);

if ( !($user->get_user_status() == 0) ){
    $send = new SigmaSMS($APIsetting ['login'], $APIsetting ['API_key']);
    $response = $send->send_sms($APIsetting ['login'], $user->set_new_password());
    echo '104: Новый пароль установлен';
}
else {
    echo '302:Пользователь не зарегистрирован';
}