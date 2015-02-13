
<?php 
/*
在/CodeIgniter20141116/index.php中
	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (realpath($system_path) !== FALSE)
	{
		$system_path = realpath($system_path).'/';
	}

	// ensure there's a trailing slash
	$system_path = rtrim($system_path, '/').'/';

	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}
	

	// Path to the system folder
	define('BASEPATH', str_replace("\\", "/", $system_path));

*/
	/*
	命名规范，如果使用别人的框架，尽量遵守别人制定的规范，入乡随俗
	控制器，是一个类，类名首字母大写，多个词之间下划线，
	类中的方法名小写，多个单词之间下划线
	类的文件名，小写
	*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('PRC'); 

class Hello extends CI_Controller {

	public function index()
	{
		echo 'Hello'.date('Y-m-d H:i:s',time()).'CodeIgniter';
		$data['title']='CodeIgniter框架';
		$data['content']='CodeIgniter 是一个小巧但功能强大的 PHP 框架，作为一个简单而“优雅”的工具包，它可以为 PHP 程序员建立功能完善的 Web 应用程序。';

		$this->load->view('hello.html',$data);
	}
	public function qqci(){
		echo substr('finecms',0,4);
	}
}

