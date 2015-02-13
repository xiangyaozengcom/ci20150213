<?php 
/*
base_url
anchor，直接输出超链接

*/


if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('PRC'); 

class Main extends Admin_Controller {
	#展示后台首页面
	public function index(){
		$this->load->view('index.html');
	}

	#展示头部
	public function top(){
		$this->load->view('top.html');
	}

	#展示菜单
	public function menu(){
		$this->load->view('menu.html');
	}

	#展示拖拽
	public function drag(){
		$this->load->view('drag.html');
	}

	#展示内容
	public function content(){
		$this->load->view('main.html');
	}
}