<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/***
 * http://jingyan.baidu.com/article/9f63fb91d434b4c8410f0e5a.html
 * php CI 实战教程：[3]Memcached 配置及调用_百度经验.html
 */
if ( !defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$config ['memcached'] = array (
'hostname' => '127.0.0.1',
'port' => 11211,//default port is 11211
'weight' => 1 
);


