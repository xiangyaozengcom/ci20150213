<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");
/*
 * http://blog.zhuyin.org/873.html
 * 【原创】waterfall瀑布流网页实现的设计方案一：Masonry（含loading几次后出现分页）   拒绝平庸的技术博客.html
 * 
 * **/
class testpage20141202 extends CI_Controller {
    
    public function __construct(){
		parent::__construct();
		$this->load->helper('MY_chjsonencode');
                $this->load->helper('url');
	}
        
        public function page1() {
            $this->load->view('test/test_page_20141202.html');
        }
}

