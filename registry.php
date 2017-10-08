<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registry
 *
 * @author Пользователь
 */
class Registry {
    protected static $instance;
    protected $resources = array();
    protected function __construct(){
    }
    protected function __clone(){
    }
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Registry();
        }
        return self::$instance;
    }
    public function setResource($key, $value, $force_refresh = false)
    {
        if (!$force_refresh && isset($this->resources[$key])) {
            throw new RuntimeException('Resource ' . $key . ' has already been set. If you really '
                                       . 'need to replace the existing resource, set the $force_refresh '
                                       . 'flag to true.');
        }
        else {
            $this->resources[$key] = $value;
        }
    }
    public function getResource($key)
    {
        if (isset($this->resources[$key])) {
            return $this->resources[$key];
        }
        throw new RuntimeException ('Resource ' . $key . ' not found in the registry');
    }
    
}
