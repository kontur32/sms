<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'registry.php';
require_once 'application/router.php';
require_once 'password.php';

Registry::getInstance();

Registry::getInstance()->setResource('apisetting', 
        json_decode (file_get_contents ('apisetting.json'), TRUE));
Registry::getInstance()->setResource('setting',
        json_decode (file_get_contents ('setting.json'), TRUE));

Route::start();