<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'registry.php';

Registry::getInstance();

Registry::getInstance()->setResource('apisetting', 
        json_decode (file_get_contents ('apisetting.json'), TRUE));
Registry::getInstance()->setResource('setting',
        json_decode (file_get_contents ('setting.json'), TRUE));

$app_path = Registry::getInstance()->getResource('setting')['app_path'];
$includes_path = Registry::getInstance()->getResource('setting')['includes_path'];

require_once $app_path . 'router.php';
require_once $includes_path . 'password.php';

Route::start();