<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader{
	//这里比较简单的方式，正式的应该写在配置文件夹中
	protected $_theme='default';
	#开启皮肤功能
	public function switch_themes_on(){
		$this->_ci_view_paths = array(FCPATH.THEMES_DIR.$this->_theme	=> TRUE);
	}
	#关闭皮肤功能
	public function switch_themes_off(){
		#just do nothing
	}
}