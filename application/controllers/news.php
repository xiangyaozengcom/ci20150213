<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {
	public function __construct(){
		parent::__construct();
		#载入news_model，载入之后，可以使用$this->user_model来操作
		$this->load->model('news_model');
	}
	//显示添加新闻的表单
	public function add(){
		$this->load->view('add.html');
	}

	//完成新闻的添加
	public function insert(){
		header("Content-type:text/html;charset=utf-8");
		#获取表单提交的数据
		$data['title']=$_POST['title'];
		$data['author']=$_POST['author'];
		$data['content']=$_POST['content'];
		$data['add_time']=time();
		#调用news_model的方法即可
		if ($this->news_model->add_news($data)) {
			echo '添加成功';
		} else {
			echo '添加失败';
		}
	}

	//显示新闻列表
	public function index(){
		#调用list_news方法得到数据，
		$data['newslist']=$this->news_model->list_news();
		#分配到视图
		$this->load->view('list.html',$data);
	}

	



}