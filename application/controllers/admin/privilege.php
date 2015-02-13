<?php 
/*
权限管理控制器privilege.php，本身就是做权限控制的，
不能继承自privilege，而是要直接继承自总控制CI_Controller

手册中，辅助函数参考，CAPTCHA函数，使用create_captcha($data)

在网站的根目录下，创建data/captcha的目录
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#权限控制器类
class privilege extends CI_Controller {
	#在构造函数中载入captcha辅助类
	public function __construct(){
		parent::__construct();
		$this->load->helper('captcha');
		$this->load->library('form_validation');
	}

	public function login(){
		// $vals=array(
		// 	'img_path'=>'./data/captcha/',
		// 	'img_url'=>base_url().'data/captcha/',
		// 	'word'=>rand(1000,9999),
		// 	);
		// $data=create_captcha($vals);
		$this->load->view('login.html');
	}

	#生成验证码
	public function code(){
		#调用函数，生成验证码,辅助函数，直接调用，哪些要求的参数，注释掉
		$vals=array(
			'word_length'=>3
			);
		$code=create_captcha($vals);
		#将验证码字符串保存到session当中
		$this->session->set_userdata('code',$code);
	}

	
	#处理登录
	public function signin(){
		#设置验证规则
		$this->form_validation->set_rules('username','用户名','required');
		$this->form_validation->set_rules('password','密码','required');

		#获取表单数据,验证码比较时，一般不区分大小写的，使用strtolower来变成小写的
		$captcha=strtolower($this->input->post('captcha'));

		#获取session中保存的验证码
		$code=strtolower($this->session->userdata('code'));

		if ($captcha === $code) {

			//echo 'OK';
			if($this->form_validation->run() == false){
					$data['url']=site_url('admin/privilege/login');
					$data['message']=validation_errors();
					$data['wait']=3;
					$this->load->view('message.html',$data);

			}else{
				#验证码正确，则需要验证用户名和密码，先死后活法
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				//var_dump($username,$password);
				if($username == 'admin' && $password == '123'){
					//echo 'OK';
					#OK，保存用户信息到session当中，跳转到首页
					$this->session->set_userdata('admin',$username);
					redirect('admin/main/index');
				}
				else{
					//echo 'NO';
					$data['url']=site_url('admin/privilege/login');
					$data['message']='用户名或密码错误，请重新填写';
					$data['wait']=3;
					$this->load->view('message.html',$data);
				}
			}
		}else{
			//echo 'NO';
			#验证码不正确，给出提示页面，然后返回
			$data['url']=site_url('admin/privilege/login');
			$data['message']='验证码错误，请重新填写';
			$data['wait']=3;
			$this->load->view('message.html',$data);
		}
	}

	public function logout(){
		$this->session->unset_userdata('admin');
		$this->session->sess_destroy();
		redirect('admin/privilege/login');
	}


}